<?php

namespace App\Mail;

use App\Models\User;
use App\Models\RegistroAccion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReciclajeConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public RegistroAccion $registro
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '♻️ ¡Reciclaje registrado! +' . $this->registro->accion->puntos_otorgados . ' puntos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reciclaje.index',
        );
    }
}
