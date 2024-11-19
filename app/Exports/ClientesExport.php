<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientesExport implements FromView
{
    public function view(): View
    {
        $filtro = json_decode(request('filtro'));
        $where = [];
        if (isset($filtro->filtro_ruc)) {
            $where[] = ['ruc', 'LIKE', $filtro->filtro_ruc.'%'];
        }
        if ($filtro->filtro_etapa_id != 0) {
            $where[] = ['etapa_id', $filtro->filtro_etapa_id];
        }
        if (auth()->user()->hasRole('ejecutivo')) {
            $where[] = ['user_id', auth()->user()->id];
        } else {
            if ($filtro->filtro_user_id != 0) {
                $where[] = ['user_id', $filtro->filtro_user_id];
            }
        }
        if (auth()->user()->hasRole('supervisor')) {
            $where[] = ['equipo_id', auth()->user()->equipo->id];
        } else {
            if ($filtro->filtro_equipo_id != 0) {
                $where[] = ['equipo_id', $filtro->filtro_equipo_id];
            }
        }
        if (auth()->user()->hasRole('gerente comercial') || auth()->user()->hasRole('supervisor') || auth()->user()->hasRole('ejecutivo')) {
            $where[] = ['sede_id', auth()->user()->sede_id];
        } else { // administrador, sistema
            if ($filtro->filtro_sede_id != 0) {
                $where[] = ['sede_id', $filtro->filtro_sede_id];
            }
        }
        if (isset($filtro->filtro_fecha_desde)) {
            $where[] = ['fecha_gestion', '>=', $filtro->filtro_fecha_desde.' 00:00:00'];
        }
        if (isset($filtro->filtro_fecha_hasta)) {
            $where[] = ['fecha_gestion', '<=', $filtro->filtro_fecha_hasta.' 23:59:59'];
        }

        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 120);
        // $fecha_filtro = request('fecha');
        /*$clientes = Cliente::with([
                'user', 'user.equipos', 'contactos',
                'movistars', 'movistars.estadowick', 'movistars.estadodito',
                'etapas', 'comentarios'
            ])
            ->orderByDesc('id')
            ->get();*/
        $clientes = Cliente::with(['user', 'equipo', 'sede', 'etapa', 'comentarios', 'ventas', 'contactos', 'movistars'])
            ->where($where)
            ->orderByDesc('id')
            ->get();

        return view('exports.clientes', compact('clientes'));
    }
}
