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
        $pedidos = $this->pedidoservice->filtrar(null, null, null, null);
        return view('pedido.index', compact('pedidos'));
    }

    public function kanban()
    {
        $dias = 15;
        $pedidos_por_estado = $this->pedidoservice->listar_para_kanban($dias);
        $estados = ['recibido', 'en_proceso', 'terminado', 'entregado', 'cancelado'];

        return view('pedido.kanban', compact('pedidos_por_estado', 'estados', 'dias'));
    }

    public function cambiarEstado(int $id, Request $request)
    {
        $request->validate([
            'estado' => 'required|in:recibido,en_proceso,terminado,entregado,cancelado',
        ]);

        $resultado = $this->pedidoservice->cambiar_estado($id, $request->input('estado'));

        if (!$resultado['ok']) {
            return response()->json(['mensaje' => $resultado['mensaje']], 422);
        }

        return response()->json(['ok' => true]);
    }

    public function filtrar(Request $request){
        $pedidos = $this->pedidoservice->filtrar(
            $request->query('cliente'),
            $request->query('estado'),
            $request->query('desde'),
            $request->query('hasta')
        );
        return view('pedido._tabla', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $cliente = $this->clientesservice->listar();
        $fecha = $request->query('fecha');
        
        return view('pedido.create', compact('cliente', 'fecha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $this->pedidoservice->Crear($request->all());
        return redirect()->route('pedidos.index');
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
        return redirect()->route('pedidos.index');
    }
}
