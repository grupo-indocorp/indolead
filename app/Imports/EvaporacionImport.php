<?php

namespace App\Imports;

use App\Models\Evaporacion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EvaporacionImport implements ToModel, WithStartRow
{
    protected $categoria_id;
    protected $sede_id;
    protected $user_evaporacion;

    public function __construct($categoria_id, $sede_id, $user_evaporacion)
    {
        $this->categoria_id = $categoria_id;
        $this->sede_id = $sede_id;
        $this->user_evaporacion = $user_evaporacion;
    }

    /**
     * Indica la fila de inicio (segunda fila).
     */
    public function startRow(): int
    {
        return 2; // Inicia desde la segunda fila
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->categoria_id == 3) { // fija
            $evaporaciones = Evaporacion::where('numero_servicio', $row[3])->first();

            $fechas = [
                'fecha_ingreso' => $row[14] ?? null,
                'fecha_instalacion' => $row[15] ?? null,
                'fecha_evaluacion' => $row[21] ?? null,
                'fecha_estado_linea' => $row[23] ?? null,
                'fecha_evaluacion_descuento_vigencia' => $row[26] ?? null,
                'fecha_emision1' => $row[29] ?? null,
                'fecha_vencimiento1' => $row[30] ?? null,
                'fecha_emision2' => $row[35] ?? null,
                'fecha_vencimiento2' => $row[36] ?? null,
                'fecha_emision3' => $row[41] ?? null,
                'fecha_vencimiento3' => $row[42] ?? null,
            ];
            foreach ($fechas as $key => $value) {
                $fechas[$key] = $this->convertirAFecha((int) $value);
            }
            extract($fechas);

            $deuda_total = '';
            $feedback = '';
            if ($this->sede_id == 1) { // huancayo
                $deuda_total = $row[47] ?? '';
                $feedback = $row[48] ?? '';
            }

            if (! is_null($evaporaciones)) {
                $evaporaciones->update([
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
                    'fecha_ingreso' => $fecha_ingreso,
                    'fecha_instalacion' => $fecha_instalacion,
                    'fecha_solicitud' => null,
                    'fecha_activacion' => null,
                    'periodo_servicio' => $row[16] ?? '',
                    'direccion' => $row[17] ?? '',
                    'distrito' => $row[18] ?? '',
                    'provincia' => $row[19] ?? '',
                    'departamento' => $row[20] ?? '',
                    'fecha_evaluacion' => $fecha_evaluacion,
                    'estado_linea' => $row[22] ?? '',
                    'fecha_estado_linea' => $fecha_estado_linea,
                    'evaluacion_descuento' => $row[24] ?? '',
                    'evaluacion_descuento_vigencia' => $row[25] ?? '',
                    'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                    'ciclo_factuacion' => $row[27] ?? '',
                    'estado_facturacion1' => $row[28] ?? '',
                    'fecha_emision1' => $fecha_emision1,
                    'fecha_vencimiento1' => $fecha_vencimiento1,
                    'monto_facturado1' => $row[31] ?? '',
                    'deuda1' => $row[32] ?? '',
                    'monto_parcial1' => $row[33] ?? '',
                    'estado_facturacion2' => $row[34] ?? '',
                    'fecha_emision2' => $fecha_emision2,
                    'fecha_vencimiento2' => $fecha_vencimiento2,
                    'monto_facturado2' => $row[37] ?? '',
                    'deuda2' => $row[38] ?? '',
                    'monto_parcial2' => $row[39] ?? '',
                    'estado_facturacion3' => $row[40] ?? '',
                    'fecha_emision3' => $fecha_emision3,
                    'fecha_vencimiento3' => $fecha_vencimiento3,
                    'monto_facturado3' => $row[43] ?? '',
                    'deuda3' => $row[44] ?? '',
                    'monto_parcial3' => $row[45] ?? '',
                    'observacion' => $row[46] ?? '',
                    'deuda_total' => $deuda_total,
                    'feedback' => $feedback,
                    'categoria_id' => $this->categoria_id,
                    'sede_id' => $this->sede_id,
                    'user_evaporacion' => $this->user_evaporacion,
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
                        'fecha_ingreso' => $fecha_ingreso,
                        'fecha_instalacion' => $fecha_instalacion,
                        'fecha_solicitud' => null,
                        'fecha_activacion' => null,
                        'periodo_servicio' => $row[16] ?? '',
                        'direccion' => $row[17] ?? '',
                        'distrito' => $row[18] ?? '',
                        'provincia' => $row[19] ?? '',
                        'departamento' => $row[20] ?? '',
                        'fecha_evaluacion' => $fecha_evaluacion,
                        'estado_linea' => $row[22] ?? '',
                        'fecha_estado_linea' => $fecha_estado_linea,
                        'evaluacion_descuento' => $row[24] ?? '',
                        'evaluacion_descuento_vigencia' => $row[25] ?? '',
                        'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                        'ciclo_factuacion' => $row[27] ?? '',
                        'estado_facturacion1' => $row[28] ?? '',
                        'fecha_emision1' => $fecha_emision1,
                        'fecha_vencimiento1' => $fecha_vencimiento1,
                        'monto_facturado1' => $row[31] ?? '',
                        'deuda1' => $row[32] ?? '',
                        'monto_parcial1' => $row[33] ?? '',
                        'estado_facturacion2' => $row[34] ?? '',
                        'fecha_emision2' => $fecha_emision2,
                        'fecha_vencimiento2' => $fecha_vencimiento2,
                        'monto_facturado2' => $row[37] ?? '',
                        'deuda2' => $row[38] ?? '',
                        'monto_parcial2' => $row[39] ?? '',
                        'estado_facturacion3' => $row[40] ?? '',
                        'fecha_emision3' => $fecha_emision3,
                        'fecha_vencimiento3' => $fecha_vencimiento3,
                        'monto_facturado3' => $row[43] ?? '',
                        'deuda3' => $row[44] ?? '',
                        'monto_parcial3' => $row[45] ?? '',
                        'observacion' => $row[46] ?? '',
                        'deuda_total' => $deuda_total,
                        'feedback' => $feedback,
                        'categoria_id' => $this->categoria_id,
                        'sede_id' => $this->sede_id,
                        'user_evaporacion' => $this->user_evaporacion,
                    ]);
                }
            }
        } elseif ($this->categoria_id == 2) {  // movil
            $evaporaciones = Evaporacion::where('numero_servicio', $row[3])->first();

            $fechas = [
                'fecha_solicitud' => $row[13] ?? null,
                'fecha_activacion' => $row[14] ?? null,
                'fecha_evaluacion' => $row[16] ?? null,
                'fecha_estado_linea' => $row[18] ?? null,
                'fecha_evaluacion_descuento_vigencia' => $row[21] ?? null,
                'fecha_emision1' => $row[24] ?? null,
                'fecha_vencimiento1' => $row[25] ?? null,
                'fecha_emision2' => $row[29] ?? null,
                'fecha_vencimiento2' => $row[30] ?? null,
                'fecha_emision3' => $row[34] ?? null,
                'fecha_vencimiento3' => $row[35] ?? null,
            ];
            foreach ($fechas as $key => $value) {
                $fechas[$key] = $this->convertirAFecha((int) $value);
            }
            extract($fechas);

            $observacion = '';
            $deuda_total = '';
            if ($this->sede_id == 1) { // huancayo
                $observacion = $row[38] ?? '';
                $deuda_total = $row[39] ?? '';
            } elseif ($this->sede_id == 2) { // lima
                $deuda_total = $row[38] ?? '';
                $observacion = $row[39] ?? '';
            }

            if (! is_null($evaporaciones)) {
                $evaporaciones->update([
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
                    'identificacion_ejecutivo' => null,
                    'equipo' => $row[11] ?? '',
                    'supervisor' => $row[12] ?? '',
                    'fecha_ingreso' => null,
                    'fecha_instalacion' => null,
                    'fecha_solicitud' => $fecha_solicitud,
                    'fecha_activacion' => $fecha_activacion,
                    'periodo_servicio' => $row[15] ?? '',
                    'direccion' => null,
                    'distrito' => null,
                    'provincia' => null,
                    'departamento' => null,
                    'fecha_evaluacion' => $fecha_evaluacion,
                    'estado_linea' => $row[17] ?? '',
                    'fecha_estado_linea' => $fecha_estado_linea,
                    'evaluacion_descuento' => $row[19] ?? '',
                    'evaluacion_descuento_vigencia' => $row[20] ?? '',
                    'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                    'ciclo_factuacion' => $row[22] ?? '',
                    'estado_facturacion1' => $row[23] ?? '',
                    'fecha_emision1' => $fecha_emision1,
                    'fecha_vencimiento1' => $fecha_vencimiento1,
                    'monto_facturado1' => $row[26] ?? '',
                    'deuda1' => $row[27] ?? '',
                    'monto_parcial1' => null,
                    'estado_facturacion2' => $row[28] ?? '',
                    'fecha_emision2' => $fecha_emision2,
                    'fecha_vencimiento2' => $fecha_vencimiento2,
                    'monto_facturado2' => $row[31] ?? '',
                    'deuda2' => $row[32] ?? '',
                    'monto_parcial2' => null,
                    'estado_facturacion3' => $row[33] ?? '',
                    'fecha_emision3' => $fecha_emision3,
                    'fecha_vencimiento3' => $fecha_vencimiento3,
                    'monto_facturado3' => $row[36] ?? '',
                    'deuda3' => $row[37] ?? '',
                    'monto_parcial3' => null,
                    'observacion' => $observacion,
                    'deuda_total' => $deuda_total,
                    'feedback' => null,
                    'categoria_id' => $this->categoria_id,
                    'sede_id' => $this->sede_id,
                    'user_evaporacion' => $this->user_evaporacion,
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
                        'identificacion_ejecutivo' => null,
                        'equipo' => $row[11] ?? '',
                        'supervisor' => $row[12] ?? '',
                        'fecha_ingreso' => null,
                        'fecha_instalacion' => null,
                        'fecha_solicitud' => $fecha_solicitud,
                        'fecha_activacion' => $fecha_activacion,
                        'periodo_servicio' => $row[15] ?? '',
                        'direccion' => null,
                        'distrito' => null,
                        'provincia' => null,
                        'departamento' => null,
                        'fecha_evaluacion' => $fecha_evaluacion,
                        'estado_linea' => $row[17] ?? '',
                        'fecha_estado_linea' => $fecha_estado_linea,
                        'evaluacion_descuento' => $row[19] ?? '',
                        'evaluacion_descuento_vigencia' => $row[20] ?? '',
                        'fecha_evaluacion_descuento_vigencia' => $fecha_evaluacion_descuento_vigencia,
                        'ciclo_factuacion' => $row[22] ?? '',
                        'estado_facturacion1' => $row[23] ?? '',
                        'fecha_emision1' => $fecha_emision1,
                        'fecha_vencimiento1' => $fecha_vencimiento1,
                        'monto_facturado1' => $row[26] ?? '',
                        'deuda1' => $row[27] ?? '',
                        'monto_parcial1' => null,
                        'estado_facturacion2' => $row[28] ?? '',
                        'fecha_emision2' => $fecha_emision2,
                        'fecha_vencimiento2' => $fecha_vencimiento2,
                        'monto_facturado2' => $row[31] ?? '',
                        'deuda2' => $row[32] ?? '',
                        'monto_parcial2' => null,
                        'estado_facturacion3' => $row[33] ?? '',
                        'fecha_emision3' => $fecha_emision3,
                        'fecha_vencimiento3' => $fecha_vencimiento3,
                        'monto_facturado3' => $row[36] ?? '',
                        'deuda3' => $row[37] ?? '',
                        'monto_parcial3' => null,
                        'observacion' => $observacion,
                        'deuda_total' => $deuda_total,
                        'feedback' => null,
                        'categoria_id' => $this->categoria_id,
                        'sede_id' => $this->sede_id,
                        'user_evaporacion' => $this->user_evaporacion,
                    ]);
                }
            }

        }
    }

    private function convertirAFecha($valor) {
        return $valor ? Carbon::createFromDate(1900, 1, 1)->addDays($valor - 2) : null;
    }
}
