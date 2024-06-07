<?php

namespace App\Exports;

use App\Helpers\Helpers;
use App\Models\Exportcliente;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IndotechFunnelExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

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
        return Exportcliente::query()->where($where);
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
}
