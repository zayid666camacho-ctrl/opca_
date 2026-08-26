<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\services\ClientesService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    private ClientesService $clientesservice;

    public function __construct(ClientesService $clientesservice) {
        $this->clientesservice = $clientesservice;
    }


    public function index()
    {
        //
        $clientes = $this->clientesservice->Listar();
        return view('Clientes.index', compact('clientes'));
    }

    public function create()
    {
        //
        return view('Clientes.create');
    }

    public function store(Request $request)
    {
        //
        $this->clientesservice->Crear($request->all());
        return view('Clientes.index');
    }

    public function show()
    {
        //
    }


    public function edit(int $id)
    {
        //
        $cliente = $this->clientesservice->buscar($id);
        return view('Clientes.edit', compact('cliente'));
    }


    public function update(int $id, Request $request)
    {
        //
        $this->clientesservice->actualizar($id, $request->all());
        return redirect()->route('Clientes.index');
    }


    public function destroy(int $id)
    {
        //
        $this->clientesservice->delete($id);
        return redirect()->route('Clientes.index');
    }
}
