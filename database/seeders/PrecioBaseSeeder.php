<?php

namespace Database\Seeders;

use App\Models\precio_base;
use Illuminate\Database\Seeder;

class PrecioBaseSeeder extends Seeder
{
    public function run(): void
    {
        $prendas = [
            ['nombre_prenda' => 'Camisa', 'complejidad' => 'Media', 'precio' => 60000, 'requiere_camisa' => true],
            ['nombre_prenda' => 'Blusa', 'complejidad' => 'Media', 'precio' => 55000, 'requiere_camisa' => true],
            ['nombre_prenda' => 'Pantalón', 'complejidad' => 'Media', 'precio' => 70000, 'requiere_pantalon' => true],
            ['nombre_prenda' => 'Vestido', 'complejidad' => 'Alta', 'precio' => 120000, 'requiere_camisa' => true, 'requiere_generales' => true],
            ['nombre_prenda' => 'Conjunto camisa y pantalón', 'complejidad' => 'Alta', 'precio' => 130000, 'requiere_camisa' => true, 'requiere_pantalon' => true, 'requiere_generales' => true],
            ['nombre_prenda' => 'Arreglo de dobladillo', 'complejidad' => 'Baja', 'precio' => 8000, 'requiere_pantalon' => true],
            ['nombre_prenda' => 'Ajuste de manga', 'complejidad' => 'Baja', 'precio' => 12000, 'requiere_camisa' => true],
            ['nombre_prenda' => 'Cambio de cierre', 'complejidad' => 'Baja', 'precio' => 10000],
        ];

        foreach ($prendas as $prenda) {
            precio_base::firstOrCreate(['nombre_prenda' => $prenda['nombre_prenda']], $prenda);
        }
    }
}