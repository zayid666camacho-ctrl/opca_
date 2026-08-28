<?php

namespace App\repositories;

use App\Models\precio_base;

class PreciobaseRepository{
    
    public function listar(){
        $preciobase = precio_base::all();
        return $preciobase;
    }

    public function crear(array $datos){
        precio_base::create($datos);
    }

    public function buscar(int $id){
        $preciobase = precio_base::findOrfail($id);
        return $preciobase;
    }

    public function actualizar(int $id, array $datos){
        $preciobase = precio_base::findOrfail($id);
        $preciobase->update($datos);
    }

    public function delete(int $id){
        precio_base::destroy($id);
    }

}