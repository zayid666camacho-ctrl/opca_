<?php

namespace App\repositories;

use App\Models\finanza;
use App\repositories\Contracts\FinanzaRepositoryInterface;

class finanzaRepository implements FinanzaRepositoryInterface{

    public function listar(){
        return finanza::with('pedido.cliente')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function listar_historial(?string $mes_filtro = null){
        $consulta = finanza::with('pedido.cliente')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc');

        if ($mes_filtro && preg_match('/^\d{4}-\d{2}$/', $mes_filtro)) {
            [$anio_f, $mes_f] = explode('-', $mes_filtro);
            return $consulta
                ->whereYear('fecha', (int) $anio_f)
                ->whereMonth('fecha', (int) $mes_f)
                ->get();
        }

        // Por defecto: pagos registrados en los últimos 10 días
        $fecha_desde = now()->subDays(10)->toDateString();
        return $consulta->whereDate('fecha', '>=', $fecha_desde)->get();
    }

    public function crear(array $datos){
        return finanza::create($datos);
    }

    public function buscar(int $id){
        return finanza::findOrFail($id);
    }

    public function actualizar(int $id, array $datos){
        $pago = finanza::findOrFail($id);
        $pago->update($datos);
        return $pago;
    }

    public function delete(int $id){
        finanza::destroy($id);
    }

    public function listar_por_anio(int $anio){
        return finanza::with('pedido.cliente')
        ->whereYear('fecha', $anio)
        ->orderBy('fecha')
        ->get();
    }

}