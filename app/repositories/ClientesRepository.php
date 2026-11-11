<?php

namespace App\repositories;

use App\Models\cliente;
use App\Models\finanza;
use App\Models\pedido;
use App\Models\servicio;
use App\repositories\Contracts\ClientesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ClientesRepository implements ClientesRepositoryInterface{

    public function listar(){
        $clientes = cliente::all();
        return $clientes; 
    }

    public function crear(array $datos){
        return cliente::create($datos);    
    }

    public function buscar(int $id){
        $clientes = cliente::findOrfail($id);
        return $clientes;
    }

    public function actualizar(int $id, array $datos){
        $clientes = cliente::findOrfail($id);
        $clientes->update($datos);
    }

    public function delete(int $id){
        DB::transaction(function () use ($id) {
            $ids_pedidos = pedido::where('idcliente', $id)->pluck('id');

            if ($ids_pedidos->isNotEmpty()) {
                servicio::whereIn('id_pedido', $ids_pedidos)->delete();
                finanza::whereIn('id_pedido', $ids_pedidos)->delete();
                pedido::whereIn('id', $ids_pedidos)->delete();
            }

            cliente::destroy($id);
        });
    }

    public function tiene_pedidos_activos(int $id): bool
    {
        return pedido::where('idcliente', $id)
            ->whereIn('estado', ['recibido', 'en_proceso', 'terminado'])
            ->exists();
    }

    public function obtener_detalle(int $id){
        return cliente::findOrFail($id);
    }

    public function buscar_por_nombre(string $termino){
    return cliente::whereRaw("(nombre || ' ' || apellido) LIKE ?", ["%{$termino}%"])->get();
}

}