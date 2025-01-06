<?php

namespace App\Notifications;

use App\Models\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCompleted extends Notification
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
        $timezone = $this->event->timezone;
        $query = $this->event->transaction->reseller->orders()->whereIn('status', ['DELIVERED', 'FAILED']);
        $orders = $query->where(fn($query) => $query->whereBetween('data->completed_at', $timezone)
            ->orWhereBetween('data->returned_at', $timezone))->get();

        return (new MailMessage)
            ->markdown('emails.transaction_completed', [
                'data' => $this->event->transaction->toArray(),
                'type' => $this->event->type,
                'timezone' => $timezone,
                'orders' => $orders,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        $transaction = $this->event->transaction;
        $type = $this->event->type;

        return [
            'notification' => 'transaction-completed',
            'transaction_id' => $transaction->id,
            'type' => $type,
            'amount' => $transaction->amount,
            'method' => $transaction->method,
            'bank_name' => $transaction->bank_name,
            'account_name' => $transaction->account_name,
            'branch' => $transaction->branch,
            'routing_no' => $transaction->routing_no,
            'account_type' => $transaction->account_type,
            'account_number' => $transaction->account_number,
            'timezone' => $this->event->timezone,
        ];
    }
}
