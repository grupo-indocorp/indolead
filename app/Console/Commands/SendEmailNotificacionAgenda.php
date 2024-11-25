<?php

namespace App\Console\Commands;

use App\Mail\Recordatorio;
use App\Models\Notificacion;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificacionAgenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-notificacion-agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviando correo con el recordatorio de su notificación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fecha = new DateTime;
        $notificaciones = Notificacion::where('fecha', '<=', $fecha->format('Y-m-d'))->where('notificacion', false)->get();
        foreach ($notificaciones as $notificacion) {
            $hora_programada = new DateTime($notificacion->hora);
            if ($notificacion->notificaciontipo_id == 1) { // general
                $hora = $hora_programada->modify('-5 minutes');
            } elseif ($notificacion->notificaciontipo_id == 2) { // cita
                $hora = $hora_programada->modify('-1 hour');
            } elseif ($notificacion->notificaciontipo_id == 3) { // llamada
                $hora = $hora_programada->modify('-5 minutes');
            }
            if (date('H:i:s') >= $hora->format('H:i:s')) {
                Mail::to($notificacion->user->email)->send(new Recordatorio($notificacion));
                $notificacion = Notificacion::find($notificacion->id);
                $notificacion->notificacion = true;
                $notificacion->save();
            }
        }
    }
}
