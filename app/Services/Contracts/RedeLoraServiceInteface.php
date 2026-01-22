<?php

namespace App\Services\Contracts;

use \App\Models\Chave;
use \App\Models\Comando;

Interface RedeLoraServiceInteface
{
    public function preparaComando(Comando $comando, Chave $chave) : array;

    public function recebeRequest(array $request) : array;

}