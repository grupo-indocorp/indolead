<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Evaporacion;
use App\Models\Notificacion;
use App\Models\Notificaciontipo;
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
        $evaporacion = Notificaciontipo::where('nombre', 'evaporación')->first();
        $fechaActual = Carbon::now();
        foreach ($evaporaciones as $value) {
            $user = User::where('identity_document', $value->identificacion_ejecutivo)->first();
            if ($user) {
                if (! is_null($value->fecha_emision3) && $value->estado_facturacion3 === 'Pendiente') {
                    $cliente = Cliente::where('ruc', $value->ruc)->first();
                    $mensaje = "RECORDATORIO DE VENCIMIENTO DE FACTURA\n".
                        "Cliente: $value->ruc - $value->razon_social\n".
                        "Factura N° 3\n".
                        "Fecha de Emisión: $value->fecha_emision3\n".
                        "Fecha de Vencimiento: $value->fecha_vencimiento3\n".
                        "Número: $value->numero_servicio".
                        "Cuenta Financiera: $value->cuenta_financiera\n".
                        "Cargo Fijo: S/ $value->cargo_fijo";

                    // Notificación 2 días antes del vencimiento hasta el dia de vencimiento
                    $fechaLimite = Carbon::parse($value->fecha_vencimiento3)->subDays(2);
                    $fechaVencimiento = Carbon::parse($value->fecha_vencimiento3);
                    if ($fechaActual->greaterThanOrEqualTo($fechaLimite) && $fechaActual->lessThanOrEqualTo($fechaVencimiento)) {
                        $notificacion = new Notificacion;
                        $notificacion->asunto = "EVAPORACION $value->ruc";
                        $notificacion->mensaje = $mensaje;
                        $notificacion->fecha = Carbon::today();
                        $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                        $notificacion->notificacion = false;
                        $notificacion->notificaciontipo_id = $evaporacion->id;
                        $notificacion->user_id = $user->id ?? null;
                        $notificacion->cliente_id = $cliente->id ?? null;
                        $notificacion->save();
                    }
                } elseif (! is_null($value->fecha_emision2) && $value->estado_facturacion2 === 'Pendiente') {
                    $cliente = Cliente::where('ruc', $value->ruc)->first();
                    $mensaje = "RECORDATORIO DE VENCIMIENTO DE FACTURA\n".
                        "Cliente: $value->ruc - $value->razon_social\n".
                        "Factura N° 2\n".
                        "Fecha de Emisión: $value->fecha_emision2\n".
                        "Fecha de Vencimiento: $value->fecha_vencimiento2\n".
                        "Número: $value->numero_servicio".
                        "Cuenta Financiera: $value->cuenta_financiera\n".
                        "Cargo Fijo: S/ $value->cargo_fijo";

                    // Notificación 2 días antes del vencimiento hasta el dia de vencimiento
                    $fechaLimite = Carbon::parse($value->fecha_vencimiento2)->subDays(2);
                    $fechaVencimiento = Carbon::parse($value->fecha_vencimiento2);
                    if ($fechaActual->greaterThanOrEqualTo($fechaLimite) && $fechaActual->lessThanOrEqualTo($fechaVencimiento)) {
                        $notificacion = new Notificacion;
                        $notificacion->asunto = "EVAPORACION $value->ruc";
                        $notificacion->mensaje = $mensaje;
                        $notificacion->fecha = Carbon::today();
                        $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                        $notificacion->notificacion = false;
                        $notificacion->notificaciontipo_id = $evaporacion->id;
                        $notificacion->user_id = $user->id ?? null;
                        $notificacion->cliente_id = $cliente->id ?? null;
                        $notificacion->save();
                    }
                } elseif (! is_null($value->fecha_emision1) && $value->estado_facturacion1 === 'Pendiente') {
                    $cliente = Cliente::where('ruc', $value->ruc)->first();
                    $mensaje = "RECORDATORIO DE VENCIMIENTO DE FACTURA\n".
                        "Cliente: $value->ruc - $value->razon_social\n".
                        "Factura N° 1\n".
                        "Fecha de Emisión: $value->fecha_emision1\n".
                        "Fecha de Vencimiento: $value->fecha_vencimiento1\n".
                        "Número: $value->numero_servicio".
                        "Cuenta Financiera: $value->cuenta_financiera\n".
                        "Cargo Fijo: S/ $value->cargo_fijo";

                    // Notificación 2 días antes del vencimiento hasta el dia de vencimiento
                    $fechaLimite = Carbon::parse($value->fecha_vencimiento1)->subDays(2);
                    $fechaVencimiento = Carbon::parse($value->fecha_vencimiento1);
                    // dump($fechaLimite, $fechaVencimiento);
                    if ($fechaActual->greaterThanOrEqualTo($fechaLimite) && $fechaActual->lessThanOrEqualTo($fechaVencimiento)) {
                        // dump($value->fecha_vencimiento1, $fechaLimite, $fechaActual->greaterThanOrEqualTo($fechaLimite), $fechaActual->lessThanOrEqualTo($fechaVencimiento));
                        $notificacion = new Notificacion;
                        $notificacion->asunto = "FACTURACIÓN DEL CLIENTE - $value->ruc";
                        $notificacion->mensaje = $mensaje;
                        $notificacion->fecha = Carbon::today();
                        $notificacion->hora = Carbon::createFromTime(11, 0, 0);
                        $notificacion->notificacion = false;
                        $notificacion->notificaciontipo_id = $evaporacion->id;
                        $notificacion->user_id = $user->id ?? null;
                        $notificacion->cliente_id = $cliente->id ?? null;
                        $notificacion->save();
                    }
                }
            }
        }
    }
}
