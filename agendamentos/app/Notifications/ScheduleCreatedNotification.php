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
        \Log::info("Sending email to: {$notifiable->email}");
        return (new MailMessage)
            ->subject('Confirmation of Your Schedule')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('Your schedule for ' . $this->schedule->chosen_date->format('M d, Y H:i') . ' has been successfully created.')
            ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [
            'schedule_id' => $this->schedule->id
        ];
    }
}
