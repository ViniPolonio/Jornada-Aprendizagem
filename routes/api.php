<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');
Route::post('/create', [App\Http\Controllers\UserController::class, 'create']);


//Rota Post que recebe os dados do ASP-arduino e salva no banco de dados
Route::post('/monitoring-plans', [App\Http\Controllers\MonitoringPlansController::class, 'store']);
Route::resource('/plantas', App\Http\Controllers\PlantasController::class);