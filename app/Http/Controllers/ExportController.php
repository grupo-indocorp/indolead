<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\IndotechFunnelExport;
use App\Exports\SecodiFunnelExport;

class ExportController extends Controller
{
    public function secodiFunnel()
    {
        $filtro = request('filtro');
        $user = auth()->user();
        $nameExport = 'Secodi.xlsx';

        return (new SecodiFunnelExport($filtro, $user))->download($nameExport);
    }

    public function exportFunnel(Request $request)
    {
        $filtro = $request->input('filtro');

        // Acepta tanto string JSON como array
        if (is_string($filtro)) {
            $filtroDecoded = json_decode($filtro, true);
        } else {
            $filtroDecoded = $filtro;
        }

        $user = auth()->user();

        // Convierte SIEMPRE a string JSON para el exportador
        $exporter = new IndotechFunnelExport(json_encode($filtroDecoded), $user);
        return $exporter->exportToCsv();
    }
}
