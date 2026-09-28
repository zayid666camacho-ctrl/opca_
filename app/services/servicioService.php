<?php

namespace App\services;

use App\Models\pedido;
use App\Models\servicio;
use App\repositories\PedidoRepository;
use App\repositories\PreciobaseRepository;
use App\repositories\servicioRepository;
use App\repositories\TiposervicioRepository;

class servicioService{

    private servicioRepository $servicio_repository;
    private PedidoRepository $pedido_repository;
    private PreciobaseRepository $preciobase_repository;
    private TiposervicioRepository $tiposervicio_repository;

    public function __construct(servicioRepository $servicio_repository, PedidoRepository $pedido_repository, PreciobaseRepository $preciobase_repository, TiposervicioRepository $tiposervicio_repository) {
        $this->servicio_repository = $servicio_repository;
        $this->pedido_repository = $pedido_repository;
        $this->preciobase_repository = $preciobase_repository;
        $this->tiposervicio_repository = $tiposervicio_repository;
    }

    public function listar(){
        $this->servicio_repository->listar();
    }

    public function crear(array $datos){
    
        $precioBase = $this->preciobase_repository->buscar($datos['id_precio_bases']);
        $datos['precio'] = $precioBase->precio;

        $this->servicio_repository->crear($datos);
        $this->recalcularPedido($datos['id_pedido']);
    }

    public function buscars(int $id){
        $this->servicio_repository->buscars($id);
    }

    public function actualizar(int $id, array $datos){
        $this->servicio_repository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $servicio = $this->servicio_repository->buscars($id);
        $idpedido = $servicio->id_pedido;

        $this->servicio_repository->delete($id);
        $this->recalcularPedido($idpedido);
    }

    private function recalcularPedido(int $idpedido){
        $total = $this->servicio_repository->listar_por_pedido($idpedido)->sum('precio');
        $this->pedido_repository->actualizar($idpedido, [
            'precio' => $total,
            'saldo_pendiente' => $total,
        ]);
    }

}