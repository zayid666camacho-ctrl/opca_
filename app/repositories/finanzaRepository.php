<?php

namespace App\repositories;

use App\Models\finanza;
use App\repositories\Contracts\FinanzaRepositoryInterface;

class finanzaRepository implements FinanzaRepositoryInterface{

    public function listar(){
        return finanza::with('pedido.cliente')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function crear(array $datos){
        return finanza::create($datos);
    }

    public function buscar(int $id){
        return finanza::findOrFail($id);
    }

    public function delete(int $id){
        finanza::destroy($id);
    }

    public function listar_por_anio(int $anio){
        return finanza::with('pedido.cliente')
        ->whereYear('fecha', $anio)
        ->orderBy('fecha')
        ->get();
    }

}