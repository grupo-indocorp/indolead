<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Comentario;
use App\Models\Etapa;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferirClientesInactivos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transferir-clientes-inactivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfiere clientes inactivos (más de 90 días sin gestión) a otro ejecutivo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ejecutivo = User::with('equipos')->select('id', 'sede_id')->find(330);
        $equipo = $ejecutivo->equipos->last();
        Cliente::select(
                'id',
                'ruc',
                'fecha_gestion',
                'etapa_id',
                DB::raw('DATEDIFF(CURDATE(), DATE(fecha_gestion)) as dias')
            )
            ->whereRaw('DATEDIFF(CURDATE(), DATE(fecha_gestion)) >= 90')
            ->orderBy('id')
            ->limit(500)
            ->get()
            ->map(function ($cliente) use ($ejecutivo, $equipo) {
                $cliente->user_id = $ejecutivo->id;
                $cliente->fecha_gestion = now();
                $cliente->fecha_nuevo = now();
                $cliente->etiqueta_id = 2; // asignado
                $cliente->sede_id = $ejecutivo->sede_id;
                $cliente->equipo_id = $equipo->id;
                $cliente->save();
                $cliente->usersHistorial()->attach($ejecutivo->id);
                $cliente->etapas()->attach($cliente->etapa_id);

                $etapa = Etapa::find($cliente->etapa_id);
                $comentario = new Comentario();
                $comentario->comentario = 'Cliente asignado a Base de Clientes por superar mas de los 90 días sin gestión';
                $comentario->detalle = 'Cambio de etapa a '.$etapa->nombre;
                $comentario->cliente_id = $cliente->id;
                $comentario->user_id = $ejecutivo->id;
                $comentario->etiqueta_id = 2; // asignado;
                $comentario->save();
            });
    }
}
