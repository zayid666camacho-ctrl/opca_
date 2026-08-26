<?php

namespace App\services;

use App\repositories\ClientesRepository;

class ClientesService{

    private ClientesRepository $clientesrepository;

    public function __construct(ClientesRepository $clientesrepository) {
        $this->clientesrepository = $clientesrepository;
    }

    public function Listar(){
        return $this->clientesrepository->Listar();
    }

    public function Crear(array $datos){
        return $this->clientesrepository->Crear($datos);
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

}