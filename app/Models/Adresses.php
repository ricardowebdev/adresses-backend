<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresses extends Model
{
    use HasFactory;
    protected $table = 'adresses';
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
    ];
}
