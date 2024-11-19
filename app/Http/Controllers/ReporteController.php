<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Sede;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = Sede::all();

        return view('sistema.reporte.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request('view') == 'create-filtro-cliente') {
            // $clientes = Cliente::with([
            //         'user', 'user.equipos', 'contactos',
            //         'movistars', 'movistars.estadowick', 'movistars.estadodito',
            //         'etapas', 'comentarios'
            //     ])
            //     ->whereHas('etapas', function ($query) {
            //         $query->where('id', 1);
            //     })
            //     ->orderByDesc('id')
            //     ->get();
            $clientes = Cliente::with(['user', 'user.equipos', 'user.equipos.sede'])->get();
            $data = [];
            foreach ($clientes as $value) {
                if (isset($value->user->equipos->last()->sede_id) && $value->user->equipos->last()->sede_id == request('sede_id')) {
                    $data[] = [
                        'id' => $value->id,
                        'ruc' => $value->ruc,
                    ];
                }
            }
            dd($data);
            $fecha_desde = request('fecha_desde');
            $fecha_hasta = request('fecha_hasta');

            return view('sistema.reporte.create_filtro_cliente', compact('clientes', 'fecha_desde', 'fecha_hasta'));
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
