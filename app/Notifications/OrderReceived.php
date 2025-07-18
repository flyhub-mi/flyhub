<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReceived extends Notification
{
    use Queueable;

    /**
     * @var \Illuminate\Database\Eloquent\Model|\App\Models\Tenant\Order
     */
    private $order;

    /**
     * Create a new notification instance.
     *
     * @param \Illuminate\Database\Eloquent\Model|\App\Models\Tenant\Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->prefers_sms ? [] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->from('no-reply@flyhub.com.br')
            ->cc([$notifiable->email])
            ->subject('')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'orders',
            'id' => $this->order['id'],
            'channel_name' => $this->order['channel_name'],
            'grand_total' => $this->order['grand_total'],
            'customer_name' => $this->order['customer_name'],
        ];
    }
}
