<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitioPublicoController extends Controller
{
    /**
     * Muestra la página principal pública del taller Creaciones Nayja.
     * HU33: Presenta información de contacto directa y servicios.
     * HU34: Vista responsive accesible para clientes sin iniciar sesión.
     */
    public function index()
    {
        // Datos base del taller Creaciones Nayja para contacto
        $taller = [
            'nombre' => 'Creaciones Nayja',
            'eslogan' => 'Confección sobre medidas, arreglos y alta costura',
            'descripcion' => 'Taller de modistería dedicado al diseño, confección a medida y restauración de prendas de vestir con acabados de alta calidad.',
            'telefono' => '+57 312 345 6789',
            'whatsapp' => '573123456789', // Formato internacional sin símbolos para enlace wa.me
            'correo' => 'contacto@creacionesnayja.com',
            'direccion' => 'Calle Principal # 12-34, Taller Creaciones Nayja',
            'ciudad' => 'Colombia',
            'horario' => 'Lunes a Sábado: 8:00 AM - 6:00 PM',
        ];

        // Servicios representativos del taller
        $servicios = [
            [
                'titulo' => 'Confección sobre Medidas',
                'descripcion' => 'Prendas exclusivas adaptadas a tus medidas corporales exactas: vestidos de fiesta, camisas, pantalones y trajes.',
                'icono' => 'scissors'
            ],
            [
                'titulo' => 'Arreglos y Modificaciones',
                'descripcion' => 'Ajustes de talla, cambio de cremalleras, dobladillos, entalles y transformación de prendas favoritas.',
                'icono' => 'sparkles'
            ],
            [
                'titulo' => 'Asesoría y Diseño',
                'descripcion' => 'Acompañamiento en la elección de telas, patrones y diseño para que luzcas la prenda ideal en cualquier ocasión.',
                'icono' => 'palette'
            ],
        ];

        return view('publico.index', compact('taller', 'servicios'));
    }
}