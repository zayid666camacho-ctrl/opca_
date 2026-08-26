<?php

namespace App\repositories;

use App\Models\cliente;

class ClientesRepository{

    public function Listar(){
        $clientes = cliente::all();
        return $clientes;
    }

    public function Crear(array $datos){
        cliente::create($datos);    
    }

    public function buscar(int $id){
        $clientes = cliente::finOrfail($id);
        return $clientes;
    }

    public function actualizar(int $id, array $datos){
        $clientes = cliente::findOrfail($id);
        $clientes->update($datos);
    }

    public function delete(int $id){
        cliente::destroy($id);
    }

}