<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\WarningException;
use App\Traits\Answerable;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Http;
use App\Models\Log;

class LogService
{
    use Answerable;

    private $_repository;

    public function __construct(LogRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function lista(array $filters)
    {
        try {
            $logs = $this->_repository->buscarTodos($filters);
            return self::answer(self::$ANSWER_SUCCESS, trans('forms.successful_listing'), Response::HTTP_OK, ['data' => $logs]);
        } catch (\Exception $e) {
            return self::answer(self::$ANSWER_ERROR, trans('forms.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }   
    }

    public function exibir($id): array
    {
        try {
            $log = $this->_repository->logDetalhes($id);

            if(!$log)
                throw new WarningException(trans('validation.record_not_found'), Response::HTTP_NOT_FOUND);
            return self::answer(self::$ANSWER_SUCCESS, null, Response::HTTP_OK, ['data' => $log]);
        } catch(WarningException $e) {
            return self::answer(self::$ANSWER_WARNING, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return self::answer(self::$ANSWER_ERROR, trans('forms.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public static function grava($tipo, $acao, $arquivo, $descricao)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $dados = [
            'tipo' => $tipo,
            'acao' => $acao,
            'arquivo' => $arquivo,
            'descricao' => $descricao
        ];

        self::registra($dados);
    }

    public static function registra(array $dados)
    {
        try {
            if (empty($dados['acao']) || empty($dados['arquivo']) || empty($dados['descricao']))
                return;
            
            $dados = [
                'tipo'       => $dados['tipo']  ?? 'error',
                'acao'       => $dados['acao'],
                'arquivo'    => $dados['arquivo'],
                'descricao'  => $dados['descricao']
            ];

            if ($dados['tipo'] == 'error') {
                self::enviaParaDiscord($dados);
            }
            return Log::create($dados);
        } catch(\Exception $e) {
            $dados  =  [
                'tipo'       => 'error',
                'acao'       => 'registra',
                'arquivo'    => $e->getFile().':'.$e->getLine(),
                'descricao'  => $e->getMessage(),
            ];

            return Log::create($dados);
            self::enviaParaDiscord($dados);
        }
    }

    public static function enviaParaDiscord(array $dados) : void
    {
        $webhookUrl = env('WEBHOOK_DISCORD_URL');
        $message = "**Log IluminSystem**\n"
            . "**Tipo:** {$dados['tipo']}\n"
            . "**Ação:** {$dados['acao']}\n"
            . "**Arquivo:** {$dados['arquivo']}\n"
            . "**Descrição:** {$dados['descricao']}";

        try {
            Http::post($webhookUrl, [
                'content' => $message
            ]);
        } catch (\Exception $e) {
            return;
        }
    }
}
