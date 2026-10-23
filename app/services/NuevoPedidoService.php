<?php

namespace App\services;

use Illuminate\Support\Facades\DB;

class NuevoPedidoService{

    private ClientesService $clientesservice;
    private PedidoService $pedidoservice;
    private servicioService $servicioservice;
    private FinanzaService $finanzaservice;

    public function __construct(
        ClientesService $clientesservice,
        PedidoService $pedidoservice,
        servicioService $servicioservice,
        FinanzaService $finanzaservice
    ) {
        $this->clientesservice = $clientesservice;
        $this->pedidoservice = $pedidoservice;
        $this->servicioservice = $servicioservice;
        $this->finanzaservice = $finanzaservice;
    }

    public function crear(array $datos){
        return DB::transaction(function () use ($datos) {

            // 1. Cliente: nuevo o existente
            if ($datos['cliente_modo'] === 'nuevo') {
                $cliente = $this->clientesservice->crear($datos['cliente']);
                $id_cliente = $cliente->id;
            } else {
                $id_cliente = (int) $datos['idcliente'];
            }

            // 2. Medidas del cliente (solo si se enviaron)
            $medidas = $this->filtrar_medidas($datos['medidas'] ?? []);
            if (!empty($medidas)) {
                $this->clientesservice->actualizar($id_cliente, $medidas);
            }

            // 3. Pedido
            $pedido = $this->pedidoservice->crear([
                'fecha'         => $datos['fecha'],
                'fecha_entrega' => $datos['fecha_entrega'],
                'estado'        => 'recibido',
                'descripcion'   => $datos['descripcion'] ?? null,
                'idcliente'     => $id_cliente,
            ]);

            // 4. Prendas (cada una congela su precio y recalcula el total)
            foreach ($datos['prendas'] as $prenda) {
                $this->servicioservice->crear([
                    'id_pedido'         => $pedido->id,
                    'id_precio_bases'   => $prenda['id_precio_bases'],
                    'id_tipo_servicios' => $prenda['id_tipo_servicios'],
                    'descripcion'       => $prenda['descripcion'] ?? null,
                ]);
            }

            // 5. Abono opcional
            if (!empty($datos['abono_activo'])) {
                $resultado = $this->finanzaservice->crear([
                    'id_pedido' => $pedido->id,
                    'monto'     => $datos['abono_monto'],
                    'fecha'     => $datos['abono_fecha'],
                    'notas'     => $datos['abono_notas'] ?? null,
                ]);

                if (!$resultado['ok']) {
                    throw new \DomainException($resultado['mensaje']);
                }
            }

            return $pedido;
        });
    }

    private function filtrar_medidas(array $medidas){
        $campos = [
            'ancho_espalda', 'largo_espalda', 'contorno_pecho', 'hombro', 'manga', 'puño',
            'antebrazo', 'cintura_suelta', 'largo_total', 'cintura', 'tiro', 'pierna',
            'rodilla', 'largo_pierna', 'bota',
        ];

        return array_intersect_key($medidas, array_flip($campos));
    }

}