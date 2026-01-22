<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = '_id';
    protected $connection = 'mongodb';

    protected $fillable = [
        'tipo',
        'acao',
        'arquivo',
        'descricao',
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];


    public function resolveRouteBinding($value, $field = null)
    {
        if (in_array(Route::currentRouteName(), ['logs.show'])) {
            return \App\Models\Log::find($value);
        }
        return parent::resolveRouteBinding($value, $field);
    }
}
