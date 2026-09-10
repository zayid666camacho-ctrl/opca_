<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
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
        $clientes = $this->clientesservice->listar();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        //
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        //
        $this->clientesservice->crear($request->validated());
        return redirect()->route('clientes.index');
    }

    public function show(int $id)
    {
    $cliente = $this->clientesservice->obtenerDetalle($id);

    return view('clientes.show', compact('cliente'));
    }


    public function edit(int $id)
    {
        //
        $cliente = $this->clientesservice->buscar($id);
        return view('clientes.edit', compact('cliente'));
    }


    public function update(int $id, UpdateClienteRequest $request)
    {
        //
        $this->clientesservice->actualizar($id, $request->validated());
        return redirect()->route('clientes.index');
    }


    public function destroy(int $id)
    {
        //
        $this->clientesservice->delete($id);
        return redirect()->route('clientes.index');
    }
}
