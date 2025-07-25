<?php

namespace App\Exports;

use App\Models\Cliente;
use App\Helpers\Helpers;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndotechFunnelExport
{
    protected $filtro;
    protected $user;

    // Header constante para fácil mantenimiento
    const CSV_HEADERS = [
        'Equipo', 'Ejecutivo', 'Ruc', 'Razón Social', 'Ciudad',
        'Nombre Contacto', 'Celular Contacto', 'Correo Electrónico',
        'Estado Wick', 'Evaluación Dito', 'Líneas Claro', 'Líneas Entel',
        'Líneas Bitel', 'Líneas Movistar', 'Total Líneas',
        'Etapa Negociación', 'Movil Cantidad', 'Movil Cargo Fijo',
        'Fija Cantidad', 'Fija Cargo Fijo', 'Avanzada Cantidad', 'Avanzada Cargo Fijo',
        'Fecha Primer Contacto', 'Fecha Último Contacto', 'Fecha Creación',
        'Último Comentario', '4to Comentario', '3er Comentario', '2do Comentario', '1er Comentario',
        'Tipo Cliente', 'Agencia'
    ];

    public function __construct($filtro, $user)
    {
        $this->filtro = $filtro;
        $this->user = $user;
    }

    public function exportToCsv(): StreamedResponse
    {
        set_time_limit(120); // 2 minutos, ajusta según necesidad
        ini_set('memory_limit', '2048M');

        $filtro = json_decode($this->filtro); // Puede ser string o array
        $where = Helpers::filtroExportCliente($filtro, $this->user);

        // No usamos get() para eficiencia, sino chunk en el callback
        $clientesQuery = Cliente::with([
            'user', 'equipo', 'comentarios', 'ventas.productos',
            'contactos', 'etapa',
            'movistars.estadowick', 'movistars.estadodito',
            'movistars.clientetipo', 'movistars.agencia'
        ])
        ->where($where)
        ->orderByDesc('id');

        $headers = self::CSV_HEADERS;

        $callback = function () use ($clientesQuery, $headers) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $headers);

            $rowCount = 0;

            // Procesa en chunks para mejor manejo de memoria
            $clientesQuery->chunk(500, function ($clientes) use ($file, &$rowCount) {
                foreach ($clientes as $cliente) {
                    fputcsv($file, $this->mapClienteToRow($cliente));
                    $rowCount++;
                }
            });

            // Si no hubo resultados, deja una fila informativa
            if ($rowCount === 0) {
                fputcsv($file, ['No hay datos para los filtros seleccionados']);
            }
            fclose($file);
        };

        // Log para auditoría básica (opcional)
        \Log::info('Exportación CSV ejecutada', [
            'user_id' => $this->user->id ?? null,
            'filtro' => $this->filtro,
            'fecha' => now()->toDateTimeString()
        ]);

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="IndotechFunnelExport.csv"',
        ]);
    }

    /**
     * Transforma el cliente en una fila lista para CSV
     */
    private function mapClienteToRow($cliente): array
    {
        // Obtiene la última venta (o null)
        $ventas = $cliente->ventas ?? collect();
        $venta = $ventas->count() ? $ventas->last() : null;

        // Totales por categoría
        $m_cant = $m_carf = $f_cant = $f_carf = $a_cant = $a_carf = 0;
        if ($venta) {
            foreach ($venta->productos as $item) {
                switch ($item->categoria_id) {
                    case 2: $m_cant += $item->pivot->cantidad ?? 0; $m_carf += $item->pivot->total ?? 0; break;
                    case 3: $f_cant += $item->pivot->cantidad ?? 0; $f_carf += $item->pivot->total ?? 0; break;
                    case 4: $a_cant += $item->pivot->cantidad ?? 0; $a_carf += $item->pivot->total ?? 0; break;
                }
            }
        }

        // Comentarios
        $comentarios = $cliente->comentarios()
            ->where('user_id', $cliente->user_id)
            ->latest()
            ->take(5)
            ->pluck('comentario')
            ->toArray();
        $comentarios = array_pad($comentarios, 5, '');

        // Primer comentario (para fecha creación)
        $primerComentario = $cliente->comentarios()
            ->where('user_id', $cliente->user_id)
            ->orderBy('id')
            ->first();

        // Movistars y contacto
        $movistars = $cliente->movistars ?? collect();
        $movistar = $movistars->count() ? $movistars->last() : null;

        $contactos = $cliente->contactos ?? collect();
        $contacto = $contactos->count() ? $contactos->last() : null;

        // Líneas
        $lineas = [
            'claro' => (int) ($movistar->linea_claro ?? 0),
            'entel' => (int) ($movistar->linea_entel ?? 0),
            'bitel' => (int) ($movistar->linea_bitel ?? 0),
            'movistar' => (int) ($movistar->linea_movistar ?? 0),
        ];
        $totalLineas = array_sum($lineas);

        // Fechas
        $fechaPrimerContacto = $this->formatDate($cliente->fecha_nuevo);
        $fechaUltimoContacto = $this->formatDate($cliente->fecha_gestion);
        $fechaCreacion = $primerComentario && $primerComentario->created_at ? $this->formatDate($primerComentario->created_at) : '';

        return [
            $cliente->equipo->nombre ?? '',
            $cliente->user->name ?? '',
            $cliente->ruc ?? '',
            $cliente->razon_social ?? '',
            $cliente->ciudad ?? '',
            $contacto->nombre ?? '',
            $contacto->celular ?? '',
            $contacto->correo ?? '',
            $movistar->estadowick->nombre ?? '',
            $movistar->estadodito->nombre ?? '',
            $lineas['claro'],
            $lineas['entel'],
            $lineas['bitel'],
            $lineas['movistar'],
            $totalLineas,
            $cliente->etapa->nombre ?? '',
            $m_cant, $m_carf,
            $f_cant, $f_carf,
            $a_cant, $a_carf,
            $fechaPrimerContacto,
            $fechaUltimoContacto,
            $fechaCreacion,
            $comentarios[0],
            $comentarios[1],
            $comentarios[2],
            $comentarios[3],
            $comentarios[4],
            $movistar->clientetipo->nombre ?? '',
            $movistar->agencia->nombre ?? '',
        ];
    }

    /**
     * Formatea una fecha a d/m/Y si existe, si no, devuelve ''
     */
    private function formatDate($fecha): string
    {
        if (empty($fecha)) return '';
        try {
            return date('d/m/Y', strtotime($fecha));
        } catch (\Exception $e) {
            return '';
        }
    }
}
