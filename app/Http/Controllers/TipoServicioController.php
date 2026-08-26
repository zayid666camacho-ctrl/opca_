<?php

namespace App\Http\Controllers;

use App\Models\tipo_servicio;
use App\services\TiposervicioService;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
{

    private TiposervicioService $tiposervicioservice;

    public function __construct(TiposervicioService $tiposervicioservice) {
        $this->tiposervicioservice = $tiposervicioservice;
    }

    public function index()
    {
        //}
        $tiposervicio = $this->tiposervicioservice->listar();
        return view('tipo_servicio.index', compact('tipo_servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tipo_servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->tiposervicioservice->Crear($request->all());
        return view('tipo_servicio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(tipo_servicio $tipo_servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
        $cliente = $this->tiposervicioservice->edit($id);
        return view('Clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        //
        $this->tiposervicioservice->actualizar($id, $request->all());
        return redirect()->route('Clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $this->tiposervicioservice->delete($id);
        return redirect()->route('Clientes.index');
    }
}
