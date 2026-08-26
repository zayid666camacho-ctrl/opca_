<?php

namespace App\services;

use App\Models\tipo_servicio;
use App\repositories\TiposervicioRepository;

class TiposervicioService{

    private TiposervicioRepository $tiposerviciorepository;

    public function __construct(TiposervicioRepository $tiposerviciorepository) {
        $this->tiposerviciorepository = $tiposerviciorepository;
    }

    public function listar() {
        return $this->tiposerviciorepository->listar();
    }

    public function crear(array $datos){
        return $this->tiposerviciorepository->crear($datos);
    }

    public function edit(int $id){
        return $this->tiposerviciorepository->edit($id);
    }

    public function actualizar(int $id, array $datos){
        return $this->tiposerviciorepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        return $this->tiposerviciorepository->delete($id);
    }
    
}