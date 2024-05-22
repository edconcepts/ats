<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\StatusEmail;
use App\Support\Shortcodes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public StatusEmail $email, public Application $application)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->email->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailBody = Shortcodes::replaceShortcodes($this->application, $this->email->body);

        return new Content(
            markdown:'emails.statuses.changed',
            with: [
                'body' => $emailBody,
            ],
        );
    }

}
