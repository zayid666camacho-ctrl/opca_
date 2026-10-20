<?php

namespace App\Http\Controllers;

use App\services\finanzaService;
use App\services\PedidoService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FinanzaController extends Controller
{

    private FinanzaService $finanzaservice;
    private PedidoService $pedidoservice;

    public function __construct(FinanzaService $finanzaservice, PedidoService $pedidoservice) {
        $this->finanzaservice = $finanzaservice;
        $this->pedidoservice = $pedidoservice;
    }

    public function index(Request $request)
    {
        $anio = (int) $request->query('anio', now()->year);

        $pagos = $this->finanzaservice->listar();
        $pedidos = $this->pedidoservice->listar_con_saldo();
        $resumen = $this->finanzaservice->resumen_por_mes($anio);

        return view('finanzas.index', compact('pagos', 'pedidos', 'resumen', 'anio'));
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

    public function exportar(Request $request)
    {
        $anio = (int) $request->query('anio', now()->year);
        $libro = $this->finanzaservice->exportar_excel($anio);

        return response()->streamDownload(function () use ($libro) {
            (new Xlsx($libro))->save('php://output');
        }, 'finanzas-' . $anio . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
