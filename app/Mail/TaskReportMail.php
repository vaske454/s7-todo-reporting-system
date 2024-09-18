<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class TaskReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $pdfPath;
    public string $chartPath;

    /**
     * Create a new message instance.
     * @param $user
     * @param $pdfPath
     * @param $chartPath
     */
    public function __construct($user, $pdfPath, $chartPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
        $this->chartPath = $chartPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Task Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)
                ->as('report.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
