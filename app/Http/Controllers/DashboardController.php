<?php

namespace App\Http\Controllers;

use App\Charts\GraficoDeAnillo;
use App\Charts\GraficoDeConversion;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Etapa;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, GraficoDeAnillo $chartBuilder, GraficoDeConversion $conversionChartBuilder)
    {
        $equipoSeleccionado = $request->input('equipo');
        $ejecutivoSeleccionado = $request->input('ejecutivo');
        $mesSeleccionado = $request->input('mes');

        // Obtener los equipos
        $equipos = Equipo::all();

        // Obtener ejecutivos según el equipo seleccionado
        if ($equipoSeleccionado) {
            $ejecutivos = User::whereHas('equipos', function ($query) use ($equipoSeleccionado) {
                $query->where('equipo_id', $equipoSeleccionado);
            })->get();
        } else {
            $ejecutivos = User::role('ejecutivo')->get();
        }

        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        // Filtrar clientes según los filtros seleccionados
        $clientesQuery = Cliente::query();

        if ($equipoSeleccionado) {
            $clientesQuery->where('equipo_id', $equipoSeleccionado);
        }

        if ($ejecutivoSeleccionado) {
            $clientesQuery->where('user_id', $ejecutivoSeleccionado);
        }

        if ($mesSeleccionado) {
            $clientesQuery->whereMonth('fecha_gestion', $mesSeleccionado);
        }

        // Calcular el total de clientes según los filtros
        $totalClientes = $clientesQuery->count();

        // Obtener la etapa con id 5
        $etapaCinco = Etapa::find(5);

        // Calcular el conteo de clientes en la etapa con id 5
        $clientesEnEtapaCinco = $clientesQuery->where('etapa_id', $etapaCinco->id)->count();

        // Calcular la convertibilidad
        $convertibilidad = $totalClientes > 0 ? round(($clientesEnEtapaCinco / $totalClientes) * 100, 2) : 0;

        // Generar los gráficos
        $chart = $chartBuilder->build($request, $equipoSeleccionado);
        $conversionChart = $conversionChartBuilder->build($request, $equipoSeleccionado);

        return view('sistema.dashboard.index', [
            'chart' => $chart,
            'conversionChart' => $conversionChart,
            'equipos' => $equipos,
            'ejecutivos' => $ejecutivos,
            'meses' => $meses,
            'equipoSeleccionado' => $equipoSeleccionado,
            'ejecutivoSeleccionado' => $ejecutivoSeleccionado,
            'mesSeleccionado' => $mesSeleccionado,
            'totalClientes' => $totalClientes,
            'clientesEnEtapaCinco' => $clientesEnEtapaCinco,
            'etapaCinco' => $etapaCinco,
            'convertibilidad' => $convertibilidad,
        ]);
    }
}
