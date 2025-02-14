<?php

namespace App\Exports;

use App\Helpers\Helpers;
use App\Models\Exportcliente;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndotechFunnelExport
{
    protected $filtro;
    protected $user;

    public function __construct($filtro, $user)
    {
        $this->filtro = $filtro;
        $this->user = $user;
    }

    public function query()
    {
        $where = Helpers::filtroExportCliente(json_decode($this->filtro), $this->user);

        // Subconsulta para obtener el último registro por RUC
        $subquery = Exportcliente::query()
            ->selectRaw('MAX(id) as id') // Selecciona el ID máximo (último registro)
            ->where($where)
            ->groupBy('ruc'); // Agrupa por RUC

        // Consulta principal que une la subconsulta con la tabla principal
        return Exportcliente::query()
            ->whereIn('id', $subquery); // Filtra solo los últimos registros por RUC
    }

    public function headings(): array
    {
        return [
            'Equipo',
            'Ejecutivo',
            'Ruc',
            'Razón Social',
            'Ciudad',
            'Nombre Contacto',
            'Celular Contacto',
            'Correo Electrónico Contacto',
            'Estado Wick',
            'Evaluación Dito',
            'Líneas Claro',
            'Líneas Entel',
            'Líneas Bitel',
            'Etapa de Negociación',
            'Fecha Primer Contacto',
            'Fecha Último Contacto',
            'Movil Cantidad',
            'Movil Cargo Fijo.',
            'Fija Cantidad',
            'Fija Cargo Fijo',
            'Avanzada Cantidad',
            'Avanzada Cargo Fijo',
            'Último Comentario',
            '4to Comentario',
            '3er Comentario',
            '2do Comentario',
            '1er Comentario',
            'Tipo de Cliente',
            'Agencia',
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->ejecutivo_equipo,
            $cliente->ejecutivo,
            $cliente->ruc,
            $cliente->razon_social,
            $cliente->ciudad,
            $cliente->contacto,
            $cliente->contacto_celular,
            $cliente->contacto_email,
            $cliente->estado_wick,
            $cliente->estado_dito,
            $cliente->lineas_claro,
            $cliente->lineas_entel,
            $cliente->lineas_bitel,
            $cliente->etapa,
            $cliente->fecha_creacion,
            $cliente->fecha_ultimo_contacto,
            $cliente->producto_categoria_1,
            $cliente->producto_categoria_1_total,
            $cliente->producto_categoria_2,
            $cliente->producto_categoria_2_total,
            $cliente->producto_categoria_3,
            $cliente->producto_categoria_3_total,
            $cliente->comentario_5,
            $cliente->comentario_4,
            $cliente->comentario_3,
            $cliente->comentario_2,
            $cliente->comentario_1,
            $cliente->cliente_tipo,
            $cliente->agencia,
        ];
    }

    public function exportToCsv(): StreamedResponse
    {
        $headers = $this->headings();

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            // Usar la consulta modificada
            $this->query()->chunk(1000, function ($clientes) use ($file) {
                foreach ($clientes as $cliente) {
                    fputcsv($file, $this->map($cliente));
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="IndotechFunnelExport.csv"',
        ]);
    }
}