<?php

namespace App\repositories;

use App\Models\servicio;

class servicioRepository{

    public function listar(){
        return servicio::with(['pedido', 'precio_base', 'tipo_servicio'])->get();
    }

    public function crear(array $datos){
    return servicio::create($datos);
    }

    public function buscars(int $id){
        return servicio::with(['pedido', 'precioBase', 'tipoServicio'])->findOrfail($id);
    }

    public function actualizar(int $id, array $datos){
        $servicio = servicio::findOrfail($id);
        $servicio->update($datos);
    }

    public function delete(int $id){
        servicio::destroy($id);
    }

    public function listar_por_pedido(int $idpedido){
        return servicio::where('id_pedido', $idpedido)->get();
    }

}