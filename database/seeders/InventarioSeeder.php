<?php

namespace Database\Seeders;

use App\Models\inventario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $materiales = [
            // Telas
            [
                'nombre' => 'Lino importado beige',
                'categoria' => 'Telas',
                'stock' => 15,
                'unidad' => 'metros',
                'precio_unitario' => 28000.00,
                'stock_minimo' => 5,
            ],
            [
                'nombre' => 'Dril algodón negro',
                'categoria' => 'Telas',
                'stock' => 3, // Stock bajo (menor al mínimo)
                'unidad' => 'metros',
                'precio_unitario' => 22000.00,
                'stock_minimo' => 6,
            ],
            [
                'nombre' => 'Seda crepé azul rey',
                'categoria' => 'Telas',
                'stock' => 8,
                'unidad' => 'metros',
                'precio_unitario' => 35000.00,
                'stock_minimo' => 4,
            ],
            // Hilos
            [
                'nombre' => 'Hilo poliéster negro 120',
                'categoria' => 'Hilos',
                'stock' => 10,
                'unidad' => 'conos',
                'precio_unitario' => 6500.00,
                'stock_minimo' => 3,
            ],
            [
                'nombre' => 'Hilo poliéster blanco 120',
                'categoria' => 'Hilos',
                'stock' => 1, // Stock bajo (menor al mínimo)
                'unidad' => 'conos',
                'precio_unitario' => 6500.00,
                'stock_minimo' => 3,
            ],
            // Cremalleras
            [
                'nombre' => 'Cremallera invisible 20cm negra',
                'categoria' => 'Cremalleras',
                'stock' => 25,
                'unidad' => 'unidades',
                'precio_unitario' => 1200.00,
                'stock_minimo' => 10,
            ],
            [
                'nombre' => 'Cremallera metálica pantalón 15cm',
                'categoria' => 'Cremalleras',
                'stock' => 4, // Stock bajo (menor al mínimo)
                'unidad' => 'unidades',
                'precio_unitario' => 2500.00,
                'stock_minimo' => 8,
            ],
            // Botones e insumos varios
            [
                'nombre' => 'Botón 4 agujas nácar 18L',
                'categoria' => 'Botones',
                'stock' => 100,
                'unidad' => 'unidades',
                'precio_unitario' => 250.00,
                'stock_minimo' => 30,
            ],
            [
                'nombre' => 'Entretela termoadhesiva blanca',
                'categoria' => 'Insumos',
                'stock' => 2, // Stock bajo (menor al mínimo)
                'unidad' => 'metros',
                'precio_unitario' => 8500.00,
                'stock_minimo' => 5,
            ],
        ];
        foreach ($materiales as $material) {
            inventario::create($material);
        }
    }
}
