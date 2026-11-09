<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los pagos/abonos (Finanzas).
 * Implementación: App\Repositories\FinanzaRepository (enlazada en AppServiceProvider).
 */
interface FinanzaRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function buscar(int $id);

    public function delete(int $id);

    public function listar_por_anio(int $anio);
}
