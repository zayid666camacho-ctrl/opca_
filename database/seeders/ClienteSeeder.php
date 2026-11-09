<?php

namespace Database\Seeders;

use App\Models\cliente;
use Illuminate\Database\Seeder;

/**
 * Clientes de demostración con sus medidas corporales (en cm).
 * Se identifican por correo, así que re-ejecutarlo no duplica registros.
 */
class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Laura', 'apellido' => 'Gómez', 'correo' => 'laura.gomez@example.com', 'telefono' => '3104567890',
                'ancho_espalda' => 36, 'largo_espalda' => 40, 'contorno_pecho' => 88, 'hombro' => 12, 'manga' => 58,
                'puño' => 16, 'cintura' => 70, 'largo_total' => 105, 'notas' => 'Prefiere telas livianas.',
            ],
            [
                'nombre' => 'Carlos', 'apellido' => 'Ramírez', 'correo' => 'carlos.ramirez@example.com', 'telefono' => '3127894561',
                'cintura' => 84, 'tiro' => 27, 'pierna' => 58, 'rodilla' => 42, 'largo_pierna' => 102, 'bota' => 20,
                'hombro' => 15, 'manga' => 62,
            ],
            [
                'nombre' => 'Marcela', 'apellido' => 'Torres', 'correo' => 'marcela.torres@example.com', 'telefono' => '3009876543',
                'ancho_espalda' => 38, 'largo_espalda' => 42, 'contorno_pecho' => 92, 'hombro' => 13, 'manga' => 59,
                'cintura' => 74, 'tiro' => 25, 'pierna' => 56, 'largo_pierna' => 98, 'bota' => 18,
            ],
            [
                'nombre' => 'Andrés', 'apellido' => 'Pérez', 'correo' => 'andres.perez@example.com', 'telefono' => '3151237894',
                'ancho_espalda' => 44, 'largo_espalda' => 46, 'contorno_pecho' => 100, 'hombro' => 16, 'manga' => 64,
                'puño' => 18, 'antebrazo' => 28,
            ],
        ];

        foreach ($clientes as $datos) {
            cliente::firstOrCreate(
                ['correo' => $datos['correo']],
                $datos + ['fecha_registro' => now()->toDateString()]
            );
        }
    }
}
