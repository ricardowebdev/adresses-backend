<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\WarningException;
use App\Models\Comando;
use App\Traits\Answerable;
use App\Repositories\ChaveRepository;
use App\Repositories\ComandoRepository;
use App\Repositories\MedidaRepository;
use App\Repositories\RedeLoraRepository;
use Illuminate\Support\Facades\Cache;
use App\Services\Comunicadores\ChirpStackService;
use App\Services\Comunicadores\TTNService;
use App\Services\CurlService;

class ComandoService
{
    use Answerable;

    const STATUS     = 'REFET1M=';
    const TENTATIVAS = 3;

    public function __construct(
        protected ChaveRepository $_chave_repository,
        protected ComandoRepository $_repository,
        protected MedidaRepository $_medida_repository,
        protected RedeLoraRepository $_rede_repository,
        protected CurlService $_curl_service,
        protected DeparaService $deparaService
    ){}

    public function recebeComando(Array $dados)
    {
        try {
            $chave = $this->_chave_repository->exibeChave($dados['id_chave']);
            if (is_null($chave))
                throw new WarningException(trans('forms.record_not_found'),Response::HTTP_NOT_FOUND);

            $dados = $this->deparaService->dePara($dados['tipo']);
            $data = [
                'id_chave'   => $chave->deveui,
                'tipo'       => $dados['comando'],
                'status'     => 'Received',
                'id_usuario' => Auth::id(),
                'usuario'    => Auth::user()->nome,
                'chave'      => $chave->name,
                'observacao' => '',
                'versao'     => "1",
                'fPort'      => 3,
                'valor'      => $dados['valor'] ?? "00"
            ];
            
            $data = $this->_repository->create($data);
            if ($data)
                $this->processa($data);

            return self::answer(self::$ANSWER_SUCCESS, trans('forms.insert.success'), Response::HTTP_CREATED, ['data' => $data]);
        } catch (WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return self::answer(self::$ANSWER_ERROR, $e->getMessage(), $e->getCode());
        }
    }

    public function processa($comando = [])
    {               
        $statusDisjuntor = 0;
        $statusComando   = 0;
        $ultimaLeitura   = 0;
        try {
            if (!$comando)
                $comando = $this->_repository->findFirst(['status', '=', 'Received']);
            if (empty($comando->id))
                throw new WarningException(trans('forms.record_not_found'), Response::HTTP_NOT_FOUND);

            $comando->status = 'Processing';
            $comando->update();

            $chave   = \App\Models\Chave::where('deveui', '=', $comando->id_chave)->first();
            $request = $this->geraRequisicao($comando, $chave);
            
            $ultimaLeitura   = $this->_medida_repository->lastFromChaves($comando->id_chave, 1);
            $ultimaLeitura   = isset($ultimaLeitura[0]->id) ? $ultimaLeitura[0]->id : 0;
            $statusDisjuntor = $chave->status_disjuntor;
            $statusComando   = $chave->status_comando;

            $i = 0;
            $status = 0;

            while ($i < self::TENTATIVAS) {
                $i++;
                $result = $this->_curl_service->request($request['url'], 'POST', $request['payload'], $request['headers']);
                
                $status = $result['code'] ?? 500;
                if ($result['code'] == "200") {
                    sleep(7);

                    if ($comando->tipo == self::STATUS) {                        
                        $leitura = $this->_medida_repository->lastFromChaves($comando->id_chave, 1);
                        if (isset($leitura[0]->id) && $leitura[0]->id > $ultimaLeitura) {
                            $this->atualizaComando($comando, '200 - Comando enviado com sucesso', $i, 'SUCCESS');
                            return;    
                        }
                    } else {
                        $chave = \App\Models\Chave::where('deveui', '=', $comando->id_chave)->first();
                        if ($statusDisjuntor != $chave->status_disjuntor 
                            || $statusComando != $chave->status_comando) {
                                $this->atualizaComando($comando, '200 - Comando enviado com sucesso', $i, 'SUCCESS');
                                return;
                        }
                    }
                }
            }

            if ($status == 200) {
                $this->atualizaComando($comando, '200 - Comando enviado com sucesso, porém ainda não recebemos resposta do dispositivo', $i, 'SUCCESS');
                return;
            }

            throw new \Exception('400 - Falha ao enviar o comando', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $this->atualizaComando($comando, '400 - Falha ao enviar o comando', $comando->tentativas + 1, 'ERROR');
            LogService::grava(Auth::id() ?? 1, 'error', 'tratacomando', $e->getFile().':'.$e->getLine(), $e->getMessage());
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function lista(Array $filtros)
    {
        if (!empty($filtros['tipo'])) {
            $dados = $this->deparaService->dePara($filtros['tipo']);
            $filtros['tipo'] = $dados['comando'];
        }

        $comandos = $this->_repository->lista($filtros);
        $result = [];
        $i = 0;

        foreach($comandos as $comando) {
            if (Cache::has('chave_'.$comando->id_chave)) {
                $chave = Cache::get('chave_'.$comando->id_chave);
            } else {
                $chave = \App\Models\Chave::where('deveui', '=', $comando->id_chave)->first();
                Cache::put('chave_'.$comando->id_chave, $chave, 600);
            }

            if (empty($chave->id_cliente)) {
                unset($comandos[$i]);
                $i++;
                continue;
            }

            if ($chave->id_cliente != Auth::user()->id_cliente && Auth::user()->id_perfil != 1) {
                unset($comandos[$i]);
                $i++;
                continue;
            }
                
            $comando->tipo = $this->deparaService->paraDe($comando->tipo);
            $result[] = $comando;
            $i++;
        }

        return self::answer(self::$ANSWER_SUCCESS, trans('forms.listing.success'), Response::HTTP_OK, ['data' => $result]);
    }

    private function geraRequisicao(Comando $comando, $chave) : array
    {
        $rede = \App\Models\RedeLora::find($chave->id_rede_lora);
        if (isset($rede->general_1) && $rede->general_1 == 'Chirpstack')
            $service = app(ChirpStackService::class);
        else {
            $service = $chave->id_rede_lora == app(RedeLoraService::class)::CHIRP
                ? app(ChirpStackService::class)
                : app(TTNService::class);
        }

        return $service->preparaComando($comando, $chave);
    }

    private function atualizaComando(Comando $comando, $descricao =  '', $tentativas = 1, $status = '')
    {
        if ($status)
            $comando->status = $status;

        $comando->observacao = $descricao;
        $comando->tentativas = $tentativas;
        return $comando->save() ? true : false;
    }
}
