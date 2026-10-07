<?php

namespace App\Http\Controllers;

use App\Models\servicio;
use App\services\PedidoService;
use App\services\PreciobaseService;
use App\services\servicioService;
use App\services\TiposervicioService;
use Illuminate\Http\Request;

class ServicioController extends Controller
{


    private servicioService $servicio_service;
    private PedidoService $pedido_service;
    private PreciobaseService $preciobase_service;
    private TiposervicioService $tiposervicio_service;

    public function __construct(servicioService $servicio_service, PedidoService $pedido_service, PreciobaseService $preciobase_service, TiposervicioService $tiposervicio_service) {
        $this->servicio_service = $servicio_service;
        $this->pedido_service = $pedido_service;
        $this->preciobase_service = $preciobase_service;
        $this->tiposervicio_service = $tiposervicio_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $servicio = $this->servicio_service->listar();
        return view('servicio.index', compact('servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pedido = $this->pedido_service->listar();
        $precio_bases = $this->preciobase_service->listar();
        $tipo_servicios = $this->tiposervicio_service->listar();

        return view('servicio.create', compact('pedido', 'precio_bases', 'tipo_servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->servicio_service->crear($request->all());
        return redirect()->route('servicios.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
        $servicios = $this->servicio_service->buscars($id);

        $pedidos = $this->pedido_service->listar();
        $precio_bases = $this->preciobase_service->listar();
        $tipo_servicio = $this->tiposervicio_service->listar();

        return view('servicio.edit', compact('pedidos', 'precio_bases', 'tipo_servicio', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        //
        $this->servicio_service->actualizar($id, $request->all());
        return redirect()->route('servicios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $this->servicio_service->delete($id);
        return redirect()->route('servicios.index');
    }
}
