<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sistema.configuracion.excel.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store') {
            $configData = [
                'indotech' => is_null(request('excelIndotech')) ? false : true,
                'secodi' => is_null(request('excelSecodi')) ? false : true,
            ];
            Helpers::configuracionExcelJsonPut('excel', $configData);

            return redirect()->route('configuracion-excel.index')->with('success', 'Accesos de Excel Actualizados.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $view = request('view');
        if ($view === 'edit') {
            $config = Helpers::configuracionExcelJsonGet();
            $indotech = $config['excel']['indotech'];
            $secodi = $config['excel']['secodi'];

            return view('sistema.configuracion.excel.edit', compact('indotech', 'secodi'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
