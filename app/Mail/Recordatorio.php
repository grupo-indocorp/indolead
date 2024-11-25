<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Recordatorio extends Mailable
{
    use Queueable, SerializesModels;

    public $notificacion;

    /**
     * Create a new message instance.
     */
    public function __construct($notificacion)
    {
        $this->notificacion = $notificacion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $recordatorio = $this->notificacion->asunto;

        return new Envelope(
            subject: $recordatorio,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $notify = $this->notificacion;
        if ($notify->notificaciontipo_id == 1) { // general
            $titulo = "Le recordamos que tiene un recordatorio programado, $notify->fecha - $notify->hora";
        } elseif ($notify->notificaciontipo_id == 2) { // cita
            $titulo = "Le recordamos que tiene una cita programada, $notify->fecha - $notify->hora";
        } elseif ($notify->notificaciontipo_id == 3) { // llamada
            $titulo = "Le recordamos que tiene una llamada programada, $notify->fecha - $notify->hora";
        } else {
            $titulo = '';
        }

        return new Content(
            markdown: 'emails.recordatorio',
            with: [
                'titulo' => $titulo,
                'mensaje' => $notify->mensaje,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
