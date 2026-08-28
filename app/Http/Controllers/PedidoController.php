<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use App\repositories\PedidoRepository;
use App\services\ClientesService;
use App\services\PedidoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

    private PedidoService $pedidoservice;
    private ClientesService $clientesservice;

    public function __construct(PedidoService $pedidoservice, ClientesService $clientesservice) {
        $this->pedidoservice = $pedidoservice;
        $this->clientesservice = $clientesservice;
    }

    
    public function index()
    {
        //
        $pedido = $this->pedidoservice->listar();
        return view('pedido.index', compact('pedido'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cliente = $this->clientesservice->listar();
        return view('pedido.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->pedidoservice->Crear($request->all());
        return redirect()->route('pedido.index');
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
        $pedido = $this->pedidoservice->buscar($id);

        $cliente = $this->clientesservice->listar();
        return view('pedido.edit', compact('cliente', 'pedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        //
        $this->pedidoservice->actualizar($id, $request->all());
        return redirect()->route('pedido.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $this->pedidoservice->delete($id);
        return redirect()->route('pedido.index');
    }
}
