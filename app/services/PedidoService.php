<?php

namespace App\services;

use App\Models\pedido;
use App\repositories\PedidoRepository;

class PedidoService{

    private PedidoRepository $pedidorepository;

    public function __construct(PedidoRepository $pedidorepository) {
        $this->pedidorepository = $pedidorepository;
    }

    public function listar(){
        return $this->pedidorepository->listar();
    }

    public function crear(array $datos){
        $this->pedidorepository->crear($datos);
    }

    public function buscar(int $id){
        $this->pedidorepository->buscar($id);
    }

    public function actualizar(int $id, array $datos){
        $this->pedidorepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $this->pedidorepository->delete($id);
    }
    
}