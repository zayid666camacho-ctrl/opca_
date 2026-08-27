<?php

namespace App\services;

use App\Models\tipo_servicio;
use App\repositories\PreciobaseRepository;

class PreciobaseService{

    private PreciobaseRepository $preciobaserepository;

    public function __construct(PreciobaseRepository $preciobaserepository) {
        $this->preciobaserepository = $preciobaserepository;
    }

}