<?php

namespace App\repositories;

use App\Models\pedido;

class PedidoRepository{

    public function listar(){
        return pedido::with('pedido')->get();
    }

    public function crear(array $datos){
        pedido::create($datos);
    }

    public function buscar(int $id){
        $pedido = pedido::findOrfail($id);
    }

    public function actualizar(int $id, array $datos){
        $pedido = pedido::findOrfail($id);
        pedido::update($datos);
    }
    
    public function delete(int $id){
        pedido::destroy($id);
    }
}