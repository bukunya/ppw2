<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobVacancy;
    public $user;

    public function __construct($jobVacancy, $user)
    {
        $this->jobVacancy = $jobVacancy;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lamaran Baru untuk ' . $this->jobVacancy->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job_applied',
            with: [
                'job' => $this->jobVacancy,
                'user' => $this->user,
            ],
        );
    }
}
