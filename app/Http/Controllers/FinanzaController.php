<?php

namespace App\Http\Controllers;

use App\Models\finanza;
use App\services\finanzaService;
use App\services\PedidoService;
use Illuminate\Http\Request;

class FinanzaController extends Controller
{

    private FinanzaService $finanzaservice;
    private PedidoService $pedidoservice;

    public function __construct(FinanzaService $finanzaservice, PedidoService $pedidoservice) {
        $this->finanzaservice = $finanzaservice;
        $this->pedidoservice = $pedidoservice;
    }

    public function index()
    {
        $pagos = $this->finanzaservice->listar();
        $pedidos = $this->pedidoservice->listar_con_saldo();

        return view('finanzas.index', compact('pagos', 'pedidos'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_pedido' => 'required|exists:pedidos,id',
            'monto'     => 'required|numeric|gt:0',
            'fecha'     => 'required|date',
            'notas'     => 'nullable|string|max:255',
        ]);

        $resultado = $this->finanzaservice->crear($datos);

        if (!$resultado['ok']) {
            return redirect()->back()->withInput()->with('error', $resultado['mensaje']);
        }

        return redirect()->route('finanzas.index')->with('success', 'Pago registrado.');
    }

    public function destroy(int $id)
    {
        $this->finanzaservice->delete($id);

        return redirect()->route('finanzas.index')->with('success', 'Pago eliminado.');
    }
}
