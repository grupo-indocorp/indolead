<?php

namespace App\Exports;

use App\Helpers\Helpers;
use App\Models\Exportcliente;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SecodiFunnelExport implements FromQuery, WithHeadings, WithMapping
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
            'Ejecutivo',
            'Razón Social',
            'Ruc',
            'Departamento',
            'Fecha de Primer Contacto',
            'Nombre de Contacto',
            'Se Libera',
            'Email',
            'Teléfono',
            'Producto',
            'Tipo',
            'Q Lineas',
            'Ingresos',
            'Avance',
            'Status',
            'Probabilidad de Cierre',
            'Fecha Ultimo Contacto',
            'Observaciones',
            'Dirección de Instalación',
            'Próxima LLamada',
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->ejecutivo,
            $cliente->razon_social,
            $cliente->ruc,
            $cliente->ciudad,
            $cliente->fecha_creacion,
            $cliente->contacto,
            $cliente->fecha_blindaje,
            $cliente->contacto_email,
            $cliente->contacto_celular,
            $cliente->producto_categoria,
            $cliente->producto,
            $cliente->producto_total_cantidad,
            $cliente->producto_total_total,
            $cliente->etapa_avance,
            $cliente->etapa,
            $cliente->etapa_probabilidad,
            $cliente->fecha_ultimo_contacto,
            $cliente->comentario_5,
            $cliente->ciudad,
            $cliente->fecha_proximo_contacto,
        ];
    }
}
