<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Canje;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CanjeConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Canje $canje
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎁 ¡Canje exitoso! — ' . $this->canje->premio->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.canje.index',
        );
    }
}
