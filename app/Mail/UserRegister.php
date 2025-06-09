<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{
    Content,
    Envelope,
};
use Illuminate\Queue\SerializesModels;

class UserRegister extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Contains user's name and email (users.name, users.email)
     *
     * @var array
     */
    protected array $data;

    /**
     * Create a new message instance.
     *
     * @param array<mixed, string> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Signup',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user-register',
            with: $this->data,
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
