<?php

namespace Database\Seeders;

use App\Models\cliente;
use App\Models\pedido;
use App\Models\precio_base;
use App\Models\tipo_servicio;
use App\services\NuevoPedidoService;
use Illuminate\Database\Seeder;

/**
 * Pedidos de demostración con sus prendas (servicios) y abonos (finanzas).
 *
 * Se crean a través de NuevoPedidoService (la misma lógica que usa el flujo guiado),
 * así el precio congelado de cada prenda, el total y el saldo pendiente quedan
 * calculados igual que en la vida real. Las fechas son relativas a hoy para que
 * el Calendario y el Kanban siempre muestren datos al ejecutar el seeder.
 *
 * Requiere: ClienteSeeder, PrecioBaseSeeder y TipoServicioSeeder.
 */
class PedidoSeeder extends Seeder
{
    public function run(NuevoPedidoService $nuevo_pedido_service): void
    {
        $hoy = now();

        $pedidos = [
            [
                'correo' => 'laura.gomez@example.com',
                'descripcion' => 'Vestido para grado',
                'fecha' => $hoy->copy()->subDays(6), 'entrega' => $hoy->copy()->addDays(8),
                'estado' => 'en_proceso',
                'prendas' => [['Vestido', 'confeccion', 'Vestido largo color vino, escote en V']],
                'abono' => 60000,
            ],
            [
                'correo' => 'carlos.ramirez@example.com',
                'descripcion' => 'Arreglos varios',
                'fecha' => $hoy->copy()->subDays(3), 'entrega' => $hoy->copy()->addDays(2),
                'estado' => 'recibido',
                'prendas' => [
                    ['Arreglo de dobladillo', 'arreglo', 'Subir bota 3 cm a dos jeans'],
                    ['Ajuste de manga', 'arreglo', 'Acortar mangas de chaqueta'],
                ],
                'abono' => null,
            ],
            [
                'correo' => 'marcela.torres@example.com',
                'descripcion' => 'Conjunto para evento',
                'fecha' => $hoy->copy()->subDays(12), 'entrega' => $hoy->copy()->subDay(),
                'estado' => 'terminado',
                'prendas' => [['Conjunto camisa y pantalón', 'confeccion', 'Lino beige']],
                'abono' => 80000,
            ],
            [
                'correo' => 'andres.perez@example.com',
                'descripcion' => 'Camisa de diseño propio',
                'fecha' => $hoy->copy()->subDays(14), 'entrega' => $hoy->copy()->subDays(4),
                'estado' => 'entregado',
                'prendas' => [['Camisa', 'diseno', 'Camisa manga larga con bordado']],
                'abono' => 60000,
            ],
            [
                'correo' => 'laura.gomez@example.com',
                'descripcion' => 'Cambio de cierre de chaqueta',
                'fecha' => $hoy->copy(), 'entrega' => $hoy->copy()->addDays(4),
                'estado' => 'recibido',
                'prendas' => [['Cambio de cierre', 'arreglo', null]],
                'abono' => 5000,
            ],
        ];

        foreach ($pedidos as $datos) {
            $cliente = cliente::where('correo', $datos['correo'])->first();

            // Si falta el cliente o el pedido ya fue sembrado antes, se omite (no duplica)
            if (! $cliente || pedido::where('idcliente', $cliente->id)->where('descripcion', $datos['descripcion'])->exists()) {
                continue;
            }

            $prendas = [];
            foreach ($datos['prendas'] as [$nombre_prenda, $tipo, $detalle]) {
                $prendas[] = [
                    'id_precio_bases'   => precio_base::where('nombre_prenda', $nombre_prenda)->value('id'),
                    'id_tipo_servicios' => tipo_servicio::where('servicio', $tipo)->value('id'),
                    'descripcion'       => $detalle,
                ];
            }

            $nuevo = $nuevo_pedido_service->crear([
                'cliente_modo'  => 'existente',
                'idcliente'     => $cliente->id,
                'fecha'         => $datos['fecha']->toDateString(),
                'fecha_entrega' => $datos['entrega']->toDateString(),
                'descripcion'   => $datos['descripcion'],
                'prendas'       => $prendas,
                'abono_activo'  => $datos['abono'] !== null,
                'abono_monto'   => $datos['abono'],
                'abono_fecha'   => $datos['fecha']->toDateString(),
                'abono_notas'   => $datos['abono'] !== null ? 'Abono inicial' : null,
            ]);

            // El flujo guiado siempre crea el pedido como 'recibido'; aquí se ubica en su columna del Kanban
            $nuevo->update(['estado' => $datos['estado']]);
        }
    }
}
