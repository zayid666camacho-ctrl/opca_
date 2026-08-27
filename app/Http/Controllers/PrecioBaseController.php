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
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(precio_base $precio_base)
    {
        //
    }

    
    public function edit(precio_base $precio_base)
    {
        //
    }

    
    public function update(Request $request, precio_base $precio_base)
    {
        //
    }

    
    public function destroy(precio_base $precio_base)
    {
        //
    }
}
