<?php

namespace App\Http\Controllers;

use App\Models\Comentariocf;
use App\Models\Cuentafinanciera;
use App\Models\Estadofactura;
use App\Models\Estadoproducto;
use App\Models\Evaporacion;
use App\Models\Factura;
use App\Models\Facturadetalle;
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
        } elseif ($view === 'show-factura-detalles') {
            if (!is_null(request('factura_id'))) {
                $factura = Factura::find(request('factura_id'));
            } else {
                $cuentafinanciera = Cuentafinanciera::with(['facturas'])->find($id);
                if ($cuentafinanciera && $cuentafinanciera->facturas->isNotEmpty()) {
                    $factura = $cuentafinanciera->facturas->last();
                }
            }
            $facturadetalles = Facturadetalle::with(['estadoproducto', 'factura'])
                ->where('factura_id', $factura->id)
                ->get();
            $estadoproductos = Estadoproducto::all();

            return view('sistema.cuentafinanciera.factura-detalles', compact(
                'facturadetalles',
                'estadoproductos',
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

            // registrar los productos de la factura
            $productosEvaporacion = Evaporacion::where('cuenta_financiera', $cuentafinanciera->cuenta_financiera)->get();
            foreach ($productosEvaporacion as $key => $value) {
                $estadoProducto = Estadoproducto::where('name', $value->estado_linea)->first();

                $facturadetalle = new Facturadetalle();
                $facturadetalle->numero_servicio = $value->numero_servicio;
                $facturadetalle->orden_pedido = $value->orden_pedido;
                $facturadetalle->producto = $value->producto;
                $facturadetalle->cargo_fijo = $value->cargo_fijo;
                $facturadetalle->monto = $value->cargo_fijo;
                $facturadetalle->descuento = $value->descuento;
                $facturadetalle->descuento_vigencia = $value->descuento_vigencia;
                $facturadetalle->fecha_solicitud = $value->fecha_solicitud;
                $facturadetalle->fecha_activacion = $value->fecha_activacion;
                $facturadetalle->periodo_servicio = $value->periodo_servicio;
                $facturadetalle->estadoproducto_id = $estadoProducto->id;
                $facturadetalle->factura_id = $factura->id;
                $facturadetalle->save();
            }

            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->estadofactura_id = $estadoFactura->id;
            $cuentafinanciera->estado_evaluacion = $estadoFactura->name;
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
            ]);
        } elseif ($view === 'update-factura-detalles') {
            $facturadetalle = Facturadetalle::find(request('facturadetalle_id'));
            $estadoProducto = Estadoproducto::find(request('estadoproducto_id'));

            $facturadetalle->monto = request('monto');
            $facturadetalle->fecha_estadoproducto = request('fecha_estadoproducto');
            $facturadetalle->estadoproducto_id = $estadoProducto->id;
            $facturadetalle->save();

            // Actualizando monto de la factura
            $facturadetalles = Facturadetalle::with(['estadoproducto'])
                ->where('factura_id', $facturadetalle->factura_id)
                ->get();
            $montoTotal = 0;
            foreach ($facturadetalles as $value) {
                $montoTotal = $value->monto + $montoTotal;
            }
            $factura = Factura::find($facturadetalle->factura_id);
            $factura->monto = $montoTotal;
            $factura->save();

            return response()->json([
                'success' => true,
                'monto' => $facturadetalle->monto,
                'fechaEstadoProducto' => $facturadetalle->fecha_estadoproducto,
                'estadoProducto' => $facturadetalle->estadoproducto->name,
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
