<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class addressMongo extends Model
{
    use HasFactory;
    // protected $connection = 'mongodb';
    // protected $collection = 'address';

    protected $table = 'address_mongos';
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'cep',
        'estado',
        'cidade',
        'bairro',
        'endereco',
        'numero',
        'nome_contato',
        'email_contato',
        'telefone_contato',
        'legacy_id'
    ];    
}
