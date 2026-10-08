<?php

namespace App\repositories;

use App\Models\pedido;
use GuzzleHttp\Psr7\Request;

class PedidoRepository{

    public function listar(){
        return pedido::with('cliente')->get();
    }

    public function crear(array $datos){
        pedido::create($datos);
    }

    public function buscar(int $id){
        return pedido::with('cliente')->findOrfail($id);
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
}