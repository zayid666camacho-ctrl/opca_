<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrecioBaseController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TipoServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');

Route::resource('clientes', ClienteController::class);
Route::resource('tipo_servicio', TipoServicioController::class);
Route::resource('precio_bases', PrecioBaseController::class);

Route::get('/pedidos/kanban', [PedidoController::class, 'kanban'])->name('pedidos.kanban');
Route::get('/pedidos/filtrar', [PedidoController::class, 'filtrar'])->name('pedidos.filtrar');
Route::patch('/pedidos/{id}/estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
Route::patch('/pedidos/{id}/medidas', [PedidoController::class, 'actualizar_medidas'])->name('pedidos.medidas');

Route::resource('pedidos', PedidoController::class);

Route::resource('servicios', ServicioController::class);

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
Route::view('/configuracion', 'configuracion.index')->name('configuracion.index');

Route::resource('finanzas', FinanzaController::class)->only(['index', 'store', 'destroy']);