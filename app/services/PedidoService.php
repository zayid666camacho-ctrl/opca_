<?php

namespace App\services;

use App\Models\pedido;
use App\repositories\PedidoRepository;
use GuzzleHttp\Psr7\Request;

class PedidoService{

    private PedidoRepository $pedidorepository;

    public function __construct(PedidoRepository $pedidorepository) {
        $this->pedidorepository = $pedidorepository;
    }

    public function listar(){
        return $this->pedidorepository->listar();
    }

    public function crear(array $datos){
        $datos['precio'] = 0;
        $datos['saldo_pendiente'] = 0;
        $this->pedidorepository->crear($datos);
    }

    public function buscar(int $id){
        return $this->pedidorepository->buscar($id);
    }

    public function actualizar(int $id, array $datos){
        $this->pedidorepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $this->pedidorepository->delete($id);
    }

    public function listar_por_rango($primer_dia, $ultimo_dia){
        return $this->pedidorepository->listar_por_rango($primer_dia, $ultimo_dia);
    }

}