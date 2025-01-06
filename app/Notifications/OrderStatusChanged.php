<?php

namespace App\Notifications;

use App\Models\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
    // implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected $event)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        $via = [];
        if (
            $notifiable instanceof Reseller
            && filter_var($notifiable->email, FILTER_VALIDATE_EMAIL)
        ) {
            array_push($via, 'mail');
        }

        return $via;
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
            ->line('Dear valuable reseller,')
            ->line('One of your order status has changed')
            ->line('from "'.ucwords($this->event->before).'" to "'.ucwords($this->event->order->status).'"')
            ->action("Order #{$this->event->order->id}", route('reseller.order.show', $this->event->order->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'notification' => 'order-status-changed',
            'order_id' => $this->event->order->id,
            'before' => $this->event->before,
            'after' => $this->event->order->status,
        ];
    }
}
