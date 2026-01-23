<?php

namespace App\Repositories;

use App\Models\Endereco;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\EnderecoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EnderecoRepository extends BaseRepository implements EnderecoRepositoryInterface
{

    protected  \Illuminate\Database\Eloquent\Model|string $_model = Endereco::class;

    public function buscaTodos($filtros = [])
    {
        $query =  DB::table($this->_model->getTable() . ' as e')
            ->select([
                'e.id',
                'e.cep',
                'e.uf',
                'e.cidade',
                'e.bairro',
                'e.logradouro',
                'e.numero',
                'e.nome',
                'e.telefone',
                'e.email',
                'e.created_at',
                'e.deleted_at'
            ])
            ->whereNull('e.deleted_at');
            
        if (!empty($filtros['nome']))
            $query->where('e.nome', 'LIKE',  '%'.$filtros['nome'].'%');
        if (!empty($filtros['logradouro']))
            $query->where('e.logradouro', 'LIKE',  '%'.$filtros['logradouro'].'%');
        if (!empty($filtros['cep']))
            $query->where('e.cep', '=',  $filtros['cep']);
        if (!empty($filtros['uf']))
            $query->where('e.uf', '=',  $filtros['uf']);
        if (!empty($filtros['cidade']))
            $query->where('e.cidade', '=',  $filtros['cidade']);        

        return $query->orderBy('e.logradouro', 'asc')->get();
    }

    public function comRemovidos($filtro = '', $ativos = 0)
    {
        $query =  DB::table($this->_model->getTable() . ' as e')
            ->select([
                'e.id',
                'e.cep',
                'e.uf',
                'e.cidade',
                'e.bairro',
                'e.logradouro',
                'e.numero',
                'e.nome',
                'e.telefone',
                'e.email',
                'e.created_at',
                'e.deleted_at'
            ]);

        if (!empty($filtros['nome']))
            $query->where('e.nome', 'LIKE',  '%'.$filtros['nome'].'%');
        if (!empty($filtros['logradouro']))
            $query->where('e.logradouro', 'LIKE',  '%'.$filtros['logradouro'].'%');
        if (!empty($filtros['cep']))
            $query->where('e.cep', '=',  $filtros['cep']);

        return $query->orderBy('e.logradouro', 'asc')->get();
    }

    public function exibeEndereco($id)
    {
        $query =  DB::table($this->_model->getTable() . ' as e')
        ->select([
            'e.id',
            'e.cep',
            'e.uf',
            'e.cidade',
            'e.bairro',
            'e.logradouro',
            'e.numero',
            'e.nome',
            'e.telefone',
            'e.email'
        ])
        ->whereNull('e.deleted_at')
        ->where('e.id', $id);
        
        return $query->get()->first();
    }

    public function excel($filtros = [])
    {
        $query =  DB::table($this->_model->getTable() . ' as e')
            ->select([
                'e.id',
                'e.cep as Cep',
                'e.uf as UF',
                'e.cidade as Cidade',
                'e.bairro as Bairro',
                'e.logradouro as Logradouro',
                'e.numero as Numero',
                'e.nome as Nome',
                'e.telefone as Telefone',
                'e.email as E-mail',
                'e.created_at as Registrado_em',
                'e.deleted_at as Removido_em'
            ]);

        if (!empty($filtros['nome']))
            $query->where('e.nome', 'LIKE',  '%'.$filtros['nome'].'%');
        if (!empty($filtros['logradouro']))
            $query->where('e.logradouro', 'LIKE',  '%'.$filtros['logradouro'].'%');
        if (!empty($filtros['cep']))
            $query->where('e.cep', '=',  $filtros['cep']);

        return $query->orderBy('e.logradouro', 'asc')->get();            

    }
    
}
