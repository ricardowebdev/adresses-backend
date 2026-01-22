<?php

namespace App\Repositories;

use \App\Models\Log;

class LogRepository extends BaseMongoRepository
{
    protected \Illuminate\Database\Eloquent\Model|string $_model = Log::class;

    public function buscarTodos(array $filters = [])
    {
        return  $this->_model
            ->orderBy('created_at', 'desc')
            ->limit(2000)
            ->get();
    }

    public function buscarErros(string $data)
    {
        return  $this->_model
            ->where('tipo', '=', 'error')
            ->where('created_at', '>=', $data)
            ->orderBy('created_at', 'desc')
            ->limit(2000)
            ->get();
    }

    public function logDetalhes($id)
    {
        return  $this->_model->find($id);
    }

    public function buscaParaExcluir($data)
    {
        $logs = $this->_model
            ->where('created_at', '<', $data)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $logs->pluck('_id');            
    }

    public function logsError()
    {
        $logs = $this->_model
        ->select(['id', 'created_at', 'descricao'])
        ->where('tipo', '=', 'error')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
        return $logs;       
    }
}
