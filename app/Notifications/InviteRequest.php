<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteRequest extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\TenderRequest
     */
    private $request;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\TenderRequest $request
     */
    public function __construct(\App\Models\TenderRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  \App\Models\User  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->email ? ['database', 'mail'] : ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  \App\Models\User  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tenderName' => $this->request->tender->title,
            'contractorName' => $this->request->user->getCommonTitle(),
            'customerName' => $this->request->tender->owner->getCommonTitle(),
            'tenderId' => $this->request->tender_id,
            'tenderSlug' => $this->request->tender->slug
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
        $url = route('site.tenders.category', $this->request->tender->slug);

        return (new MailMessage)
            ->subject('Вас приглашают участвовать в конкурсе!')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
            ->line('Заказчик ' . $this->request->tender->owner->getCommonTitle() . ' приглашает вас принять участие в конкурсе ' . $this->request->tender->title . ' и добавил вас в список участников.')
            ->action('Перейти к конкурсу', $url);
    }
}
