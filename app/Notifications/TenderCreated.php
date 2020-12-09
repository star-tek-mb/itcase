<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TenderCreated extends Notification
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
    public function __construct(\App\Models\Tender $tender)
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
        return $notifiable->email ? ['database', 'mail'] : ['database'];
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
            'tender' => $this->tender,
            'customerName' => $this->tender->owner->getCommonTitle()
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
        $url = route('admin.tenders.show', $this->tender->id);

        return (new MailMessage)
            ->subject('На сайте создан новый конкурс!')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
            ->line('Заказчик ' . $this->tender->owner->getCommonTitle() . ' создал новый конкурс ' . $this->tender->title)
            ->action('Перейти к конкурсу', $url);
    }
}
