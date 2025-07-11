<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\{
    Mailable,
    Mailables\Content,
    Mailables\Envelope
};
use Illuminate\Queue\SerializesModels;

class UpdateEmailMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Contains user's name, new and old email (users.name, users.email), and url
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
            subject: __('mail.subject.prefix', ['page' => __('mail.subject.update_email')]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.update-email-mail',
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
