<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class RequestAction extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \App\Models\TenderRequest
     */
    private $request;

    /**
     * @var \App\Models\Tender|null
     */
    private $tender;

    /**
     * Create a new notification instance.
     *
     * @param string $type
     * @param \App\Models\TenderRequest $request
     * @param \App\Models\Tender|null $tender
     */
    public function __construct(string $type, \App\Models\TenderRequest $request, \App\Models\Tender $tender = null)
    {
        $this->type = $type;
        $this->request = $request;
        $this->tender = $tender;
    }
    public  function  toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(["message" => json_encode($this->toArray($notifiable))])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create());
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'tenderName' => $this->request->tender->title,
            'customerName' => $this->request->tender->owner->getCommonTitle(),
            'tenderId' => $this->request->tender_id,
            'tenderSlug' => $this->request->tender->slug,
            'customerSlug' => $this->request->tender->owner->slug,
            'customerId' => $this->request->tender->owner->id,
            'contractorSlug' => $this->request->user->slug,
            'contractorId' => $this->request->user->id,
            'contractorName' => $this->request->user->getCommonTitle()
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
        $tenderUrl = route('site.tenders.category', $this->request->tender->slug);

        if ($notifiable->hasRole('admin') && $this->type === 'accepted') {
            return (new MailMessage)
                ->subject('Победитель в конкурсе!')
                ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
                ->line('Заказчик ' . $this->request->tender->owner->getCommonTitle() . ' выбрал исполнителя ' . $this->request->user->getCommonTitle() . 'в качестве победителя в конкурсе ' . $this->request->tender->title)
                ->action('Перейти к конкурсу', route('admin.tenders.show', $this->request->tender_id));
        }
        if ($this->type === 'accepted_by_contractor') {
            return (new MailMessage)
                ->subject('Исполнитель принял вашу заявку!')
                ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
                ->line('Исполнитель ' . $this->request->user->getCommonTitle() . 'принял задание ' . $this->request->tender->title)
                ->action('Перейти к конкурсу', route('admin.tenders.show', $this->request->tender_id));
        }
        if ($this->type === 'rejected_by_contractor') {
            return (new MailMessage)
                ->subject('Исполнитель отклонил вашу заявку!')
                ->greeting('Здравствуйте, '. $notifiable->getCommonTitle())
                ->line('Исполнитель ' . $this->request->user->getCommonTitle() . 'отклонил задание ' . $this->request->tender->title)
                ->action('Перейти к конкурсу', route('admin.tenders.show', $this->request->tender_id));
        }
        return (new MailMessage)
            ->subject($this->type === 'rejected' ? 'Ваша заявка отклонена!' : 'Вы выиграли!')
            ->greeting('Здравствуйте, '. $notifiable->getCommonTitle() . '. Не отчаивайтесь, у вас есть возможность получить другой заказ!')
            ->line('Заказчик ' . ($this->type === 'rejected' ? $this->tender->owner->getCommonTitle() : $this->request->tender->owner->getCommonTitle()) . ($this->type === 'rejected' ? ' отклонил вашу заявку на участие в конкурсе ' : ' выбрал Вас в качестве исполнителя на конкурс ') . $this->request->tender->title)
            ->action('Перейти к конкурсу', $tenderUrl);
    }
}
