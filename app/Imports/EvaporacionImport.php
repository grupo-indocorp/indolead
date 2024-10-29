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
        $evaporaciones = Evaporacion::where('Identificacion', $row[0])->first();

        $excelDate = isset($row[14]) ? (int) $row[14] : null;
        $FechaSolicitud = $excelDate ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate - 2) : null;
        $excelDate1 = isset($row[15]) ? (int) $row[15] : null;
        $FechaActivacion1 = $excelDate1 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate1 - 2) : null;
        $excelDate2 = isset($row[18]) ? (int) $row[18] : null;
        $FechaActivacion2 = $excelDate2 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate2 - 2) : null;
        $excelDate3 = isset($row[19]) ? (int) $row[19] : null;
        $FechaEvaluacion = $excelDate3 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate3 - 2) : null;
        $excelDate4 = isset($row[27]) ? (int) $row[27] : null;
        $FechaEmision1 = $excelDate4 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate4 - 2) : null;
        $excelDate5 = isset($row[28]) ? (int) $row[28] : null;
        $FechaVencimiento1 = $excelDate5 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate5 - 2) : null;
        $excelDate6 = isset($row[32]) ? (int) $row[32] : null;
        $FechaEmision2 = $excelDate6 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate6 - 2) : null;
        $excelDate7 = isset($row[33]) ? (int) $row[33] : null;
        $FechaVencimiento2 = $excelDate7 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate7 - 2) : null;
        $excelDate8 = isset($row[37]) ? (int) $row[37] : null;
        $FechaEmision3 = $excelDate8 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate8 - 2) : null;
        $excelDate9 = isset($row[38]) ? (int) $row[38] : null;
        $FechaVencimiento3 = $excelDate9 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate9 - 2) : null;
        $excelDate21 = isset($row[21]) ? (int) $row[21] : null;
        $EvaluacionEstadoFecha = $excelDate21 ? Carbon::createFromDate(1900, 1, 1)->addDays($excelDate21 - 2) : null;

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
                'FechaSolicitud' => $FechaSolicitud,
                'FechaActivacion1' => $FechaActivacion1,
                'FechaEjecutivoPeriodo' => $row[16] ?? '',
                'IdEvaporacion' => $row[17] ?? '',
                'FechaActivacion2' => $FechaActivacion2,
                'FechaEvaluacion' => $FechaEvaluacion,
                'EvaluacionEstado' => $row[20] ?? '',
                'EvaluacionEstadoFecha' => $EvaluacionEstadoFecha,
                'EvaluacionDescuento' => $row[22] ?? '',
                'EvaluacionDescuentoVigencia' => $row[23] ?? '',
                'EvaluacionDescuentoFecha' => $row[24] ?? '',
                'CicloFacturación' => $row[25] ?? '',
                'EstadoFacturacion1' => $row[26] ?? '',
                'FechaEmision1' => $FechaEmision1,
                'FechaVencimiento1' => $FechaVencimiento1,
                'MontoFacturado1' => $row[29] ?? '',
                'Deuda1' => $row[30] ?? '',
                'EstadoFacturacion2' => $row[31] ?? '',
                'FechaEmision2' => $FechaEmision2,
                'FechaVencimiento2' => $FechaVencimiento2,
                'MontoFacturado2' => $row[34] ?? '',
                'Deuda2' => $row[35] ?? '',
                'EstadoFacturacion3' => $row[36] ?? '',
                'FechaEmision3' => $FechaEmision3,
                'FechaVencimiento3' => $FechaVencimiento3,
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
                'FechaSolicitud' => $FechaSolicitud,
                'FechaActivacion1' => $FechaActivacion1,
                'FechaEjecutivoPeriodo' => $row[16] ?? '',
                'IdEvaporacion' => $row[17] ?? '',
                'FechaActivacion2' => $FechaActivacion2,
                'FechaEvaluacion' => $FechaEvaluacion,
                'EvaluacionEstado' => $row[20] ?? '',
                'EvaluacionEstadoFecha' => $EvaluacionEstadoFecha,
                'EvaluacionDescuento' => $row[22] ?? '',
                'EvaluacionDescuentoVigencia' => $row[23] ?? '',
                'EvaluacionDescuentoFecha' => $row[24] ?? '',
                'CicloFacturación' => $row[25] ?? '',
                'EstadoFacturacion1' => $row[26] ?? '',
                'FechaEmision1' => $FechaEmision1,
                'FechaVencimiento1' => $FechaVencimiento1,
                'MontoFacturado1' => $row[29] ?? '',
                'Deuda1' => $row[30] ?? '',
                'EstadoFacturacion2' => $row[31] ?? '',
                'FechaEmision2' => $FechaEmision2,
                'FechaVencimiento2' => $FechaVencimiento2,
                'MontoFacturado2' => $row[34] ?? '',
                'Deuda2' => $row[35] ?? '',
                'EstadoFacturacion3' => $row[36] ?? '',
                'FechaEmision3' => $FechaEmision3,
                'FechaVencimiento3' => $FechaVencimiento3,
                'MontoFacturado3' => $row[39] ?? '',
                'Deuda3' => $row[40] ?? '',
                'Observacion' => $row[41] ?? '',
            ]);
        }
    }
}
