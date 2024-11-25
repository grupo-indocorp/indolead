<?php

namespace App\Jobs;

use App\Mail\Notificacion as MailNotificacion;
use App\Models\Notificacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificacionAlerta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificacion;

    /**
     * Create a new job instance.
     */
    public function __construct(Notificacion $notificacion)
    {
        $this->notificacion = $notificacion;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->notificacion->user->email)->send(new MailNotificacion);
        $notificacion = Notificacion::find($this->notificacion->id);
        $notificacion->notificacion = true;
        $notificacion->save();
    }
}
