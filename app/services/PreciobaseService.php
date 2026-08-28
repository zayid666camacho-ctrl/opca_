<?php

namespace App\services;

use App\Models\tipo_servicio;
use App\repositories\PreciobaseRepository;

class PreciobaseService{

    private PreciobaseRepository $preciobaserepository;

    public function __construct(PreciobaseRepository $preciobaserepository) {
        $this->preciobaserepository = $preciobaserepository;
    }

    public function listar(){
        $this->preciobaserepository->listar();
    }

    public function crear(array $datos){
        $this->preciobaserepository->crear($datos);
    }

    public function buscar(int $id){
        $this->preciobaserepository->buscar($id);
    }
    
    public function actualizar(int $id, array $datos){
        $this->preciobaserepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        $this->preciobaserepository->delete($id);
    }

}