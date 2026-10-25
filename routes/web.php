<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrecioBaseController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SitioPublicoController;
use App\Http\Controllers\TipoServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SitioPublicoController::class, 'index'])
        ->name('sitio.index');

Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
Route::get('/clientes/buscar-json', [ClienteController::class, 'buscar_json'])->name('clientes.buscar_json');
Route::get('/pedidos/nuevo', [PedidoController::class, 'nuevo'])->name('pedidos.nuevo');

Route::get('/clientes/buscar-json', [ClienteController::class, 'buscar_json'])->name('clientes.buscar_json');
Route::get('/pedidos/nuevo', [PedidoController::class, 'nuevo'])->name('pedidos.nuevo');

Route::resource('clientes', ClienteController::class)->names('clientes') ->middleware('modulo:clientes'); 

Route::resource('tipo_servicio', TipoServicioController::class);
Route::resource('precio_bases', PrecioBaseController::class);

Route::post('/pedidos/guardar', [PedidoController::class, 'guardar'])->name('pedidos.guardar');
Route::get('/pedidos/kanban', [PedidoController::class, 'kanban'])->name('pedidos.kanban');
Route::get('/pedidos/filtrar', [PedidoController::class, 'filtrar'])->name('pedidos.filtrar');
Route::patch('/pedidos/{id}/estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
Route::patch('/pedidos/{id}/medidas', [PedidoController::class, 'actualizar_medidas'])->name('pedidos.medidas');
Route::post('/pedidos/guardar', [PedidoController::class, 'guardar'])->name('pedidos.guardar');

Route::resource('pedidos', PedidoController::class);

Route::resource('servicios', ServicioController::class);

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
Route::view('/configuracion', 'configuracion.index')->name('configuracion.index');

Route::resource('finanzas', FinanzaController::class)->only(['index', 'store', 'destroy']);
Route::get('/finanzas/exportar', [FinanzaController::class, 'exportar'])->name('finanzas.exportar');

Route::resource('inventario', InventarioController::class);
