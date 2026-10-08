<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\tipo_servicio;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        tipo_servicio::create(['servicio' => 'confeccion', 'descripcion' => 'Confección de prenda desde cero']);
        tipo_servicio::create(['servicio' => 'arreglo', 'descripcion' => 'Arreglo o ajuste de una prenda existente']);
        tipo_servicio::create(['servicio' => 'diseno', 'descripcion' => 'Diseño propio del costurero']);
    }
}
