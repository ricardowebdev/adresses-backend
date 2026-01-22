<?php

namespace App\Repositories\Contracts;

use App\Models\Chave;
use App\Repositories\Contracts\BaseInterface;

interface EnderecoRepositoryInterface extends BaseInterface
{
    public function buscaTodos(Array $nome = []);

    public function comRemovidos(Array $nome = []);

    public function exibeEndereco($id);
}
