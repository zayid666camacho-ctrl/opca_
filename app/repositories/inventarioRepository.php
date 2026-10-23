<?php

namespace App\Repositories;

use App\Models\inventario;

class InventarioRepository
{
    public function listar(?string $buscar = null, ?string $categoria = null)
    {
        $consulta = inventario::query();

        if ($buscar) {
            $consulta->where('nombre', 'like', '%' . $buscar . '%');
        }

        if ($categoria) {
            $consulta->where('categoria', $categoria);
        }

        return $consulta->orderBy('nombre', 'asc')->get();
    }

    public function buscar(int $id)
    {
        return inventario::findOrFail($id);
    }

    public function crear(array $datos)
    {
        return inventario::create($datos);
    }

    public function actualizar(int $id, array $datos)
    {
        $material = $this->buscar($id);
        $material->update($datos);
        return $material;
    }

    public function delete(int $id)
    {
        inventario::destroy($id);
    }

    public function listar_stock_bajo()
    {
        // En SQLite y MySQL: compara columnas stock <= stock_minimo
        return inventario::whereColumn('stock', '<=', 'stock_minimo')
            ->orderBy('stock', 'asc')
            ->get();
    }

    public function categorias()
    {
        return inventario::distinct()
            ->whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->pluck('categoria');
    }
}