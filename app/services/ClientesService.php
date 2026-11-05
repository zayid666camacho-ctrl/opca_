<?php

namespace App\services;

use App\repositories\Contracts\ClientesRepositoryInterface;

class ClientesService{

    private ClientesRepositoryInterface $clientesrepository;

    public function __construct(ClientesRepositoryInterface $clientesrepository) {
        $this->clientesrepository = $clientesrepository;
    }

    public function listar(){
        return $this->clientesrepository->listar();
    }

    public function crear(array $datos){
        $datos['fecha_registro'] = now();
        return $this->clientesrepository->crear($datos);
    }

    public function buscar(int $id){
        return $this->clientesrepository->buscar($id);
    }

    public function actualizar(int $id, array $datos){
        return $this->clientesrepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        return $this->clientesrepository->delete($id);
    }

    public function obtener_detalle(int $id){
        return $this->clientesrepository->obtener_detalle($id);
    }

    public function buscar_por_nombre(string $termino){
    return $this->clientesrepository->buscar_por_nombre($termino);
}

}