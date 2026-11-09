<?php

namespace App\services;

use App\repositories\Contracts\PedidoRepositoryInterface;
use App\repositories\Contracts\PreciobaseRepositoryInterface;
use App\repositories\Contracts\ServicioRepositoryInterface;
use App\repositories\Contracts\TiposervicioRepositoryInterface;

class servicioService{

    private ServicioRepositoryInterface $servicio_repository;
    private PedidoRepositoryInterface $pedido_repository;
    private PreciobaseRepositoryInterface $preciobase_repository;
    private TiposervicioRepositoryInterface $tiposervicio_repository;

    public function __construct(ServicioRepositoryInterface $servicio_repository, PedidoRepositoryInterface $pedido_repository, PreciobaseRepositoryInterface $preciobase_repository, TiposervicioRepositoryInterface $tiposervicio_repository) {
        $this->servicio_repository = $servicio_repository;
        $this->pedido_repository = $pedido_repository;
        $this->preciobase_repository = $preciobase_repository;
        $this->tiposervicio_repository = $tiposervicio_repository;
    }

    public function listar(){
        return $this->servicio_repository->listar();
    }

    public function crear(array $datos){
    
        $precioBase = $this->preciobase_repository->buscar($datos['id_precio_bases']);
        $datos['precio'] = $precioBase->precio;

        $this->servicio_repository->crear($datos);
        $this->recalcular_pedido($datos['id_pedido']);
    }

    public function buscars(int $id){
        return $this->servicio_repository->buscars($id);
    }

    public function actualizar(int $id, array $datos){
        $this->servicio_repository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $servicio = $this->servicio_repository->buscars($id);
        $idpedido = $servicio->id_pedido;

        $this->servicio_repository->delete($id);
        $this->recalcular_pedido($idpedido);
    }

    private function recalcular_pedido(int $idpedido){
        $total = $this->servicio_repository->listar_por_pedido($idpedido)->sum('precio');
        $pagado = $this->pedido_repository->total_pagado($idpedido);

        $this->pedido_repository->actualizar($idpedido, [
            'precio' => $total,
            'saldo_pendiente' => $total - $pagado,
        ]);
    }

}