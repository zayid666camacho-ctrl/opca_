<?php

namespace App\repositories;

use App\Models\cliente;

class ClientesRepository{

    public function listar(){
        $clientes = cliente::all();
        return $clientes; 
    }

    public function crear(array $datos){
        return cliente::create($datos);    
    }

    public function buscar(int $id){
        $clientes = cliente::findOrfail($id);
        return $clientes;
    }

    public function actualizar(int $id, array $datos){
        $clientes = cliente::findOrfail($id);
        $clientes->update($datos);
    }

    public function delete(int $id){
        cliente::destroy($id);
    }

    public function obtener_detalle(int $id){
        return cliente::findOrFail($id);
    }

    public function buscar_por_nombre(string $termino){
    return cliente::whereRaw("(nombre || ' ' || apellido) LIKE ?", ["%{$termino}%"])->get();
}

}