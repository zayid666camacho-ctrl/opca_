<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos del inventario de materiales.
 * Implementación: App\Repositories\InventarioRepository (enlazada en AppServiceProvider).
 */
interface InventarioRepositoryInterface
{
    public function listar(?string $buscar = null, ?string $categoria = null);

    public function buscar(int $id);

    public function crear(array $datos);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);

    public function listar_stock_bajo();

    public function categorias();
}
