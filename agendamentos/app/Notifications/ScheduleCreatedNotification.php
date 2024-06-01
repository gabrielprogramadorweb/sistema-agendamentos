<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class ScheduleCreatedNotification extends Notification
{
    use Queueable;

    protected $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
        Log::info('ScheduleCreatedNotification instanciada.', ['schedule' => $schedule]);
    }

    public function via($notifiable)
    {
        Log::info('Método via chamado.', ['notifiable' => $notifiable]);
        return ['database'];
    }

    public function toArray($notifiable)
    {
        Log::info('Método toArray chamado.', ['notifiable' => $notifiable]);
        return [
            'unit_id' => $this->schedule->unit_id,
            'service_id' => $this->schedule->service_id,
            'month' => $this->schedule->month,
            'day' => $this->schedule->day,
            'hour' => $this->schedule->hour,
            'chosen_date' => $this->schedule->chosen_date->toDateTimeString(),
            'user_name' => $this->schedule->user->name,
            'procedure_name' => $this->schedule->service->name,
        ];
    }
}

//    public function __construct(Schedule $schedule)
//    {
//        $this->schedule = $schedule;
//    }

//    public function via($notifiable)
//    {
//        return ['mail'];
//    }

//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//            ->subject('Confirmação de agendamento.')
//            ->view('emails.schedule_created', [
//                'schedule' => $this->schedule,
//                'notifiable' => $notifiable
//            ]);
//    }
//
//    public function toArray($notifiable)
//    {
//        return [
//            'schedule_id' => $this->schedule->id
//        ];
//    }

