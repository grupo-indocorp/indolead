<?php

namespace App\Http\Controllers;

use App\Models\Cuentafinanciera;
use App\Services\CuentafinancieraService;
use Illuminate\Http\Request;

class CuentafinancieraController extends Controller
{
    protected $cuentafinancieraService;

    public function __construct(CuentafinancieraService $cuentafinancieraService)
    {
        $this->cuentafinancieraService = $cuentafinancieraService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuentafinancieras = $this->cuentafinancieraService->cuentafinancieraGet();

        return view('sistema.cuentafinanciera.index', compact(
            'cuentafinancieras'
        ));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $view = request('view');
        if ($view === 'show-cuentafinanciera') {
            $cuentafinanciera = $this->cuentafinancieraService->cuentafinancieraDetalle($id);

            return view('sistema.cuentafinanciera.detalle', compact(
                'cuentafinanciera'
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
