<?php

namespace App\Services;

use App\Repositories\InventarioRepository;

class InventarioService
{
    private InventarioRepository $inventariorepository;

    public function __construct(InventarioRepository $inventariorepository)
    {
        $this->inventariorepository = $inventariorepository;
    }

    public function listar(?string $buscar = null, ?string $categoria = null)
    {
        return $this->inventariorepository->listar($buscar, $categoria);
    }

    public function buscar(int $id)
    {
        return $this->inventariorepository->buscar($id);
    }

    public function crear(array $datos)
    {
        // Forzamos enteros en stocks y float en precio
        $datos['stock'] = (int) ($datos['stock'] ?? 0);
        $datos['stock_minimo'] = (int) ($datos['stock_minimo'] ?? 0);
        $datos['precio_unitario'] = (float) ($datos['precio_unitario'] ?? 0);

        return $this->inventariorepository->crear($datos);
    }

    public function actualizar(int $id, array $datos)
    {
        $datos['stock'] = (int) ($datos['stock'] ?? 0);
        $datos['stock_minimo'] = (int) ($datos['stock_minimo'] ?? 0);
        $datos['precio_unitario'] = (float) ($datos['precio_unitario'] ?? 0);

        return $this->inventariorepository->actualizar($id, $datos);
    }

    public function delete(int $id)
    {
        $this->inventariorepository->delete($id);
    }

    public function obtener_alertas()
    {
        $materiales_bajos = $this->inventariorepository->listar_stock_bajo();
        return [
            'total' => $materiales_bajos->count(),
            'items' => $materiales_bajos,
        ];
    }

    public function categorias()
    {
        return $this->inventariorepository->categorias();
    }
}