<?php

namespace App\repositories;

use App\Models\pedido;
use App\Models\servicio;
use GuzzleHttp\Psr7\Request;

class PedidoRepository{

    public function listar(){
        return pedido::with('cliente')->get();
    }

    public function crear(array $datos){
        return pedido::create($datos);
    }

    public function buscar(int $id){
    return pedido::with(['cliente', 'servicios.precio_base', 'servicios.tipo_servicio'])->findOrfail($id);
    }

    public function actualizar(int $id, array $datos){
        $pedido = pedido::findOrfail($id);
        $pedido->update($datos);
    }
    
    public function delete(int $id){
        pedido::destroy($id);
    }

    public function listar_por_rango($primer_dia, $ultimo_dia){
        return pedido::whereBetween('fecha', [$primer_dia, $ultimo_dia])
        ->with('cliente')
        ->get();
    }

    public function listar_para_kanban($fecha_limite){
    return pedido::with('cliente')
        ->where(function ($consulta) use ($fecha_limite) {
            $consulta->whereNotIn('estado', ['entregado', 'cancelado'])
                    ->orWhere('updated_at', '>=', $fecha_limite);
        })
        ->get();
    }

    public function filtrar($cliente, $estado, $desde, $hasta){
        $consulta = pedido::with('cliente');

        if ($cliente) {
            $consulta->whereHas('cliente', function ($sub) use ($cliente) {
                $sub->whereRaw("(nombre || ' ' || apellido) LIKE ?", ["%{$cliente}%"]);
            });
        }

        if ($estado) {
            $consulta->where('estado', $estado);
        }

        if ($desde) {
            $consulta->where('fecha', '>=', $desde);
        }

        if ($hasta) {
            $consulta->where('fecha', '<=', $hasta);
        }
        return $consulta->orderBy('fecha', 'desc')->get();
    }

    public function tiene_servicios(int $id){
        return servicio::where('id_pedido', $id)->exists();
    }

    public function listar_por_cliente(int $id_cliente, int $excluir_id){
        return pedido::where('idcliente', $id_cliente)
            ->where('id', '!=', $excluir_id)
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function total_pagado(int $id){
        return pedido::findOrFail($id)->pagos()->sum('monto');
    }

    public function listar_con_saldo(){
        return pedido::with('cliente')
            ->where('saldo_pendiente', '>', 0)
            ->orderBy('fecha', 'desc')
            ->get();
    }

}