<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de la galería de trabajos.
 * Implementación: App\Repositories\GaleriaRepository (enlazada en AppServiceProvider).
 */
interface GaleriaRepositoryInterface
{
    public function listar(?string $categoria = null, bool $solo_visibles = false);

    public function buscar(int $id);

    public function crear(array $datos);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);

    public function alternar_visibilidad(int $id);

    public function categorias();
}
