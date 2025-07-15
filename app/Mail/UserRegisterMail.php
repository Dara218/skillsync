<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{
    Content,
    Envelope,
};
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
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
     * The user login code (user_login_code.code)
     *
     * @var array
     */
    protected string $code;

    /**
     * Create a new message instance.
     *
     * @param array<mixed, string> $data
     * @param string $code (user_login_code.code)
     */
    public function __construct(array $data, string $code)
    {
        $this->data = $data;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.subject.prefix', ['page' => __('mail.subject.email_verification')]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user-register',
            with: array_merge($this->data, ['code' => $this->code]),
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
