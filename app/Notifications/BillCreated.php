<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BillCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $billCreatedModel;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($billCreated)
    {
        $this->billCreatedModel = $billCreated;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Olá')
                    ->line('Uma conta de internet foi lançada!')
                    ->line('Data de vencimento: ' . $this->billCreatedModel->expire_date)
                    ->line('Valor: R$' . $this->billCreatedModel->price);
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
            //
        ];
    }
}
