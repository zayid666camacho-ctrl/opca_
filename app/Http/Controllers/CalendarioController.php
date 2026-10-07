<?php

namespace App\Http\Controllers;

use App\services\PedidoService;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    //
    private PedidoService $pedido_service;

    public function __construct(PedidoService $pedido_service) {
        $this->pedido_service = $pedido_service;
    }


    public function index(Request $request){
        $mes = $request->query('mes', now()->month);
        $anio = $request->query('anio', now()->year);

        $primer_dia = \Carbon\Carbon::createFromDate($anio, $mes, 1);

        $ultimo_dia = $primer_dia->copy()->endOfMonth();
        $dia_semana_inicio = $primer_dia->dayOfWeekIso; 

        $pedidos = $this->pedido_service->listar_por_rango($primer_dia, $ultimo_dia);

        return view('calendario.index', compact('pedidos', 'mes', 'anio', 'primer_dia', 'dia_semana_inicio'));
    }
}
