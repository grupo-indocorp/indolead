<?php

namespace App\Http\Controllers;

use App\Charts\GraficoDeAnillo;
use App\Charts\GraficoDeConversion;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Etapa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request, GraficoDeAnillo $chartBuilder, GraficoDeConversion $conversionChartBuilder)
    {
        // Validar parámetros
        $validator = Validator::make($request->all(), [
            'equipo' => 'nullable|integer|exists:equipos,id',
            'ejecutivo' => 'nullable|integer|exists:users,id',
            'fecha' => 'nullable|date_format:m/Y', // Validar el formato de la fecha
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard')->withErrors($validator);
        }

        // Obtener parámetros
        $equipoSeleccionado = $request->input('equipo');
        $ejecutivoSeleccionado = $request->input('ejecutivo');

        // Validar coherencia equipo-ejecutivo
        if ($equipoSeleccionado && $ejecutivoSeleccionado) {
            $ejecutivoValido = User::where('id', $ejecutivoSeleccionado)
                ->whereHas('equipos', fn ($q) => $q->where('equipo_id', $equipoSeleccionado))
                ->exists();

            if (! $ejecutivoValido) {
                $ejecutivoSeleccionado = null;
                $request->merge(['ejecutivo' => null]);
            }
        }

        // Obtener y parsear fecha
        $fechaSeleccionada = null;
        if ($request->filled('fecha')) {
            $fechaSeleccionada = Carbon::createFromFormat('m/Y', $request->fecha)->startOfMonth();
        }

        // Obtener datos base
        $equipos = Equipo::all();

        // Obtener ejecutivos según equipo
        $ejecutivos = $equipoSeleccionado
            ? User::whereHas('equipos', fn ($q) => $q->where('equipo_id', $equipoSeleccionado))->get()
            : collect();

        // Construir query principal
        $clientesQuery = Cliente::query()
            ->when($equipoSeleccionado, fn ($q) => $q->where('equipo_id', $equipoSeleccionado))
            ->when($ejecutivoSeleccionado, fn ($q) => $q->where('user_id', $ejecutivoSeleccionado))
            ->when($fechaSeleccionada, fn ($q) => $q->whereBetween('fecha_gestion', [
                $fechaSeleccionada->startOfMonth()->toDateString(), // Primer día del mes
                $fechaSeleccionada->endOfMonth()->toDateString(),    // Último día del mes
            ]));

        // Calcular métricas
        $totalClientes = $clientesQuery->count();
        $etapaCinco = Etapa::findOrFail(5);
        $clientesEnEtapaCinco = $clientesQuery->clone()->where('etapa_id', $etapaCinco->id)->count();
        $convertibilidad = $totalClientes > 0 ? round(($clientesEnEtapaCinco / $totalClientes) * 100, 2) : 0;

        // Generar gráficos
        $chart = $chartBuilder->build($clientesQuery->clone());
        $conversionChart = $conversionChartBuilder->build($clientesQuery->clone());

        return view('sistema.dashboard.index', [
            'chart' => $chart,
            'conversionChart' => $conversionChart,
            'equipos' => $equipos,
            'ejecutivos' => $ejecutivos,
            'equipoSeleccionado' => $equipoSeleccionado,
            'ejecutivoSeleccionado' => $ejecutivoSeleccionado,
            'fechaSeleccionada' => $fechaSeleccionada,
            'totalClientes' => $totalClientes,
            'clientesEnEtapaCinco' => $clientesEnEtapaCinco,
            'etapaCinco' => $etapaCinco,
            'convertibilidad' => $convertibilidad,
        ]);
    }
}
