<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los precios base por prenda.
 * Implementación: App\Repositories\PreciobaseRepository (enlazada en AppServiceProvider).
 */
interface PreciobaseRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function buscar(int $id);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);
}
