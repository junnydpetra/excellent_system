<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataToReactController;

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
Route::get('/consulta-cnpj/{cnpj}', [ClientController::class, 'consultaCNPJ']);
Route::get('/clients', [DataToReactController::class, 'getClients']);
Route::get('/products', [DataToReactController::class, 'getProducts']);
Route::get('/orders', [DataToReactController::class, 'getOrders']);
Route::post('/orders', [DataToReactController::class, 'createOrder']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
