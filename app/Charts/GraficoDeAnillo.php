<?php

namespace App\Charts;

use App\Models\Etapa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Database\Eloquent\Builder;

class GraficoDeAnillo
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Builder $clientesQuery): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        // Obtener todas las etapas en orden de la base de datos
        $etapas = Etapa::orderBy('id')->get();

        // Preparar arrays para los datos del gráfico
        $etapasNombres = [];
        $etapasCounts = [];
        $etapasColores = [];

        foreach ($etapas as $etapa) {
            // Contar clientes para cada etapa
            $count = $clientesQuery->clone()
                ->where('etapa_id', $etapa->id)
                ->count();

            if ($count > 0) {
                $etapasNombres[] = $etapa->nombre;
                $etapasCounts[] = $count;
                $etapasColores[] = $etapa->color;
            }
        }

        $totalClientes = array_sum($etapasCounts);

        // Crear etiquetas con porcentajes
        $chartLabels = [];
        foreach ($etapasNombres as $index => $nombre) {
            $porcentaje = $totalClientes > 0
                ? round(($etapasCounts[$index] / $totalClientes) * 100, 2)
                : 0;

            $chartLabels[] = "$nombre ({$etapasCounts[$index]} - $porcentaje%)";
        }

        return $this->chart->donutChart()
            ->setTitle('Distribución de Clientes por Etapas')
            ->setSubtitle('Total de clientes: '.$totalClientes)
            ->addData($etapasCounts)
            ->setLabels($chartLabels)
            ->setColors($etapasColores)
            ->setOptions([
                'dataLabels' => [
                    'enabled' => true,
                    'formatter' => 'function(val) { return Math.round(val) + "%" }',
                ],
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'labels' => [
                                'show' => true,
                                'total' => [
                                    'show' => true,
                                    'label' => 'Total',
                                    'formatter' => 'function() { return '.$totalClientes.' }',
                                ],
                            ],
                        ],
                    ],
                ],
                'tooltip' => [
                    'y' => [
                        'formatter' => 'function(val, opts) { 
                            return val + " clientes (" + Math.round(opts.percent) + "%)"
                        }',
                    ],
                ],
                'legend' => [
                    'position' => 'bottom',
                    'formatter' => 'function(seriesName, opts) { 
                        return seriesName + ": " + opts.w.globals.series[opts.seriesIndex] 
                    }',
                ],
            ]);
    }
}
