<?php

namespace App\Imports;

use App\Models\Evaporacion;
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
        $evaporaciones = Evaporacion::where('Identificacion', $row[0])->first();

        if (!is_null($evaporaciones)) {
            $evaporaciones->update([
                'RucNumero' => $row[1] ?? '',
                'RucRazonSocial' => $row[2] ?? '',
                'ProductoNumero' => $row[3] ?? '',
                'ProductoOrden' => $row[4] ?? '',
                'ProductoNombre' => $row[5] ?? '',
                'ProductoCargoFijo' => $row[6] ?? '',
                'ProductoDescuento' => $row[7] ?? '',
                'ProductoDescuentoVigencia' => $row[8] ?? '',
                'ProductoCuentaFinanciera' => $row[9] ?? '',
                'EjecutivoNombre' => $row[10] ?? '',
                'EjecutivoCodigo' => $row[11] ?? '',
                'EjecutivoEquipo' => $row[12] ?? '',
                'EjecutivoSupervisor' => $row[13] ?? '',
                'FechaSolicitud' => $row[14] ?? '',
                'FechaActivacion1' => $row[15] ?? '',
                'FechaEjecutivoPeriodo' => $row[16] ?? '',
                'IdEvaporacion' => $row[17] ?? '',
                'FechaActivacion2' => $row[18] ?? '',
                'FechaEvaluacion' => $row[19] ?? '',
                'EvaluacionEstado' => $row[20] ?? '',
                'EvaluacionEstadoFecha' => $row[21] ?? '',
                'EvaluacionDescuento' => $row[22] ?? '',
                'EvaluacionDescuentoVigencia' => $row[23] ?? '',
                'EvaluacionDescuentoFecha' => $row[24] ?? '',
                'CicloFacturación' => $row[25] ?? '',
                'EstadoFacturacion1' => $row[26] ?? '',
                'FechaEmision1' => $row[27] ?? '',
                'FechaVencimiento1' => $row[28] ?? '',
                'MontoFacturado1' => $row[29] ?? '',
                'Deuda1' => $row[30] ?? '',
                'EstadoFacturacion2' => $row[31] ?? '',
                'FechaEmision2' => $row[32] ?? '',
                'FechaVencimiento2' => $row[33] ?? '',
                'MontoFacturado2' => $row[34] ?? '',
                'Deuda2' => $row[35] ?? '',
                'EstadoFacturacion3' => $row[36] ?? '',
                'FechaEmision3' => $row[37] ?? '',
                'FechaVencimiento3' => $row[38] ?? '',
                'MontoFacturado3' => $row[39] ?? '',
                'Deuda3' => $row[40] ?? '',
                'Observacion' => $row[41] ?? '',
            ]);
        } else {
            return new Evaporacion([
                'Identificacion' => $row[0] ?? '',
                'RucNumero' => $row[1] ?? '',
                'RucRazonSocial' => $row[2] ?? '',
                'ProductoNumero' => $row[3] ?? '',
                'ProductoOrden' => $row[4] ?? '',
                'ProductoNombre' => $row[5] ?? '',
                'ProductoCargoFijo' => $row[6] ?? '',
                'ProductoDescuento' => $row[7] ?? '',
                'ProductoDescuentoVigencia' => $row[8] ?? '',
                'ProductoCuentaFinanciera' => $row[9] ?? '',
                'EjecutivoNombre' => $row[10] ?? '',
                'EjecutivoCodigo' => $row[11] ?? '',
                'EjecutivoEquipo' => $row[12] ?? '',
                'EjecutivoSupervisor' => $row[13] ?? '',
                'FechaSolicitud' => $row[14] ?? '',
                'FechaActivacion1' => $row[15] ?? '',
                'FechaEjecutivoPeriodo' => $row[16] ?? '',
                'IdEvaporacion' => $row[17] ?? '',
                'FechaActivacion2' => $row[18] ?? '',
                'FechaEvaluacion' => $row[19] ?? '',
                'EvaluacionEstado' => $row[20] ?? '',
                'EvaluacionEstadoFecha' => $row[21] ?? '',
                'EvaluacionDescuento' => $row[22] ?? '',
                'EvaluacionDescuentoVigencia' => $row[23] ?? '',
                'EvaluacionDescuentoFecha' => $row[24] ?? '',
                'CicloFacturación' => $row[25] ?? '',
                'EstadoFacturacion1' => $row[26] ?? '',
                'FechaEmision1' => $row[27] ?? '',
                'FechaVencimiento1' => $row[28] ?? '',
                'MontoFacturado1' => $row[29] ?? '',
                'Deuda1' => $row[30] ?? '',
                'EstadoFacturacion2' => $row[31] ?? '',
                'FechaEmision2' => $row[32] ?? '',
                'FechaVencimiento2' => $row[33] ?? '',
                'MontoFacturado2' => $row[34] ?? '',
                'Deuda2' => $row[35] ?? '',
                'EstadoFacturacion3' => $row[36] ?? '',
                'FechaEmision3' => $row[37] ?? '',
                'FechaVencimiento3' => $row[38] ?? '',
                'MontoFacturado3' => $row[39] ?? '',
                'Deuda3' => $row[40] ?? '',
                'Observacion' => $row[41] ?? '',
            ]);
        }
    }
}
