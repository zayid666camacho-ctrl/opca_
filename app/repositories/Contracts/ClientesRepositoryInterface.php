<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los clientes del taller.
 * Implementación: App\Repositories\ClientesRepository (enlazada en AppServiceProvider).
 */
interface ClientesRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function buscar(int $id);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);

    public function tiene_pedidos_activos(int $id): bool;

    public function obtener_detalle(int $id);

    public function buscar_por_nombre(string $termino);
}
