<?php

namespace App\Charts;

use App\Models\Cliente;
use App\Models\Etapa;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GraficoDeAnillo
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Request $request, $equipoSeleccionado = null): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        // Obtener todos los ejecutivos
        $ejecutivos = User::role('ejecutivo')->get();

        // Filtrar por equipo si se ha seleccionado uno
        $ejecutivo = $request->input('ejecutivo');
        $mes = $request->input('mes');
        $clientesQuery = Cliente::query();

        if ($equipoSeleccionado) {
            $clientesQuery->where('equipo_id', $equipoSeleccionado);
        }

        if ($ejecutivo) {
            $clientesQuery->where('user_id', $ejecutivo);
        }

        if ($mes) {
            $clientesQuery->whereMonth('fecha_gestion', $mes);
        }

        // Contar datos agrupados por etapa para el gráfico
        $clientesPorEtapaCount = $clientesQuery->selectRaw('etapa_id, COUNT(*) as count')
            ->groupBy('etapa_id')
            ->pluck('count', 'etapa_id');

        Log::info('Clientes por Etapa', ['data' => $clientesPorEtapaCount]);

        $etapasData = Etapa::whereIn('id', $clientesPorEtapaCount->keys())->get();
        $etapasNombres = $etapasData->pluck('nombre')->toArray();
        $etapasCounts = $clientesPorEtapaCount->values()->toArray();
        $etapasColores = $etapasData->pluck('color')->toArray();
        $totalClientes = array_sum($etapasCounts);

        $chartLabels = [];
        foreach ($etapasNombres as $index => $nombre) {
            $chartLabels[] = $nombre.' ('.$etapasCounts[$index].')';
        }

        $chart = $this->chart->donutChart()
            ->setTitle('Cantidad de Clientes por Etapa')
            ->setSubtitle('Cantidad de clientes en cada etapa')
            ->addData($etapasCounts)
            ->setLabels($chartLabels)
            ->setColors($etapasColores)
            ->setOptions([
                'dataLabels' => [
                    'enabled' => true,
                    'formatter' => function ($val, $opts) {
                        return round($val).'%';
                    },
                ],
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'labels' => [
                                'show' => true,
                                'name' => [
                                    'show' => true,
                                ],
                                'value' => [
                                    'show' => true,
                                    'formatter' => function ($val, $opts) {
                                        return $opts->w.globals.seriesTotals[$opts->dataPointIndex];
                                    },
                                ],
                                'total' => [
                                    'show' => true,
                                    'label' => 'Total',
                                    'formatter' => function () use ($totalClientes) {
                                        return $totalClientes;
                                    },
                                ],
                            ],
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'theme' => 'dark',
                    'y' => [
                        'formatter' => function ($val, $opts) use ($etapasNombres, $etapasCounts) {
                            $index = $opts->dataPointIndex;
                            $nombre = $etapasNombres[$index];
                            $conteo = $etapasCounts[$index];
                            $percentage = round(($conteo / array_sum($etapasCounts)) * 100, 2);

                            return $conteo.' clientes ('.$percentage.'%)';
                        },
                    ],
                ],
                'legend' => [
                    'show' => true,
                    'position' => 'bottom',
                    'formatter' => function ($seriesName, $opts) use ($etapasCounts) {
                        $index = $opts->dataPointIndex;

                        return $seriesName.': '.$etapasCounts[$index];
                    },
                ],
            ]);

        return $chart;
    }
}
