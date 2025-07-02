<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Activity;

class DeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $activity;
    public $reminderType;

    /**
     * Create a new message instance.
     */
    public function __construct(Activity $activity, string $reminderType)
    {
        $this->activity = $activity;
        $this->reminderType = $reminderType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->reminderType === '30_minutes' 
            ? 'Urgent: Task deadline in 30 minutes!' 
            : 'Reminder: Task deadline approaching in 3 days';

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
            view: 'emails.deadline-reminder',
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
