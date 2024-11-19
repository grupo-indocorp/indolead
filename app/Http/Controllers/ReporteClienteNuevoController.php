<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteClienteNuevoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sede = Sede::all();
        // listado de equipos de huancayo
        $equipos = Equipo::with('users')->where('sede_id', 1)->get();
        $currentMonth = date('Y-m');
        $minMonth = date('Y-01');
        $mostrarEjecutivos = request('mostrarEquipos') === 'active' ? false : true;
        // filtro de mes
        $month = $request->query('mes', now()->format('Y-m'));
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        return view('sistema.reporte_cliente_nuevo.index', compact('month', 'startOfMonth', 'endOfMonth', 'minMonth', 'currentMonth', 'equipos', 'mostrarEjecutivos'));
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
