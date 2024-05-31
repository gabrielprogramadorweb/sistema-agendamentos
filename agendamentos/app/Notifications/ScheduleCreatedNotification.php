<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Schedule;

class ScheduleCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmação de agendamento.')
            ->view('emails.schedule_created', [
                'schedule' => $this->schedule,
                'notifiable' => $notifiable
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'schedule_id' => $this->schedule->id
        ];
    }
}
