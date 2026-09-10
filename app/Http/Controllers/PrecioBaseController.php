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
        $precio_bases = $this->preciobaseservice->listar();
        return view('precio_base.index', compact('precio_bases'));
    }

    
    public function create()
    {
        //
        return view('precio_base.create');
    }

    
    public function store(Request $request)
    {
    $this->preciobaseservice->crear($request->all());

    return redirect()->route('precio_bases.index')->with('store', 'Precio base creado correctamente');

    }

    
    public function show()
    {
        //
    }

    
    public function edit(int $id)
    {
        //
        $precio_base = $this->preciobaseservice->buscar($id);
        return view('precio_base.edit', compact('precio_base'));
    }

    
    public function update(int $id, Request $request)
    {
        //
        $this->preciobaseservice->actualizar($id, $request->all());
        return redirect()->route('precio_bases.index');
    }

    
    public function destroy(int $id)
    {
        //
        $this->preciobaseservice->delete($id);
        return redirect()->route('precio_bases.index');
    }
}
