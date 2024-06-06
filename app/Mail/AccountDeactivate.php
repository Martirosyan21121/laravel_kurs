<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeactivate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private $email)
    {
        //
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Deactivate',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.accountDeactivate',
            with: ['email' => $this->email],
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
