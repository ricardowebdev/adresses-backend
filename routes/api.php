<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\StatesControllers;


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

Route::get('/states', [StatesControllers::class, 'index']);
Route::get('/adress', [AdressController::class, 'index']);
Route::post('/adress', [AdressController::class, 'add']);
Route::put('/adress/{id}', [AdressController::class, 'update']);
Route::delete('/adress/{id}', [AdressController::class, 'delete']);
Route::get('/adress/{id}', [AdressController::class, 'get']);


