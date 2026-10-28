<?php

namespace App\Http\Controllers;

use App\Services\GaleriaService;
use App\services\PreciobaseService;
use Illuminate\Http\Request;

class SitioPublicoController extends Controller
{
    private GaleriaService $galeriaservice;
    private PreciobaseService $preciobaseservice;

    public function __construct(GaleriaService $galeriaservice, PreciobaseService $preciobaseservice)
    {
        $this->galeriaservice = $galeriaservice;
        $this->preciobaseservice = $preciobaseservice;
    }

    /**
     * Muestra la página principal pública del taller Creaciones Nayja.
     * HU33: Información de contacto y presentación general.
     * HU34: Vista responsive accesible para clientes sin iniciar sesión.
     */
    public function index()
    {
        $taller = $this->obtener_datos_taller();

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

    /**
     * Muestra la vista dedicada de la Galería de Trabajos para clientes (HU29).
     * Solo trabajos visibles, ordenados de más reciente a más antiguo.
     */
    public function galeria()
    {
        $taller = $this->obtener_datos_taller();
        $galeria = $this->galeriaservice->listar(null, true);
        $categorias_galeria = $this->galeriaservice->categorias();

        return view('publico.galeria', compact('taller', 'galeria', 'categorias_galeria'));
    }

    /**
     * Muestra la vista dedicada del Catálogo de Tarifas y Precios de Referencia para clientes.
     */
    public function precios()
    {
        $taller = $this->obtener_datos_taller();
        $precios = $this->preciobaseservice->listar();

        return view('publico.precios', compact('taller', 'precios'));
    }

    /**
     * Datos base de contacto e identidad del taller Creaciones Nayja.
     */
    private function obtener_datos_taller(): array
    {
        return [
            'nombre' => 'Creaciones Nayja',
            'eslogan' => 'Confección sobre medidas, arreglos y alta costura',
            'descripcion' => 'Taller de modistería dedicado al diseño, confección a medida y restauración de prendas de vestir con acabados de alta calidad.',
            'telefono' => '+57 312 345 6789',
            'whatsapp' => '573123456789',
            'correo' => 'contacto@creacionesnayja.com',
            'direccion' => 'Calle Principal # 12-34, Taller Creaciones Nayja',
            'ciudad' => 'Colombia',
            'horario' => 'Lunes a Sábado: 8:00 AM - 6:00 PM',
        ];
    }
}
