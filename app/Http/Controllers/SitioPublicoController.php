<?php

namespace App\Http\Controllers;

use App\Services\GaleriaService;
use App\services\PedidoService;
use App\services\PreciobaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SitioPublicoController extends Controller
{
    private GaleriaService $galeriaservice;
    private PreciobaseService $preciobaseservice;
    private PedidoService $pedidoservice;

    public function __construct(GaleriaService $galeriaservice, PreciobaseService $preciobaseservice, PedidoService $pedidoservice)
    {
        $this->galeriaservice = $galeriaservice;
        $this->preciobaseservice = $preciobaseservice;
        $this->pedidoservice = $pedidoservice;
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
     * Consulta pública del estado de pedidos por correo electrónico del cliente.
     */
    public function estado_pedido(Request $request)
    {
        $taller = $this->obtener_datos_taller();
        $correo = $request->query('correo');
        $pedidos = collect();
        if ($correo !== null && trim($correo) !== '') {
            $request->validate([
                'correo' => ['required', 'email'],
            ], [
                'correo.email' => 'Por favor ingresa un correo electrónico válido.',
            ]);
            $pedidos = $this->pedidoservice->consultar_por_correo($correo);
        }
        return view('publico.estado_pedido', compact('taller', 'correo', 'pedidos'));
    }

    /**
     * Muestra el formulario administrativo del Perfil del Taller (datos públicos).
     */
    public function perfil_taller()
    {
        $taller = $this->obtener_datos_taller();

        return view('configuracion.perfil_taller', compact('taller'));
    }

    /**
     * Actualiza los datos públicos del taller que se muestran en "Visítanos o Escríbenos".
     */
    public function actualizar_perfil_taller(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:120'],
            'eslogan'     => ['required', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'telefono'    => ['required', 'string', 'max:50'],
            'whatsapp'    => ['required', 'string', 'max:30'],
            'correo'      => ['required', 'email', 'max:120'],
            'direccion'   => ['required', 'string', 'max:200'],
            'ciudad'      => ['required', 'string', 'max:100'],
            'horario'     => ['required', 'string', 'max:150'],
        ]);

        Storage::disk('local')->put('taller.json', json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('taller.perfil')->with('success', 'Los datos públicos del taller se actualizaron correctamente.');
    }

    /**
     * Datos base de contacto e identidad del taller Creaciones Nayja.
     */
    private function obtener_datos_taller(): array
    {
        $por_defecto = [
            'nombre' => 'Creaciones Nayja',
            'eslogan' => 'Confección sobre medidas, arreglos y alta costura',
            'descripcion' => 'Taller de modistería dedicado al diseño, confección a medida y restauración de prendas de vestir con acabados de alta calidad.',
            'telefono' => '+57 310 8289121',
            'whatsapp' => '573108289121',
            'correo' => 'contacto@creacionesnayja.com',
            'direccion' => 'Calle 3 # 4-50, Taller Creaciones Nayja - al frente de la casa Ludica',
            'ciudad' => 'Colombia',
            'horario' => 'Lunes a Viernes: 8:30 AM - 8:30:00 PM',
        ];

        if (Storage::disk('local')->exists('taller.json')) {
            $guardados = json_decode(Storage::disk('local')->get('taller.json'), true);
            if (is_array($guardados)) {
                return array_merge($por_defecto, $guardados);
            }
        }

        return $por_defecto;
    }
}
