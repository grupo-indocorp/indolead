<?php

namespace App\Charts;

use App\Models\Etapa;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {

        // Obtener las etapas
        $etapas = Etapa::all();

        // Inicializar arrays para los datos y etiquetas de la gráfica
        $data = [];
        $labels = [];

        // Iterar sobre las etapas
        foreach ($etapas as $etapa) {
            // Obtener los clientes que están en esta etapa con su último cambio de etapa
            $clientesEnEtapa = $etapa->clientes()->with('etapas')->get()->filter(function ($cliente) use ($etapa) {
                return $cliente->etapas->last()->id === $etapa->id;
            });

            // Contar la cantidad de clientes en esta etapa
            $totalClientesEtapa = $clientesEnEtapa->count();

            // Solo calcular el porcentaje si hay clientes en esta etapa
            if ($totalClientesEtapa > 0) {
                $porcentajeClientesEtapa = ($clientesEnEtapa->sum('pivot.cantidad')) * 100;
            } else {
                $porcentajeClientesEtapa = 0;
            }

            // Agregar el nombre de la etapa junto con el total de clientes y el porcentaje si hay clientes
            if ($totalClientesEtapa > 0) {
                $labels[] = $etapa->nombre.' - Total: '.$totalClientesEtapa.' ('.number_format($porcentajeClientesEtapa, 2).'%)';
            } else {
                $labels[] = $etapa->nombre.' - Total: '.$totalClientesEtapa;
            }

            $data[] = $totalClientesEtapa;
        }

        // Construir y retornar el gráfico
        return $this->chart->pieChart()
            ->setTitle('CANTIDAD DE CLIENTES POR ETAPA')
            ->setSubtitle('Agregar Filtro Por Mes; Agregar Filtro por EECC.')
            ->addData($data)
            ->setLabels($labels);
    }
}
