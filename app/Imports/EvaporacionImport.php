<?php

namespace App\Imports;

use App\Models\Evaporacion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EvaporacionImport implements ToModel, WithStartRow
{
    /**
     * Indica la fila de inicio (segunda fila).
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Inicia desde la segunda fila
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $evaporaciones = Evaporacion::where('numero_servicio', $row[3])->first();

        $excel14 = isset($row[14]) ? (int) $row[14] : null;
        $fecha_solicitud = $excel14 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel14 - 2) : null;
        $excel15 = isset($row[15]) ? (int) $row[15] : null;
        $fecha_activacion = $excel15 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel15 - 2) : null;
        $excel17 = isset($row[17]) ? (int) $row[17] : null;
        $fecha_evaluacion = $excel17 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel17 - 2) : null;
        $excel19 = isset($row[19]) ? (int) $row[19] : null;
        $fecha_estado_linea = $excel19 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel19 - 2) : null;
        $excel22 = isset($row[22]) ? (int) $row[22] : null;
        $fecha_evaluacion_descuento_vigencia = $excel22 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel22 - 2) : null;
        $excel25 = isset($row[25]) ? (int) $row[25] : null;
        $fecha_emision1 = $excel25 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel25 - 2) : null;
        $excel26 = isset($row[26]) ? (int) $row[26] : null;
        $fecha_vencimiento1 = $excel26 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel26 - 2) : null;
        $excel30 = isset($row[30]) ? (int) $row[30] : null;
        $fecha_emision2 = $excel30 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel30 - 2) : null;
        $excel31 = isset($row[31]) ? (int) $row[31] : null;
        $fecha_vencimiento2 = $excel31 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel31 - 2) : null;
        $excel35 = isset($row[35]) ? (int) $row[35] : null;
        $fecha_emision3 = $excel35 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel35 - 2) : null;
        $excel36 = isset($row[36]) ? (int) $row[36] : null;
        $fecha_vencimiento3 = $excel36 ? Carbon::createFromDate(1900, 1, 1)->addDays($excel36 - 2) : null;

        if (!is_null($evaporaciones)) {
            $evaporaciones->update([
                'ruc' => $row[1] ?? '',
                'razon_social' => $row[2] ?? '',
                'numero_servicio' => $row[3] ?? '',
                'orden_pedido' => $row[4] ?? '',
                'producto' => $row[5] ?? '',
                'cargo_fijo' => $row[6] ?? '',
                'descuento' => $row[7] ?? '',
                'descuento_vigencia' => $row[8] ?? '',
                'cuenta_financiera' => $row[9] ?? '',
                'ejecutivo' => $row[10] ?? '',
                'identificacion_ejecutivo' => $row[11] ?? '',
                'equipo' => $row[12] ?? '',
                'supervisor' => $row[13] ?? '',
                'fecha_solicitud' => $fecha_solicitud,
                'fecha_activacion' => $fecha_activacion,
                'periodo_servicio' => $row[16] ?? '',
                'fecha_evaluacion' => $fecha_evaluacion,
                'estado_linea' => $row[18] ?? '',
                'fecha_estado_linea' => $fecha_estado_linea,
                'evaluacion_descuento' => $row[20] ?? '',
                'evaluacion_descuento_vigencia' => $row[21] ?? '',
                'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                'ciclo_factuacion' => $row[23] ?? '',
                'estado_facturacion1' => $row[24] ?? '',
                'fecha_emision1' => $fecha_emision1,
                'fecha_vencimiento1' => $fecha_vencimiento1,
                'monto_facturado1' => $row[27] ?? '',
                'deuda1' => $row[28] ?? '',
                'estado_facturacion2' => $row[29] ?? '',
                'fecha_emision2' => $fecha_emision2,
                'fecha_vencimiento2' => $fecha_vencimiento2,
                'monto_facturado2' => $row[32] ?? '',
                'deuda2' => $row[33] ?? '',
                'estado_facturacion3' => $row[34] ?? '',
                'fecha_emision3' => $fecha_emision3,
                'fecha_vencimiento3' => $fecha_vencimiento3,
                'monto_facturado3' => $row[37] ?? '',
                'deuda3' => $row[38] ?? '',
                'observacion' => $row[39] ?? '',
            ]);
        } else {
            if ($row[0] != '') {
                return new Evaporacion([
                    'identificacion' => $row[0] ?? '',
                    'ruc' => $row[1] ?? '',
                    'razon_social' => $row[2] ?? '',
                    'numero_servicio' => $row[3] ?? '',
                    'orden_pedido' => $row[4] ?? '',
                    'producto' => $row[5] ?? '',
                    'cargo_fijo' => $row[6] ?? '',
                    'descuento' => $row[7] ?? '',
                    'descuento_vigencia' => $row[8] ?? '',
                    'cuenta_financiera' => $row[9] ?? '',
                    'ejecutivo' => $row[10] ?? '',
                    'identificacion_ejecutivo' => $row[11] ?? '',
                    'equipo' => $row[12] ?? '',
                    'supervisor' => $row[13] ?? '',
                    'fecha_solicitud' => $fecha_solicitud,
                    'fecha_activacion' => $fecha_activacion,
                    'periodo_servicio' => $row[16] ?? '',
                    'fecha_evaluacion' => $fecha_evaluacion,
                    'estado_linea' => $row[18] ?? '',
                    'fecha_estado_linea' => $fecha_estado_linea,
                    'evaluacion_descuento' => $row[20] ?? '',
                    'evaluacion_descuento_vigencia' => $row[21] ?? '',
                    'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                    'ciclo_factuacion' => $row[23] ?? '',
                    'estado_facturacion1' => $row[24] ?? '',
                    'fecha_emision1' => $fecha_emision1,
                    'fecha_vencimiento1' => $fecha_vencimiento1,
                    'monto_facturado1' => $row[27] ?? '',
                    'deuda1' => $row[28] ?? '',
                    'estado_facturacion2' => $row[29] ?? '',
                    'fecha_emision2' => $fecha_emision2,
                    'fecha_vencimiento2' => $fecha_vencimiento2,
                    'monto_facturado2' => $row[32] ?? '',
                    'deuda2' => $row[33] ?? '',
                    'estado_facturacion3' => $row[34] ?? '',
                    'fecha_emision3' => $fecha_emision3,
                    'fecha_vencimiento3' => $fecha_vencimiento3,
                    'monto_facturado3' => $row[37] ?? '',
                    'deuda3' => $row[38] ?? '',
                    'observacion' => $row[39] ?? '',
                ]);
            }
        }
    }
}
