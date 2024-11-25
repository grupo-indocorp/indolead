<?php

namespace App\Http\Controllers;

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

    public function indotechFunnel()
    {
        $filtro = request('filtro');
        $user = auth()->user();
        $nameExport = 'Indotech.xlsx';

        return (new IndotechFunnelExport($filtro, $user))->download($nameExport);
    }
}
