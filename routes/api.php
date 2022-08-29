<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\ProductoController;

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

Route::post('registrar', [UserController::class, 'registrar']);
Route::post('iniciarsesion', [UserController::class, 'iniciarsesion']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::post('crear', [ProductoController::class, 'crear']);
    Route::post('editar', [ProductoController::class, 'editar']);
    Route::post('borrar', [ProductoController::class, 'borrar']);
    Route::post('agregar', [ProductoController::class, 'agregar']);
    Route::get('mostrar', [ProductoController::class, 'mostrar']);
    Route::get('salir', [UserController::class, 'salir']);
    Route::get('eliminar', [UserController::class, 'eliminar']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
