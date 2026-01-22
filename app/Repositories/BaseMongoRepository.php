<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

abstract class BaseMongoRepository extends BaseRepository
{
    const DEFAULT_PAGINATOR_LIMIT = 20;

    public function setCollectionName($name){
        $this->_model->setTable($name);
        return $this->_model;
    }

    public function getCollectionName(){
        return $this->_model->getTable();
    }

    public function dropCollection(){
        Schema::connection(
            $this->_model->getConnection()->getName()
        )->drop(self::getCollectionName());
    }

    public function renameCollection($new_name){
        $database = config('database.connections.mongodb.database');

        return DB::connection( $this->_model->getConnection()->getName())->getMongoClient()->admin->command([
            'renameCollection' => "{$database}.{$this->getCollectionName()}",
            'to' => "{$database}.{$new_name}",
        ]);
    }
}