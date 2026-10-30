<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrecioBaseController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SitioPublicoController;
use App\Http\Controllers\TipoServicioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas (sin sesión)
|--------------------------------------------------------------------------
| Lo único que ve el visitante. El inicio de sesión (/login) vive en routes/seguridad.php.
*/
Route::get('/', [SitioPublicoController::class, 'index'])->name('sitio.index');
Route::get('/trabajos', [SitioPublicoController::class, 'galeria'])->name('sitio.galeria');
Route::get('/tarifas', [SitioPublicoController::class, 'precios'])->name('sitio.precios');

Route::get('/mi-pedido', [SitioPublicoController::class, 'estado_pedido'])->name('sitio.estado_pedido');

/*
|--------------------------------------------------------------------------
| Panel de administración (requiere sesión iniciada)
|--------------------------------------------------------------------------
| Si no hay sesión, Laravel redirige automáticamente a la ruta 'login'.
*/
Route::middleware('auth')->group(function () {

    // El Calendario es la pantalla principal del panel de administración
    Route::redirect('/admin', '/calendario');
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
    Route::get('/clientes/buscar-json', [ClienteController::class, 'buscar_json'])->name('clientes.buscar_json');
    Route::resource('clientes', ClienteController::class)->names('clientes')->middleware('modulo:clientes');

    Route::resource('tipo_servicio', TipoServicioController::class);
    Route::resource('precio_bases', PrecioBaseController::class);

    // Pedidos: las rutas específicas van ANTES del resource para que no se confundan con un id
    Route::get('/pedidos/nuevo', [PedidoController::class, 'nuevo'])->name('pedidos.nuevo');
    Route::post('/pedidos/guardar', [PedidoController::class, 'guardar'])->name('pedidos.guardar');
    Route::get('/pedidos/kanban', [PedidoController::class, 'kanban'])->name('pedidos.kanban');
    Route::get('/pedidos/filtrar', [PedidoController::class, 'filtrar'])->name('pedidos.filtrar');
    Route::patch('/pedidos/{id}/estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
    Route::patch('/pedidos/{id}/medidas', [PedidoController::class, 'actualizar_medidas'])->name('pedidos.medidas');

    // La creación de pedidos se hace solo por el flujo guiado (pedidos.nuevo / pedidos.guardar)
    Route::resource('pedidos', PedidoController::class)->except(['create', 'store']);

    Route::resource('servicios', ServicioController::class);

    Route::get('/perfil-taller', [SitioPublicoController::class, 'perfil_taller'])->name('taller.perfil');
    Route::put('/perfil-taller', [SitioPublicoController::class, 'actualizar_perfil_taller'])->name('taller.perfil.actualizar');

    Route::get('/finanzas/exportar', [FinanzaController::class, 'exportar'])->name('finanzas.exportar');
    Route::resource('finanzas', FinanzaController::class)->only(['index', 'store', 'destroy']);

    Route::resource('inventario', InventarioController::class);

    Route::patch('/galeria/{id}/visibilidad', [GaleriaController::class, 'toggle_visibilidad'])->name('galeria.visibilidad');
    Route::resource('galeria', GaleriaController::class)->only(['index', 'store', 'update', 'destroy']);
});
