<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los servicios (prendas dentro de un pedido).
 * Implementación: App\Repositories\ServicioRepository (enlazada en AppServiceProvider).
 */
interface ServicioRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function buscars(int $id);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);

    public function listar_por_pedido(int $idpedido);
}
