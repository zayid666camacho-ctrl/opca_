<?php

namespace App\Providers;

use App\repositories\ClientesRepository;
use App\repositories\Contracts\ClientesRepositoryInterface;
use App\repositories\Contracts\FinanzaRepositoryInterface;
use App\repositories\Contracts\GaleriaRepositoryInterface;
use App\repositories\Contracts\InventarioRepositoryInterface;
use App\repositories\Contracts\PedidoRepositoryInterface;
use App\repositories\Contracts\PreciobaseRepositoryInterface;
use App\repositories\Contracts\ServicioRepositoryInterface;
use App\repositories\Contracts\TiposervicioRepositoryInterface;
use App\repositories\finanzaRepository;
use App\repositories\GaleriaRepository;
use App\repositories\inventarioRepository;
use App\repositories\PedidoRepository;
use App\repositories\PreciobaseRepository;
use App\repositories\servicioRepository;
use App\repositories\TiposervicioRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enlaces Interfaz (contrato) => Implementación (repositorio con Eloquent).
     *
     * Los Services solo conocen la interfaz; aquí se decide qué clase concreta
     * la cumple. Para cambiar la fuente de datos basta con cambiar este arreglo.
     */
    private array $repositorios = [
        ClientesRepositoryInterface::class     => ClientesRepository::class,
        PedidoRepositoryInterface::class       => PedidoRepository::class,
        ServicioRepositoryInterface::class     => servicioRepository::class,
        FinanzaRepositoryInterface::class      => finanzaRepository::class,
        PreciobaseRepositoryInterface::class   => PreciobaseRepository::class,
        TiposervicioRepositoryInterface::class => TiposervicioRepository::class,
        InventarioRepositoryInterface::class   => inventarioRepository::class,
        GaleriaRepositoryInterface::class      => GaleriaRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->repositorios as $interfaz => $implementacion) {
            $this->app->bind($interfaz, $implementacion);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
