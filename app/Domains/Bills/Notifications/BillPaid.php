<?php

namespace App\Domains\Bills\Notifications;

use App\Domains\Bills\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BillPaid extends Notification implements ShouldQueue
{
    use Queueable;

    protected $billPaidModel;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Bill $billPaid)
    {
        $this->billPaidModel = $billPaid;
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
                ->subject('Conta paga')
                ->greeting('Olá')
                ->line('Uma conta de internet foi paga!')
                ->line('Conta de vencimento em: ' . $this->billPaidModel->expire_date)
                ->line('Data de pagamento: ' . $this->billPaidModel->paid_at)
                ->line('Valor: R$' . $this->billPaidModel->price);
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
