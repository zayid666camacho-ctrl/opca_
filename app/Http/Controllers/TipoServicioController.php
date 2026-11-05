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
        $datos = $request->validate($this->reglas());

        $this->tiposervicioservice->crear($datos);
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
        $datos = $request->validate($this->reglas());

        $this->tiposervicioservice->actualizar($id, $datos);
        return redirect()->route('tipo_servicio.index');
    }

    public function destroy(int $id)
    {
        $this->tiposervicioservice->delete($id);
        return redirect()->route('tipo_servicio.index');
    }

    /**
     * Reglas de validación compartidas por store() y update().
     */
    private function reglas(): array
    {
        return [
            'servicio'    => 'required|in:arreglo,confeccion,diseno',
            'descripcion' => 'required|string|max:255',
        ];
    }
}
