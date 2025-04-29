<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuentafinanciera;
use App\Models\Estadofactura;
use App\Models\Estadoproducto;
use App\Models\Evaporacion;
use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConfiguracionController extends Controller
{
    public function updateCuentaFinanciera()
    {
        $evaporacions = Evaporacion::select('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            ->groupBy('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            // ->limit(10)
            ->get();
        foreach ($evaporacions as $value) {
            $cliente = Cliente::where('ruc', $value->ruc)->first();
            $user = User::where('identity_document', $value->identificacion_ejecutivo)
                ->orWhere('name', 'like', '%' . $value->ejecutivo . '%')
                ->first();

            if (! is_null($cliente) && ! is_null($user)) {
                $exists = Cuentafinanciera::where('cuenta_financiera', $value->cuenta_financiera)->exists();

                if (! $exists) {
                    $ultimoEvaporacion = Evaporacion::where('cuenta_financiera', $value->cuenta_financiera)->orderByDesc('id')->first();
                    Cuentafinanciera::create([
                        'cuenta_financiera' => $value->cuenta_financiera,
                        'fecha_evaluacion' => null,
                        'estado_evaluacion' => null,
                        'periodo' => $ultimoEvaporacion->periodo_servicio,
                        'ultimo_deuda_factura' => $ultimoEvaporacion->monto_facturado3,
                        'ultimo_monto_factura' => $ultimoEvaporacion->deuda3,
                        'fecha_descuento' => $ultimoEvaporacion->fecha_evaluacion_descuento_vigencia ?? null,
                        'backoffice_descuento' => 0,
                        'backoffice_descuento_vigencia' => '',
                        'descuento' => $ultimoEvaporacion->evaluacion_descuento != '' ? $ultimoEvaporacion->evaluacion_descuento : 0,
                        'descuento_vigencia' => $ultimoEvaporacion->evaluacion_descuento_vigencia != '' ? $ultimoEvaporacion->evaluacion_descuento_vigencia : 0,
                        'ciclo' => $ultimoEvaporacion->ciclo_factuacion != '' ? $ultimoEvaporacion->ciclo_factuacion : 0,
                        'text_cliente_ruc' => $cliente->ruc,
                        'text_cliente_razon_social' => $cliente->razon_social,
                        'text_user_nombre' => $user->name,
                        'text_user_equipo' => $user->equipos->last()->nombre ?? 0,
                        'ultimo_comentario' => '',
                        'user_id' => $user->id,
                        'cliente_id' => $cliente->id,
                        'categoria_id' => $ultimoEvaporacion->categoria_id,
                        'user_evaporacion' => $ultimoEvaporacion->user_evaporacion,
                    ]);
                } else {
                    $ultimoEvaporacion = Evaporacion::where('cuenta_financiera', $value->cuenta_financiera)->orderByDesc('id')->first();
                    Cuentafinanciera::where('cuenta_financiera', $value->cuenta_financiera)->update([
                        'cuenta_financiera' => $value->cuenta_financiera,
                        'fecha_evaluacion' => null,
                        'estado_evaluacion' => null,
                        'periodo' => $ultimoEvaporacion->periodo_servicio,
                        'ultimo_deuda_factura' => $ultimoEvaporacion->monto_facturado3,
                        'ultimo_monto_factura' => $ultimoEvaporacion->deuda3,
                        'fecha_descuento' => $ultimoEvaporacion->fecha_evaluacion_descuento_vigencia ?? null,
                        'backoffice_descuento' => 0,
                        'backoffice_descuento_vigencia' => '',
                        'descuento' => $ultimoEvaporacion->evaluacion_descuento != '' ? $ultimoEvaporacion->evaluacion_descuento : 0,
                        'descuento_vigencia' => $ultimoEvaporacion->evaluacion_descuento_vigencia != '' ? $ultimoEvaporacion->evaluacion_descuento_vigencia : 0,
                        'ciclo' => $ultimoEvaporacion->ciclo_factuacion != '' ? $ultimoEvaporacion->ciclo_factuacion : 0,
                        'text_cliente_ruc' => $cliente->ruc,
                        'text_cliente_razon_social' => $cliente->razon_social,
                        'text_user_nombre' => $user->name,
                        'text_user_equipo' => $user->equipos->last()->nombre,
                        'ultimo_comentario' => '',
                        'user_id' => $user->id,
                        'cliente_id' => $cliente->id,
                        'categoria_id' => $ultimoEvaporacion->categoria_id,
                        'user_evaporacion' => $ultimoEvaporacion->user_evaporacion,
                    ]);
                }
            }
        }

        $cuentasfinancieras = Cuentafinanciera::all();
        foreach ($cuentasfinancieras as $item) {
            Evaporacion::where('cuenta_financiera', $item->cuenta_financiera)->update([
                'cuentafinanciera_id' => $item->id,
            ]);
        }

        // $this->updateFactura();
        return redirect()->route('cuentas-financieras.index')->with('success', 'Archivo importado exitosamente.');
    }

    public function updateFactura()
    {
        $facturasEvaporacion = Evaporacion::orderByDesc('id')
            ->get()
            ->groupBy('cuentafinanciera_id')
            ->map(function (Collection $group) {
                return [
                    'total_monto_facturado1' => $group->sum(fn ($item) => (float) $item->monto_facturado1),
                    'total_monto_facturado2' => $group->sum(fn ($item) => (float) $item->monto_facturado2),
                    'total_monto_facturado3' => $group->sum(fn ($item) => (float) $item->monto_facturado3),
                    'first' => $group->first(),
                ];
            });

        $detalle = [];
        foreach ($facturasEvaporacion as $key => $value) {
            $estadoProducto = Estadoproducto::where('name', strtolower($value['first']->estado_linea))->first();
            $detalle[] = [
                'numero_servicio' => $value['first']->numero_servicio,
                'orden_pedido' => $value['first']->orden_pedido,
                'producto' => $value['first']->producto,
                'cargo_fijo' => $value['first']->cargo_fijo,
                'monto' => 0,
                'descuento' => $value['first']->descuento,
                'descuento_vigencia' => $value['first']->descuento_vigencia,
                'fecha_instalacion' => $value['first']->fecha_instalacion,
                'fecha_solicitud' => $value['first']->fecha_solicitud,
                'fecha_activacion' => $value['first']->fecha_activacion,
                'periodo_servicio' => $value['first']->periodo_servicio,
                'fecha_estadoproducto' => $value['first']->fecha_evaluacion,
                'estadoproducto' => $estadoProducto ? $estadoProducto->name : strtolower($value['first']->estado_linea),
                'estadoproducto_id' => $estadoProducto ? $estadoProducto->id : null,
                'cuentafinanciera_id' => $value['first']->cuentafinanciera_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $estado1 = Estadofactura::where('name', strtolower($value['first']->estado_facturacion1))->first();
            if (! is_null($value['first']->fecha_emision1) && ! is_null($estado1) && ! is_null($value['first']->cuentafinanciera_id)) {
                $factura1 = new Factura;
                $factura1->fecha_emision = $value['first']->fecha_emision1;
                $factura1->fecha_vencimiento = $value['first']->fecha_vencimiento1;
                $factura1->monto = $value['total_monto_facturado1'];
                $factura1->deuda = $value['first']->deuda1;
                $factura1->detalle = json_encode($detalle, true);
                $factura1->estadofactura_id = $estado1->id;
                $factura1->cuentafinanciera_id = $value['first']->cuentafinanciera_id;
                $factura1->save();
            }

            $estado2 = Estadofactura::where('name', strtolower($value['first']->estado_facturacion2))->first();
            if (! is_null($value['first']->fecha_emision2) && ! is_null($estado2) && ! is_null($value['first']->cuentafinanciera_id)) {
                $factura2 = new Factura;
                $factura2->fecha_emision = $value['first']->fecha_emision2;
                $factura2->fecha_vencimiento = $value['first']->fecha_vencimiento2;
                $factura2->monto = $value['total_monto_facturado2'];
                $factura2->deuda = $value['first']->deuda2;
                $factura2->detalle = json_encode($detalle, true);
                $factura2->estadofactura_id = $estado2->id;
                $factura2->cuentafinanciera_id = $value['first']->cuentafinanciera_id;
                $factura2->save();
            }

            $estado3 = Estadofactura::where('name', strtolower($value['first']->estado_facturacion3))->first();
            if (! is_null($value['first']->fecha_emision3) && ! is_null($estado3) && ! is_null($value['first']->cuentafinanciera_id)) {
                $factura3 = new Factura;
                $factura3->fecha_emision = $value['first']->fecha_emision3;
                $factura3->fecha_vencimiento = $value['first']->fecha_vencimiento3;
                $factura3->monto = $value['total_monto_facturado3'];
                $factura3->deuda = $value['first']->deuda3;
                $factura3->detalle = json_encode($detalle, true);
                $factura3->estadofactura_id = $estado3->id;
                $factura3->cuentafinanciera_id = $value['first']->cuentafinanciera_id;
                $factura3->save();
            }
            $detalle = [];
        }

        // return true;
        return redirect()->route('cuentas-financieras.index')->with('success', 'Archivo importado exitosamente.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = [
            [
                'title' => 'Sistema',
                'icon' => '<i class="fa-solid fa-planet-moon"></i>',
                'link' => 'configuracion-sistema',
            ],
            [
                'title' => 'Etapas',
                'icon' => '<i class="fa-solid fa-arrow-progress"></i>',
                'link' => 'configuracion-etapa',
            ],
            [
                'title' => 'Categorias',
                'icon' => '<i class="fa-solid fa-layer-group"></i>',
                'link' => 'configuracion-categoria',
            ],
            [
                'title' => 'Productos',
                'icon' => '<i class="fa-solid fa-cart-shopping"></i>',
                'link' => 'configuracion-producto',
            ],
            [
                'title' => 'Excel',
                'icon' => '<i class="fa-solid fa-file-excel"></i>',
                'link' => 'configuracion-excel',
            ],
            [
                'title' => 'Ficha del Cliente',
                'icon' => '<i class="fa-solid fa-database"></i>',
                'link' => 'configuracion-ficha-cliente',
            ],
        ];

        $links_evaporacion = [
            [
                'title' => 'Estados de Factura',
                'icon' => '<i class="fa-solid fa-route-interstate"></i>',
                'link' => 'configuracion-estado-factura',
            ],
        ];

        return view('sistema.configuracion.index', compact('links', 'links_evaporacion'));
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
        //
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
