<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class TenderPublished extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Tender
     */
    private $tender;

    /**
     * @var boolean
     */
    private $published;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Tender $tender
     * @param bool $published
     */
    public function __construct(\App\Models\Tender $tender, bool $published)
    {
        $this->tender = $tender;
        $this->published = $published;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->email ? ['database', 'mail',FcmChannel::class] : ['database',FcmChannel::class];
    }
    public  function  toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(["message" => json_encode($this->toArray($notifiable))])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create());
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'published' => $this->published,
            'tender' => $this->tender
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  \App\Models\User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('site.tenders.category', $this->tender->slug);

        return (new MailMessage)
            ->subject('Ваш конкурс ' . $this->tender->title . 'опубликован!')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
            ->line('Ваш конкурс ' . $this->tender->title . ' прошёл модерацию и опубликован на площадке!')
            ->action('Перейти к конкурсу', $url);
    }
}
