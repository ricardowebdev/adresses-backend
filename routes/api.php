<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('enderecos', \App\Http\Controllers\EnderecoController::class)->only(['index', 'store', 'update', 'destroy', 'show'])->parameters(['enderecos' => 'endereco']);
Route::post('enderecos/excel', [\App\Http\Controllers\EnderecoController::class, 'excel']);
Route::apiResource('logs', \App\Http\Controllers\LogController::class)->only(['index', 'show'])->parameters(['logs' => 'log']);

