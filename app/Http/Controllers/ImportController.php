<?php

namespace App\Http\Controllers;

use App\Imports\EvaporacionImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function evaporacion()
    {
        Excel::import(new EvaporacionImport, request()->file('file'));
        return redirect()->route('evaporacion.index')->with('success', 'Archivo importado exitosamente.');
    }
}
