<?php

namespace App\Http\Controllers;

use App\Imports\EvaporacionImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function evaporacion()
    {
        $categoria_id = request('categoria_id');
        $sede_id = request('sede_id');
        $user_evaporacion = request('user_evaporacion');
        Excel::import(new EvaporacionImport($categoria_id, $sede_id, $user_evaporacion), request()->file('file'));

        // return redirect()->route('update.cuentafinanciera');
        return redirect()->route('cuentas-financieras.index')->with('success', 'Archivo importado exitosamente.');
    }
}
