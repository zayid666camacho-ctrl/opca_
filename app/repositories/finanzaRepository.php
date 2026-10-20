<?php

namespace App\Repositories;

use App\Models\finanza;

class finanzaRepository{

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