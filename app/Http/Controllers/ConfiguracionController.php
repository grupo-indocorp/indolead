<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuentafinanciera;
use App\Models\Evaporacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function updateCuentaFinanciera()
    {
        $evaporacions = Evaporacion::select('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            ->groupBy('cuenta_financiera', 'ruc', 'identificacion_ejecutivo')
            ->get();
        foreach ($evaporacions as $value) {
            $cliente_id = Cliente::where('ruc', $value->ruc)->first()->id;
            $user = User::where('identity_document', $value->identificacion_ejecutivo)->first();
            if (!is_null($user)) {
                Cuentafinanciera::insert([
                    'cuenta_financiera' => $value->cuenta_financiera,
                    'fecha_evaluacion' => null,
                    'estado_evaluacion' => null,
                    'user_id' => $user->id,
                    'equipo_id' => null,
                    'cliente_id' => $cliente_id,
                ]);
            }
        }
        $cuentafinancieras = Cuentafinanciera::all();
        dd($cuentafinancieras);
        dd('aqui se actualizó cuenta financiera');
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
