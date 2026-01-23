<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\WarningException;
use App\Traits\Answerable;
use App\Repositories\EnderecoRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Exports\EnderecoExport;
use Maatwebsite\Excel\Facades\Excel;

class EnderecoService
{
    use Answerable;

    public function __construct(protected EnderecoRepository $_repository){}

    public function index(Array $filter = [])
    {
        $data = isset($filter['inativas']) && $filter['inativas'] ? $this->_repository->comRemovidos($filter) : $this->_repository->buscaTodos($filter);
        return self::answer(self::$ANSWER_SUCCESS, trans('forms.listing.success'), Response::HTTP_OK, ['data' => $data]);
    }

    public function show(string $id)
    {
        try {
            $data = $this->_repository->exibeEndereco($id);

            if (is_null($data))
                throw new WarningException(trans('forms.record_not_found'),Response::HTTP_NOT_FOUND);

            return self::answer(self::$ANSWER_SUCCESS, trans('forms.listing.success'), Response::HTTP_OK, ['data' => $data]);
        } catch (WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return self::answer(self::$ANSWER_ERROR, trans('forms.listing.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(array $dados)
    {
        try {
            $data = $this->_repository->exibeEndereco($dados['cep'], $dados['numero']);

            if (!empty($data->id))
                throw new WarningException(trans('validation.key_id_already_exists'), Response::HTTP_BAD_REQUEST);

            $dados['logradouro'] = strtolower($dados['logradouro']);
            $dados['nome'] = strtolower($dados['nome']);

            $data = $this->_repository->create($dados);
            return self::answer(self::$ANSWER_SUCCESS, trans('forms.insert.success'), Response::HTTP_CREATED, ['data' => $data]);
        } catch(WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            LogService::grava('error', 'create.endereco', __CLASS__.':'.__LINE__, $e->getMessage());
            return self::answer(self::$ANSWER_ERROR, trans('forms.insert.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(array $dados, $id): array
    {
        try {
            $data = $this->_repository->exibeEndereco($id);

            if (is_null($data))
                throw new WarningException(trans('forms.record_not_found'), Response::HTTP_NOT_FOUND);

            $this->_repository->update($dados, $id);
            $data = $this->_repository->exibeEndereco($id);

            return self::answer(self::$ANSWER_SUCCESS, trans('forms.update.success'), Response::HTTP_OK, ['data' => $data]);
        } catch(WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            LogService::grava('error', 'update.endereco', __CLASS__.':'.__LINE__, $e->getMessage());
            return self::answer(self::$ANSWER_ERROR, trans('forms.update.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->_repository->findWithTrashed($id);
            $message = trans('forms.inactive.success');

            if(is_null($data))
                throw new WarningException(trans('validation.record_not_found'), Response::HTTP_NOT_FOUND);

            if ($data->deleted_at !== null) {
                $data->deleted_at = null;
                $data->save();
                $message = trans('forms.active.success');
            } else {
                $this->_repository->delete($id);
                $message = trans('forms.inactive.success');
            }

            LogService::grava('info', 'destroy.endereco', __FILE__.':'.__LINE__,'remoção de endereco: '.$id);
            return self::answer(self::$ANSWER_SUCCESS, $message, Response::HTTP_OK);
        } catch(WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            LogService::grava('error', 'destroy.endereco', __CLASS__.':'.__LINE__, $e->getMessage());
            return self::answer(self::$ANSWER_ERROR, trans('forms.inactive.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function enviaParaDiscord(array $data) :void
    {
        $hasCache = Cache::has('discord_'.$data['id'] ?? '');
        if ($hasCache)
            return;

        $webhookUrl = env('WEBHOOK_DISCORD_URL');
        $message = "**Notificação de Endereco**\n"
            . "**Endereco:** {$data['logradouro']} - {$data['cidade']} - {$data['uf']}.\n";

        try {
            Http::post($webhookUrl, [
                'content' => $message
            ]);
            Cache::put('discord_'.$data['id'], "1", 60 * 60 * 12);
            return;
        } catch (\Exception $e) {
            return;
        }
    }

    public function excel(Array $filter = [])
    {
        try {
            return Excel::download(new EnderecoExport($filter), 'enderecos.xlsx');
        } catch(\Exception $e) {
            LogService::grava(Auth::id() ?? 1, 'error', 'excel.endereco', __CLASS__.':'.__LINE__, $e->getMessage());
            return self::answer(self::$ANSWER_ERROR, trans('forms.update.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}