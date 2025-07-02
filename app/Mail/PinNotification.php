<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PinNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pin;
    public $isNewAccount;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $pin, bool $isNewAccount = false)
    {
        $this->user = $user;
        $this->pin = $pin;
        $this->isNewAccount = $isNewAccount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isNewAccount 
            ? 'Welcome to TodoAja - Your Account PIN' 
            : 'Your TodoAja Login PIN';
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pin-notification',
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
