<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comentariocf;
use App\Models\Cuentafinanciera;
use App\Models\Equipo;
use App\Models\Estadofactura;
use App\Models\Estadoproducto;
use App\Models\Evaporacion;
use App\Models\Factura;
use App\Models\Sede;
use App\Models\User;
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
        // Filter
        $equipo_id = request('filtro_equipo_id');
        $user_id = request('filtro_user_id');
        $periodo = request('filtro_periodo');
        $cuentafinanciera = request('filtro_cuentafinanciera');
        $ruc = request('filtro_ruc');

        $equipos = Equipo::all();
        if ($equipo_id) {
            $users = Equipo::find($equipo_id)->users;
        } else {
            $users = User::role('ejecutivo')->get();
        }

        $filters = [
            'equipo_id' => $equipo_id,
            'user_id' => $user_id,
            'periodo' => $periodo,
            'cuentafinanciera' => $cuentafinanciera,
            'ruc' => $ruc,
        ];

        $cuentafinancieras = $this->cuentafinancieraService->cuentafinancieraGet($filters);

        return view('sistema.cuentafinanciera.index', compact(
            'cuentafinancieras',
            'equipos',
            'users',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'import') {
            $sedes = Sede::all();
            $categorias = Categoria::whereIn('id', [2, 3])->get();
            $users = User::role('calidad comercial')->get();
            return view('sistema.cuentafinanciera.import', compact(
                'sedes',
                'categorias',
                'users',
            ));
        }
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
            $estadoproductos = Estadoproducto::all();

            return view('sistema.cuentafinanciera.facturas', compact(
                'cuentafinanciera',
                'facturas',
                'estadofacturas',
                'estadoproductos'
            ));
        } elseif ($view === 'show-select-equipo') {
            $equipo = Equipo::find($id);
            $users = $equipo->users;

            return response()->json([
                'users' => $users,
            ]);
        } elseif ($view === 'show-select-user') {
            $users = User::role('ejecutivo')->get();

            return response()->json([
                'users' => $users,
            ]);
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

            // registrar los productos de la factura
            $productosEvaporacion = Evaporacion::where('cuenta_financiera', $cuentafinanciera->cuenta_financiera)->get();
            $detalle = [];
            $lastPeriodo = null;
            foreach ($productosEvaporacion as $key => $value) {
                $estadoProducto = Estadoproducto::where('name', $value->estado_linea)->first();

                $estadoProducto = Estadoproducto::where('name', strtolower($value->estado_linea))->first();
                $detalle[] = [
                    'numero_servicio' => $value->numero_servicio,
                    'orden_pedido' => $value->orden_pedido,
                    'producto' => $value->producto,
                    'cargo_fijo' => $value->cargo_fijo,
                    'monto' => 0,
                    'descuento' => $value->descuento,
                    'descuento_vigencia' => $value->descuento_vigencia,
                    'fecha_instalacion' => $value->fecha_instalacion,
                    'fecha_solicitud' => $value->fecha_solicitud,
                    'fecha_activacion' => $value->fecha_activacion,
                    'periodo_servicio' => $value->periodo_servicio,
                    'fecha_estadoproducto' => $value->fecha_evaluacion,
                    'estadoproducto' => $estadoProducto ? $estadoProducto->name : strtolower($value->estado_linea),
                    'estadoproducto_id' => $estadoProducto ? $estadoProducto->id : null,
                    'cuentafinanciera_id' => $value->cuentafinanciera_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $lastPeriodo = $value->periodo_servicio;
            }
            $factura->detalle = json_encode($detalle, true);
            $factura->save();

            $cuentafinanciera->fecha_evaluacion = now();
            $cuentafinanciera->estadofactura_id = $estadoFactura->id;
            $cuentafinanciera->estado_evaluacion = $estadoFactura->name;
            $cuentafinanciera->periodo = $lastPeriodo;
            $cuentafinanciera->save();

            return response()->json([
                'success' => true,
            ]);
        } elseif ($view === 'update-factura-detalles') {
            $estadoProducto = Estadoproducto::find(request('estadoproducto_id'));

            $factura = Factura::find(request('factura_id'));
            $detalle = json_decode($factura->detalle, true);
            $detalle[request('index')]['monto'] = request('monto');
            $detalle[request('index')]['fecha_estadoproducto'] = request('fecha_estadoproducto');
            $detalle[request('index')]['estadoproducto'] = $estadoProducto->name ?? '';
            $detalle[request('index')]['estadoproducto_id'] = $estadoProducto->id ?? null;
            $factura->detalle = json_encode($detalle);
            $factura->save();

            $montoTotal = 0;
            foreach (json_decode($factura->detalle) as $value) {
                $montoTotal = $value->monto + $montoTotal;
            }
            $factura->monto = $montoTotal;
            $factura->save();

            return response()->json([
                'success' => true,
                'monto' => $detalle[request('index')]['monto'],
                'fechaEstadoProducto' => $detalle[request('index')]['fecha_estadoproducto'],
                'estadoProducto' => $detalle[request('index')]['estadoproducto'],
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
