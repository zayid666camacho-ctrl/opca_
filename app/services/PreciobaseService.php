<?php

namespace App\services;

use App\repositories\Contracts\PreciobaseRepositoryInterface;

class PreciobaseService{

    private PreciobaseRepositoryInterface $preciobaserepository;

    public function __construct(PreciobaseRepositoryInterface $preciobaserepository) {
        $this->preciobaserepository = $preciobaserepository;
    }

    public function listar(){
        return $this->preciobaserepository->listar();
    }

    public function crear(array $datos){
        $this->preciobaserepository->crear($datos);
    }

    public function buscar(int $id){
        return $this->preciobaserepository->buscar($id);
    }
    
    public function actualizar(int $id, array $datos){
        $this->preciobaserepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $this->preciobaserepository->delete($id);
    }

}