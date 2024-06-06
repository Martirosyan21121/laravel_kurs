<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyTestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private $name, private $email, private $createdAt)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'My Test Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.register',
            with: ['name' => $this->name,
                'email' => $this->email,
                'createdAt' => $this->createdAt],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
