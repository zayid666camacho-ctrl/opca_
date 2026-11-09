<?php

namespace App\repositories\Contracts;

/**
 * Contrato de acceso a datos de los pedidos.
 * Implementación: App\Repositories\PedidoRepository (enlazada en AppServiceProvider).
 */
interface PedidoRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function buscar(int $id);

    public function actualizar(int $id, array $datos);

    public function delete(int $id);

    public function listar_por_rango($primer_dia, $ultimo_dia);

    public function listar_para_kanban($fecha_limite);

    public function filtrar($cliente, $estado, $desde, $hasta);

    public function tiene_servicios(int $id);

    public function listar_por_cliente(int $id_cliente, int $excluir_id);

    public function total_pagado(int $id);

    public function listar_con_saldo();

    public function buscar_por_correo_cliente(string $correo);
}
