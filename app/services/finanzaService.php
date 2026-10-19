<?php

namespace App\services;
use App\Repositories\finanzaRepository;
use App\repositories\PedidoRepository;

class finanzaService{

    private FinanzaRepository $finanzarepository;
    private PedidoRepository $pedidorepository;

    public function __construct(FinanzaRepository $finanzarepository, PedidoRepository $pedidorepository) {
        $this->finanzarepository = $finanzarepository;
        $this->pedidorepository = $pedidorepository;
    }

    public function listar(){
        return $this->finanzarepository->listar();
    }

    public function crear(array $datos){
        $pedido = $this->pedidorepository->buscar($datos['id_pedido']);

        if ((float) $datos['monto'] > (float) $pedido->saldo_pendiente) {
            return [
                'ok' => false,
                'mensaje' => 'El pago no puede ser mayor al saldo pendiente del pedido ($' . number_format($pedido->saldo_pendiente, 2) . ').',
            ];
        }

        $this->finanzarepository->crear($datos);
        $this->recalcular_saldo($datos['id_pedido']);

        return ['ok' => true];
    }

    public function delete(int $id){
        $pago = $this->finanzarepository->buscar($id);
        $id_pedido = $pago->id_pedido;

        $this->finanzarepository->delete($id);
        $this->recalcular_saldo($id_pedido);
    }

    private function recalcular_saldo(int $id_pedido){
        $pedido = $this->pedidorepository->buscar($id_pedido);
        $pagado = $this->pedidorepository->total_pagado($id_pedido);

        $this->pedidorepository->actualizar($id_pedido, [
            'saldo_pendiente' => $pedido->precio - $pagado,
        ]);
    }

}