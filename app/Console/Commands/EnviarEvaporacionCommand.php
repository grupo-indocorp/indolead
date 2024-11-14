<?php

namespace App\Console\Commands;

use App\Models\Evaporacion;
use App\Models\Notificacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarEvaporacionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-evaporacion-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificaciones de vencimientos diarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $evaporaciones = Evaporacion::all();
        foreach ($evaporaciones as $value) {
            $user = User::where('identity_document', $value->identificacion_ejecutivo)->first();
            if (!is_null($value->fecha_emision3)) {
                if ($value->estado_facturacion3 === 'Pendiente') {
                    $mensaje = "$value->ruc - $value->razon_social, Facturación 3 vence $value->fecha_vencimiento3";
                    $notificacion = new Notificacion;
                    $notificacion->asunto = "EVAPORACION $value->ruc";
                    $notificacion->mensaje = $mensaje;
                    $notificacion->fecha = Carbon::today();
                    $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                    $notificacion->notificacion = false;
                    $notificacion->notificaciontipo_id = 3; // llamada
                    $notificacion->user_id = $user->id;
                    $notificacion->cliente_id = null;
                    $notificacion->save();
                }
            } elseif (!is_null($value->fecha_emision2)) {
                if ($value->estado_facturacion2 === 'Pendiente') {
                    $mensaje = "$value->ruc - $value->razon_social, Facturación 2 vence $value->fecha_vencimiento2";
                    $notificacion = new Notificacion;
                    $notificacion->asunto = "EVAPORACION $value->ruc";
                    $notificacion->mensaje = $mensaje;
                    $notificacion->fecha = Carbon::today();
                    $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                    $notificacion->notificacion = false;
                    $notificacion->notificaciontipo_id = 3; // llamada
                    $notificacion->user_id = $user->id;
                    $notificacion->cliente_id = null;
                    $notificacion->save();
                }
            } elseif (!is_null($value->fecha_emision1)) {
                if ($value->estado_facturacion1 === 'Pendiente') {
                    $mensaje = "$value->ruc - $value->razon_social, Facturación 1 vence $value->fecha_vencimiento1";
                    $notificacion = new Notificacion;
                    $notificacion->asunto = "EVAPORACION $value->ruc";
                    $notificacion->mensaje = $mensaje;
                    $notificacion->fecha = Carbon::today();
                    $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                    $notificacion->notificacion = false;
                    $notificacion->notificaciontipo_id = 3; // llamada
                    $notificacion->user_id = $user->id;
                    $notificacion->cliente_id = null;
                    $notificacion->save();
                }
            }
        }
    }
}
