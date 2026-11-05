<?php

namespace App\services;

use App\repositories\Contracts\TiposervicioRepositoryInterface;

class TiposervicioService{

    private TiposervicioRepositoryInterface $tiposerviciorepository;

    public function __construct(TiposervicioRepositoryInterface $tiposerviciorepository) {
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