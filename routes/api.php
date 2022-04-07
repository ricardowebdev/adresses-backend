<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\AddressMongoController;


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

Route::get('/mongo/address', [AddressMongoController::class, 'index']);
Route::post('/mongo/address', [AddressMongoController::class, 'add']);
Route::put('/mongo/address/{id}', [AddressMongoController::class, 'update']);
Route::delete('/mongo/address/{id}', [AddressMongoController::class, 'delete']);
Route::get('/mongo/address/{id}', [AddressMongoController::class, 'get']);



