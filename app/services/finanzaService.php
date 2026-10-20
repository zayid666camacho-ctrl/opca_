<?php

namespace App\services;
use App\Repositories\finanzaRepository;
use App\repositories\PedidoRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class finanzaService{

    private FinanzaRepository $finanzarepository;
    private PedidoRepository $pedidorepository;

    public function __construct(FinanzaRepository $finanzarepository, PedidoRepository $pedidorepository) {
        $this->finanzarepository = $finanzarepository;
        $this->pedidorepository = $pedidorepository;
    }

    public function listar(){
        return $this->finanzarepository->listar();
    }

    public function crear(array $datos){
        $pedido = $this->pedidorepository->buscar($datos['id_pedido']);

        if ((float) $datos['monto'] > (float) $pedido->saldo_pendiente) {
            return [
                'ok' => false,
                'mensaje' => 'El pago no puede ser mayor al saldo pendiente del pedido ($' . number_format($pedido->saldo_pendiente, 2) . ').',
            ];
        }

        $this->finanzarepository->crear($datos);
        $this->recalcular_saldo($datos['id_pedido']);

        return ['ok' => true];
    }

    public function delete(int $id){
        $pago = $this->finanzarepository->buscar($id);
        $id_pedido = $pago->id_pedido;

        $this->finanzarepository->delete($id);
        $this->recalcular_saldo($id_pedido);
    }

    private function recalcular_saldo(int $id_pedido){
        $pedido = $this->pedidorepository->buscar($id_pedido);
        $pagado = $this->pedidorepository->total_pagado($id_pedido);

        $this->pedidorepository->actualizar($id_pedido, [
            'saldo_pendiente' => $pedido->precio - $pagado,
        ]);
    }

    public function resumen_por_mes(int $anio){
        $pagos = $this->finanzarepository->listar_por_anio($anio);

        $por_mes = $pagos->groupBy(function ($pago) {
            return \Carbon\Carbon::parse($pago->fecha)->month;
        });

        $resumen = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $del_mes = $por_mes->get($mes, collect());
            $resumen[$mes] = [
                'total' => $del_mes->sum('monto'),
                'cantidad' => $del_mes->count(),
            ];
        }

        return $resumen;
    }

    public function exportar_excel(int $anio){
        $pagos = $this->finanzarepository->listar_por_anio($anio);
        $resumen = $this->resumen_por_mes($anio);

        $libro = new Spreadsheet();

        // ----- Hoja 1: pagos del año -----
        $hoja_pagos = $libro->getActiveSheet();
        $hoja_pagos->setTitle('Pagos ' . $anio);
        $hoja_pagos->fromArray(['Fecha', 'Cliente', 'Pedido', 'Descripción', 'Monto', 'Notas'], null, 'A1');

        $fila = 2;
        foreach ($pagos as $pago) {
            $hoja_pagos->fromArray([
                $pago->fecha,
                $pago->pedido->cliente->nombre . ' ' . $pago->pedido->cliente->apellido,
                '#' . $pago->pedido->id,
                $pago->pedido->descripcion,
                (float) $pago->monto,
                $pago->notas,
            ], null, 'A' . $fila);
            $fila++;
        }

        $hoja_pagos->setCellValue('D' . $fila, 'Total');
        $hoja_pagos->setCellValue('E' . $fila, (float) $pagos->sum('monto'));

        $hoja_pagos->getStyle('A1:F1')->getFont()->setBold(true);
        $hoja_pagos->getStyle('D' . $fila . ':E' . $fila)->getFont()->setBold(true);
        $hoja_pagos->getStyle('E2:E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        foreach (range('A', 'F') as $columna) {
            $hoja_pagos->getColumnDimension($columna)->setAutoSize(true);
        }

        // ----- Hoja 2: resumen por mes -----
        $hoja_resumen = $libro->createSheet();
        $hoja_resumen->setTitle('Resumen ' . $anio);
        $hoja_resumen->fromArray(['Mes', 'Pagos', 'Total recibido'], null, 'A1');

        $fila = 2;
        foreach ($resumen as $mes => $datos) {
            $nombre_mes = ucfirst(\Carbon\Carbon::createFromDate($anio, $mes, 1)->locale('es')->monthName);
            $hoja_resumen->fromArray([$nombre_mes, $datos['cantidad'], (float) $datos['total']], null, 'A' . $fila);
            $fila++;
        }

        $hoja_resumen->setCellValue('A' . $fila, 'Total del año');
        $hoja_resumen->setCellValue('C' . $fila, (float) collect($resumen)->sum('total'));

        $hoja_resumen->getStyle('A1:C1')->getFont()->setBold(true);
        $hoja_resumen->getStyle('A' . $fila . ':C' . $fila)->getFont()->setBold(true);
        $hoja_resumen->getStyle('C2:C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        foreach (range('A', 'C') as $columna) {
            $hoja_resumen->getColumnDimension($columna)->setAutoSize(true);
        }

        return $libro;
    }

}