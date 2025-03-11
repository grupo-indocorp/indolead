<?php

namespace App\Http\Controllers;

use App\Imports\EvaporacionImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function evaporacion()
    {
        $categoria_id = request('categoria_id');
        $sede_id= request('sede_id');
        Excel::import(new EvaporacionImport($categoria_id, $sede_id), request()->file('file'));

        // dd('Importación de evaporación completada');
        return redirect()->route('update.cuentafinanciera');
    }
}
