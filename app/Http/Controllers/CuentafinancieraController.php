<?php

namespace App\Http\Controllers;

use App\Models\Comentariocf;
use App\Models\Cuentafinanciera;
use App\Models\Estadofactura;
use App\Models\Evaporacion;
use App\Models\Factura;
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
            $facturas = Factura::with(['estadofactura'])
                ->where('cuentafinanciera_id', $cuentafinanciera->id)
                ->get();
            $estadofacturas = Estadofactura::all();

            return view('sistema.cuentafinanciera.facturas', compact(
                'cuentafinanciera',
                'facturas',
                'estadofacturas',
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
        if ($view === 'update-cuentafinanciera') {
            $cuentafinanciera = Cuentafinanciera::find($id);
            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->fecha_descuento = request('fecha_descuento');
            $cuentafinanciera->descuento = request('descuento');
            $cuentafinanciera->descuento_vigencia = request('descuento_vigencia');
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
            ]);
        } elseif ($view === 'update-producto-edit') {
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
                    'observacion' => request('observacion_calidad'),
                ]);
            }

            $cuentafinanciera = Cuentafinanciera::find($id);
            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->ultimo_comentario = request('observacion_calidad');
            $cuentafinanciera->save();

            // Guardar historial de comentarios de la cuenta financiera
            $comentariocf = new Comentariocf;
            $comentariocf->comentario = request('observacion_calidad');
            $comentariocf->user_id = auth()->user()->id;
            $comentariocf->cuentafinanciera_id = $id;
            $comentariocf->save();

            return response()->json([
                'success' => true,
            ]);
        } elseif ($view === 'update-factura') {
            $estadoFactura = Estadofactura::find(request('estado_factura'));

            $cuentafinanciera = Cuentafinanciera::find($id);

            $factura = Factura::find(request('factura_id'));
            $factura->fecha_emision = now();
            $factura->fecha_vencimiento = now();
            $factura->monto = request('monto_factura');
            $factura->deuda = request('deuda_factura');
            $factura->estadofactura_id = $estadoFactura->id;
            $factura->cuentafinanciera_id = $id;
            $factura->save();

            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->estadofactura_id = $estadoFactura->id;
            $cuentafinanciera->estado_evaluacion = $estadoFactura->name;
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
            ]);
        } elseif ($view === 'update-store-factura') {
            $estadoFactura = Estadofactura::find(request('estado_factura'));

            $cuentafinanciera = Cuentafinanciera::find($id);

            $factura = new Factura;
            $factura->fecha_emision = now();
            $factura->fecha_vencimiento = now();
            $factura->monto = request('monto_factura');
            $factura->deuda = request('deuda_factura');
            $factura->estadofactura_id = $estadoFactura->id;
            $factura->cuentafinanciera_id = $cuentafinanciera->id;
            $factura->save();

            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->estadofactura_id = $estadoFactura->id;
            $cuentafinanciera->estado_evaluacion = $estadoFactura->name;
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
