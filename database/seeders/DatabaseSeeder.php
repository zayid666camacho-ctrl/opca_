<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Orquesta todos los seeders de OPCA en el orden correcto de dependencias.
     * Uso: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->call([
            // 1. Seguridad: rol administrador + usuaria administradora (datos en config/seguridad.php)
            SeguridadSeeder::class,

            // 2. Catálogos base del taller
            TipoServicioSeeder::class,
            PrecioBaseSeeder::class,
            InventarioSeeder::class,

            // 3. Datos de demostración (dependen de los catálogos)
            ClienteSeeder::class,
            PedidoSeeder::class, // incluye prendas (servicios) y abonos (finanzas)
        ]);
    }
}
