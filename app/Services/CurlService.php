<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\WarningException;
use App\Traits\Answerable;

class CurlService
{
    use Answerable;

    public function __construct() {}

    public function request(string $url, string $method = 'GET', array $dados = [], array $header = [])
    {
        try {
            $code = $this->geraRequest($url, $method, $dados, $header);
            $response = $code == "200" ? 'Comando enviado com sucesso' : 'Ocorreram erros ao enviar o comando';

            return [
                'message' => $response,
                'code'    => $code
            ];        
        } catch (\Exception $e) {
            LogService::grava(Auth::id() ?? 1, 'error', 'curl.request', __CLASS__.':'.__LINE__, $e->getMessage());
            return [
                'message' => $e->getMessage(),
                'code'    => 500
            ];
        }
    }

    private function geraRequest($url, $method = 'GET', $dados = '', $header = '')
    {
        $curl = curl_init();        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpCode != "200" && $httpCode != "201" && $httpCode != "202") {
            if (curl_errno($curl))
                $error = curl_error($curl);

            LogService::grava(
                Auth::id() ?? 1,
                'warning',
                'error_response',
                'curl.gerarequest',
                json_encode([$response, $httpCode, $error ?? ''])
            );

            LogService::grava(
                Auth::id() ?? 1,
                'info',
                'error_sent',
                'curl.gerarequest',
                json_encode([$url, $method, $dados, $header])
            );

            curl_close($curl);
            return $httpCode;
        }

        LogService::grava(
            Auth::id() ?? 1,
            'info',
            'success_sent',
            'curl.gerarequest',
            json_encode([$url, $method, $dados, $header])
        );

        curl_close($curl);
        return $httpCode;
    }

    public function makeRequest($url, $method = 'GET', $dados = [], $token = '')
    {
        $token = $token ?: env('TTN_KEY');
        $curl = curl_init();

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false
        ];

        if (strtoupper($method) !== 'GET' && !empty($dados)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($dados);
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return [
                'response' => $error,
                'error'    => $error,
                'code'     => $httpCode
            ];
        }

        curl_close($curl);
        return [
            'response' => json_decode($response, true),
            'code'     => $httpCode
        ];
    }
}
