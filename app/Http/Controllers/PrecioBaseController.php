<?php

namespace App\Http\Controllers;

use App\Models\precio_base;
use App\services\PreciobaseService;
use Illuminate\Http\Request;

class PrecioBaseController extends Controller
{

    private PreciobaseService $preciobaseservice;

    public function __construct(PreciobaseService $preciobaseservice) {
        $this->preciobaseservice = $preciobaseservice;
    }

    
    public function index()
    {
        //
        $preciobase = $this->preciobaseservice->Listar();
        return view('tipo_servicio.index', compact('preciobase'));
    }

    
    public function create()
    {
        //
        return route('precio_base.create');
    }

    
    public function store(Request $request)
    {
        //
        $this->preciobaseservice->Crear($request->all());
        return view('Clientes.index');
    }

    
    public function show()
    {
        //
        
    }

    
    public function edit(int $id)
    {
        //
        $preciobase = $this->preciobaseservice->buscar($id);
        return view('precio_base.edit', compact('preciobase'));
    }

    
    public function update(int $id, Request $request)
    {
        //
        $this->preciobaseservice->actualizar($id, $request->all());
        return redirect()->route('tipo_servicio.index');
    }

    
    public function destroy(int $id)
    {
        //
        $this->preciobaseservice->delete($id);
        return redirect()->route('tipo_servicio.index');
    }
}
