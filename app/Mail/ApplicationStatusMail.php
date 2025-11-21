<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;

    public function __construct($application, $status)
    {
        $this->application = $application;
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Lamaran Anda: ' . $this->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application_status',
            with: [
                'application' => $this->application,
                'status' => $this->status,
            ],
        );
    }
}