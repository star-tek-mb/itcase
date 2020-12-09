<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewRequest extends Notification
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
            'tenderName' => $this->request->tender->title,
            'contractorName' => $this->request->user->getCommonTitle(),
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
        $url = route('site.account.tenders.candidates', $this->request->tender->slug);

        return (new MailMessage)
            ->subject('На участие в конкурсе ' . $this->request->tender->title . ' поступила новая заявка!')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
            ->line('Новая заявка на участие в конкурсе ' . $this->request->tender->title . ' от исполнителя ' . $this->request->user->getCommonTitle())
            ->action('Перейти к списку участников', $url);
    }
}
