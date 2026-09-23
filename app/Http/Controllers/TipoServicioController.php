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
        $tiposervicio = $this->tiposervicioservice->listar();
        return view('tipo_servicio.index', compact('tiposervicio'));
    }

    public function create()
    {
        return view('tipo_servicio.create');
    }

    public function store(Request $request)
    {
        $this->tiposervicioservice->crear($request->all());
        return redirect()->route('tipo_servicio.index');
    }

    public function show(tipo_servicio $tipo_servicio)
    {
        //
    }

    public function edit(int $id)
    {
        $tipo_servicio = $this->tiposervicioservice->edit($id);
        return view('tipo_servicio.edit', compact('tipo_servicio'));
    }

    public function update(int $id, Request $request)
    {
        $this->tiposervicioservice->actualizar($id, $request->all());
        return redirect()->route('tipo_servicio.index');
    }

    public function destroy(int $id)
    {
        $this->tiposervicioservice->delete($id);
        return redirect()->route('tipo_servicio.index');
    }
}