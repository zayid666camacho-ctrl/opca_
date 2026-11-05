<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los tipos de servicio (confección, arreglo, diseño).
 * Implementación: App\Repositories\TiposervicioRepository (enlazada en AppServiceProvider).
 */
interface TiposervicioRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function edit(int $id);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);
}
