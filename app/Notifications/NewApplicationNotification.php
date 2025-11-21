<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;

    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Lamaran Baru Diterima')
            ->line('Ada lamaran baru untuk pekerjaan: ' . $this->application->job->title)
            ->line('Pelamar: ' . $this->application->user->name)
            ->action('Download CV', asset('storage/' . $this->application->cv))
            ->action('Lihat Lamaran', url('/applications'));
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'user_name' => $this->application->user->name,
            'message' => 'Lamaran baru diterima untuk pekerjaan ' . $this->application->job->title,
        ];
    }
}
