<?php

namespace App\Http\Controllers;

use App\Models\Cuentafinanciera;
use App\Models\Evaporacion;
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
        if ($view === 'show-detalle') {
            $cuentafinanciera = $this->cuentafinancieraService->cuentafinancieraDetalle($id);
            $cantidadCuentafinancieras = Cuentafinanciera::where('cliente_id', $cuentafinanciera->cliente_id)->get();

            return view('sistema.cuentafinanciera.detalle', compact(
                'cuentafinanciera',
                'cantidadCuentafinancieras',
            ));
        } elseif ($view === 'show-productos') {
            $cuentafinanciera = Cuentafinanciera::find($id);
            $productosEvaporacion = Evaporacion::where('cuenta_financiera', $cuentafinanciera->cuenta_financiera)->get();

            return view('sistema.cuentafinanciera.productos', compact(
                'productosEvaporacion',
            ));
        } elseif ($view === 'show-facturas') {
            $cuentafinanciera = Cuentafinanciera::find($id);
            $facturasEvaporacion = Evaporacion::where('cuenta_financiera', $cuentafinanciera->cuenta_financiera)
                ->orderByDesc('id')
                ->first();

            return view('sistema.cuentafinanciera.facturas', compact(
                'facturasEvaporacion',
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
