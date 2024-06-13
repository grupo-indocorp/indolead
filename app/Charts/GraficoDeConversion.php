<?php

namespace App\Charts;

use App\Models\Cliente;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class GraficoDeConversion
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Request $request, $equipoSeleccionado = null): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $ejecutivo = $request->input('ejecutivo');
        $clientesQuery = Cliente::query();

        if ($equipoSeleccionado) {
            $clientesQuery->where('equipo_id', $equipoSeleccionado);
        }

        if ($ejecutivo) {
            $clientesQuery->where('user_id', $ejecutivo);
        }

        $currentMonth = Carbon::now();
        $meses = [];

        for ($i = 4; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $meses[$month->month] = $month->formatLocalized('%B'); // Nombre del mes en español
        }

        $conversionRates = [];
        foreach ($meses as $mesNumero => $mesNombre) {
            $totalClientesMes = (clone $clientesQuery)->whereMonth('fecha_gestion', $mesNumero)->count();
            $clientesEnEtapaCincoMes = (clone $clientesQuery)->whereMonth('fecha_gestion', $mesNumero)->where('etapa_id', 5)->count();
            $conversionRate = $totalClientesMes > 0 ? round(($clientesEnEtapaCincoMes / $totalClientesMes) * 100, 2) : 0;
            $conversionRates[] = $conversionRate;
        }

        $chart = $this->chart->barChart()
            ->setTitle('Tasa de Conversión Mensual')
            ->setSubtitle('Porcentaje de conversión por mes')
            ->addData('Tasa de Conversión', $conversionRates)
            ->setXAxis(array_values($meses));

        return $chart;
    }
}
