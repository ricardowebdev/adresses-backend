<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\StatesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/states', [StatesController::class, 'index']);
Route::get('/address', [AdressController::class, 'index']);
Route::post('/address', [AdressController::class, 'add']);
Route::put('/address/{id}', [AdressController::class, 'update']);
Route::delete('/address/{id}', [AdressController::class, 'delete']);
Route::get('/address/{id}', [AdressController::class, 'get']);


