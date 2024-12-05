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
        } elseif ($view === 'show-cuentafinanciera') {
            $cuentafinanciera = Cuentafinanciera::find($id);

            return view('sistema.cuentafinanciera.show', compact(
                'cuentafinanciera',
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
        $view = request('view');
        if ($view === 'update-producto-edit') {
            $evaporacion = Evaporacion::find(request('evaporacion_id'));
            $evaporacion->cargo_fijo = request('cargo_fijo');
            $evaporacion->fecha_estado_linea = request('fecha_estado_linea');
            $evaporacion->estado_linea = request('estado_linea');
            $evaporacion->save();

            $cuentafinanciera = Cuentafinanciera::find($id);
            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
                'cargoFijo' => $evaporacion->cargo_fijo,
                'fechaEstadoLinea' => $evaporacion->fecha_estado_linea,
                'estadoLinea' => $evaporacion->estado_linea,
            ]);
        } elseif ($view === 'update-comentario-calidad') {
            $evaporacion = Evaporacion::where('cuentafinanciera_id', $id)->get();
            foreach ($evaporacion as $value) {
                Evaporacion::find($value->id)->update([
                    'observacion' => request('observacion_calidad')
                ]);
            }

            $cuentafinanciera = Cuentafinanciera::find($id);
            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
