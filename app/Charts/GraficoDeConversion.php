<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Database\Eloquent\Builder;

class GraficoDeConversion
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Builder $clientesQuery): \ArielMejiaDev\LarapexCharts\RadialChart
    {
        // Calcular métricas de conversión
        $totalClientes = $clientesQuery->count();
        $clientesConvertidos = $clientesQuery->where('etapa_id', 5)->count();
        $tasaConversion = $totalClientes > 0 ? round(($clientesConvertidos / $totalClientes) * 100, 2) : 0;

        return $this->chart->radialChart()
            ->setTitle('Tasa de Conversión')
            ->setSubtitle('Porcentaje de clientes en etapa final')
            ->addData([$tasaConversion])
            ->setLabels(['Conversión'])
            ->setColors(['#00E396'])
            ->setOptions([
                'plotOptions' => [
                    'radialBar' => [
                        'startAngle' => -90,
                        'endAngle' => 90,
                        'hollow' => [
                            'size' => '60%',
                        ],
                        'dataLabels' => [
                            'name' => [
                                'show' => true,
                                'fontSize' => '16px',
                                'offsetY' => 20,
                            ],
                            'value' => [
                                'show' => true,
                                'fontSize' => '24px',
                                'formatter' => 'function(val) { return val + "%" }',
                            ],
                        ],
                    ],
                ],
                'tooltip' => [
                    'y' => [
                        'formatter' => 'function(value) { return value + "%" }',
                    ],
                ],
                'legend' => [
                    'show' => true,
                    'position' => 'bottom',
                ],
            ]);
    }
}
