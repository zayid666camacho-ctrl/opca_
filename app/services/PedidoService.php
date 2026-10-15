<?php

namespace App\services;

use App\Models\pedido;
use App\repositories\PedidoRepository;
use GuzzleHttp\Psr7\Request;

class PedidoService{

    private PedidoRepository $pedidorepository;

    public function __construct(PedidoRepository $pedidorepository) {
        $this->pedidorepository = $pedidorepository;
    }

    public function listar(){
        return $this->pedidorepository->listar();
    }

    public function crear(array $datos){
        $datos['precio'] = 0;
        $datos['saldo_pendiente'] = 0;
        return $this->pedidorepository->crear($datos);
    }

    public function buscar(int $id){
        return $this->pedidorepository->buscar($id);
    }

    public function actualizar(int $id, array $datos){
        $this->pedidorepository->actualizar($id, $datos);
    }

    public function delete(int $id){
        if ($this->pedidorepository->tiene_servicios($id)) {
            return ['ok' => false, 'mensaje' => 'No se puede eliminar un pedido que ya tiene prendas registradas.'];
        }

        $this->pedidorepository->delete($id);

        return ['ok' => true];
    }

    public function listar_por_rango($primer_dia, $ultimo_dia){
        return $this->pedidorepository->listar_por_rango($primer_dia, $ultimo_dia);
    }

    public function cambiar_estado(int $id, string $nuevo_estado)
    {
        $pedido = $this->pedidorepository->buscar($id);

        if ($pedido->estado === 'cancelado') {
            return ['ok' => false, 'mensaje' => 'Un pedido cancelado no puede cambiar de estado.'];
        }

        if ($nuevo_estado === 'cancelado' && !in_array($pedido->estado, ['recibido', 'en_proceso'])) {
            return ['ok' => false, 'mensaje' => 'Solo se puede cancelar un pedido que esté recibido o en proceso.'];
        }

        $this->pedidorepository->actualizar($id, ['estado' => $nuevo_estado]);
        return ['ok' => true];
    }

    public function listar_para_kanban($dias){
        $fecha_limite = now()->subDays($dias);
        $pedidos = $this->pedidorepository->listar_para_kanban($fecha_limite);

        return $pedidos->groupBy('estado')->map(function ($grupo, $estado) {
            if (in_array($estado, ['entregado', 'cancelado'])) {
                return $grupo->sortByDesc('updated_at')->values();
            }
            return $grupo->sortBy('fecha_entrega')->values();
        });
    }

    public function filtrar($cliente, $estado, $desde, $hasta){
        return $this->pedidorepository->filtrar($cliente, $estado, $desde, $hasta);
    }

}