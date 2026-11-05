<?php

namespace Database\Seeders;

use App\Models\tipo_servicio;
use Illuminate\Database\Seeder;

/**
 * Catálogo fijo de tipos de servicio del taller.
 * Usa firstOrCreate para poder ejecutarse varias veces sin duplicar.
 */
class TipoServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['servicio' => 'confeccion', 'descripcion' => 'Confección de prenda desde cero'],
            ['servicio' => 'arreglo', 'descripcion' => 'Arreglo o ajuste de una prenda existente'],
            ['servicio' => 'diseno', 'descripcion' => 'Diseño propio del costurero'],
        ];

        foreach ($tipos as $tipo) {
            tipo_servicio::firstOrCreate(['servicio' => $tipo['servicio']], $tipo);
        }
    }
}
