<?php

namespace App\Notifications;

use App\Models\Reseller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionRequestRecieved extends Notification
    // implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected $event) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        $via = ['database'];
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
        $transaction = $this->event->transaction;

        return (new MailMessage)
            ->markdown('emails.transaction_request_recieved', [
                'data' => $transaction->toArray(),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        $transaction = $this->event->transaction;

        return [
            'notification' => 'money-request-recieved',
            'transaction_id' => $transaction->id,
            'reseller_id' => $transaction->reseller->id,
            'amount' => $transaction->amount,
            'method' => $transaction->method,
            'bank_name' => $transaction->bank_name,
            'account_name' => $transaction->account_name,
            'branch' => $transaction->branch,
            'routing_no' => $transaction->routing_no,
            'account_type' => $transaction->account_type,
            'account_number' => $transaction->account_number,
        ];
    }
}
