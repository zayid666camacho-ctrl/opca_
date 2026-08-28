<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrecioBaseController;
use App\Http\Controllers\TipoServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

Route::resource('clientes', ClienteController::class);
Route::resource('tipo_servicio', TipoServicioController::class);
Route::resource('precio_bases', PrecioBaseController::class);
Route::resource('pedidos', PedidoController::class);

