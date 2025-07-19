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

        return Exportcliente::query()
            ->whereIn('id', function ($subquery) use ($where) {
                $subquery->selectRaw('MAX(id)')
                    ->from('exportclientes')
                    ->where($where)
                    ->groupBy('ruc');
            })
            ->orderBy('ruc');
    }

    public function headings(): array
    {
        return [
            'Equipo', 'Ejecutivo', 'Ruc', 'Razón Social', 'Dirección',
            'Contacto', 'Celular','Correo','Estado Wick','Estado Dito',
            'Movistar',
            'Claro',
            'Entel',
            'Bitel',
            'Total Líneas',
            'Etapa','Fecha Creacion',
            'F Último Contacto', 'Movil Cant',
            'Movil Cargo Fijo',
            'Fija Cant',
            'Fija Cargo Fijo', 'Avanzada Cantidad', 'Avanzada Cargo Fijo',
            'Último Comentario', '4to Comentario','3er Comentario','2do Comentario',
            '1er Comentario', 'Tipo de Cliente','Agencia',
        ];
    }

    public function map($cliente): array
    {
        $totalLineas = array_sum([
            $cliente->lineas_movistar,
            $cliente->lineas_claro,
            $cliente->lineas_entel,
            $cliente->lineas_bitel,
        ]);
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
            $cliente->lineas_movistar,
            $cliente->lineas_claro,
            $cliente->lineas_entel,
            $cliente->lineas_bitel,
            $totalLineas,
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
        set_time_limit(300); // 5 minutos

        $headers = $this->headings();

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $headers);

            $this->query()->chunk(5000, function ($clientes) use ($file) {
                foreach ($clientes as $cliente) {
                    fputcsv($file, $this->map($cliente));
                }
                gc_collect_cycles();
            });

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="IndotechFunnelExport.csv"',
        ]);
    }
}