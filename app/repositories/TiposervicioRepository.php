<?php

namespace App\repositories;

use App\Models\tipo_servicio;

class TiposervicioRepository{

    public function listar(){
        $tipo_servicio = tipo_servicio::all();
        return $tipo_servicio;
    }

    public function crear(array $datos){
        tipo_servicio::create($datos);
    }

    public function edit(int $id){
    $tipo_servicio = tipo_servicio::findOrfail($id);
    return $tipo_servicio;
    }
    
    public function actualizar(int $id, array $datos){
        $tipo_servicio = tipo_servicio::findOrfail($id);
        $tipo_servicio->update($datos);
    }

    public function delete(int $id){
        tipo_servicio::destroy($id);
    }

}