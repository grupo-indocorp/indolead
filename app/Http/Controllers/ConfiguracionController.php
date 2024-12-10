<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuentafinanciera;
use App\Models\Evaporacion;
use App\Models\User;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function updateCuentaFinanciera()
    {
        $evaporacions = Evaporacion::select('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            ->groupBy('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            ->get();
        $count = 0;
        foreach ($evaporacions as $value) {
            $count++;

            $cliente = Cliente::where('ruc', $value->ruc)->first();
            $user = User::where('identity_document', $value->identificacion_ejecutivo)->first();

            if (! is_null($cliente) && ! is_null($user)) {
                $exists = Cuentafinanciera::where('cuenta_financiera', $value->cuenta_financiera)->exists();

                if (! $exists) {
                    $ultimoEvaporacion = Evaporacion::where('cuenta_financiera', $value->cuenta_financiera)->orderByDesc('id')->first();

                    Cuentafinanciera::create([
                        'cuenta_financiera' => $value->cuenta_financiera,
                        'fecha_evaluacion' => null,
                        'estado_evaluacion' => null,
                        'fecha_descuento' => $ultimoEvaporacion->fecha_evaluacion_descuento_vigencia ?? null,
                        'backoffice_descuento' => 0,
                        'backoffice_descuento_vigencia' => '',
                        'descuento' => $ultimoEvaporacion->evaluacion_descuento != '' ? $ultimoEvaporacion->evaluacion_descuento : 0,
                        'descuento_vigencia' => $ultimoEvaporacion->evaluacion_descuento_vigencia != '' ? $ultimoEvaporacion->evaluacion_descuento_vigencia : 0,
                        'ciclo' => $ultimoEvaporacion->ciclo_factuacion != '' ? $ultimoEvaporacion->ciclo_factuacion : 0,
                        'user_id' => $user->id,
                        'cliente_id' => $cliente->id,
                    ]);
                } else {
                    $ultimoEvaporacion = Evaporacion::where('cuenta_financiera', $value->cuenta_financiera)->orderByDesc('id')->first();

                    Cuentafinanciera::where('cuenta_financiera', $value->cuenta_financiera)->update([
                        'cuenta_financiera' => $value->cuenta_financiera,
                        'fecha_evaluacion' => null,
                        'estado_evaluacion' => null,
                        'fecha_descuento' => $ultimoEvaporacion->fecha_evaluacion_descuento_vigencia ?? null,
                        'backoffice_descuento' => 0,
                        'backoffice_descuento_vigencia' => '',
                        'descuento' => $ultimoEvaporacion->evaluacion_descuento != '' ? $ultimoEvaporacion->evaluacion_descuento : 0,
                        'descuento_vigencia' => $ultimoEvaporacion->evaluacion_descuento_vigencia != '' ? $ultimoEvaporacion->evaluacion_descuento_vigencia : 0,
                        'ciclo' => $ultimoEvaporacion->ciclo_factuacion != '' ? $ultimoEvaporacion->ciclo_factuacion : 0,
                        'user_id' => $user->id,
                        'cliente_id' => $cliente->id,
                    ]);
                }
            }
        }
        dd($count, 'aqui se actualizó cuenta financiera');
    }

    public function updateCuentaFinancieraId()
    {
        $cuentasfinancieras = Cuentafinanciera::all();
        foreach ($cuentasfinancieras as $item) {
            Evaporacion::where('cuenta_financiera', $item->cuenta_financiera)->update([
                'cuentafinanciera_id' => $item->id,
            ]);
        }
        dd('aqui se actualizó cuentafinanciera_id de evaporacions');
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

        return view('sistema.configuracion.index', compact('links'));
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
