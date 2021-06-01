<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Tender;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class TenderContractorFinished extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Tender
     */
    private $tender;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Tender $tender
     */
    public function __construct(Tender $tender)
    {
        $this->tender = $tender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail',FcmChannel::class];
    }
    public  function  toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(["message" => json_encode($this->toArray($notifiable))])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create());
    }
    public function toArray($notifiable)
    {
        return [
            'tender' => $this->tender,
            'contractorName' => $this->tender->contractor->name
        ];
    }

    public function toMail($notifiable)
    {
        $url = route('site.tenders.category', $this->tender->slug);
        return (new MailMessage)
            ->subject('Исполнитель завершил ваше задание. Проверьте')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
            ->line('Исполнитель ' . $this->tender->contractor->name . ' завершил ваше задание. Проверьте пожалуйста его работу. Если все хорошо - вы можете отметить задание выполненным')
            ->action('Перейти к заданию', $url);
    }
}
