<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\TransactionRequestRecieved;
use Illuminate\Support\Facades\Notification;

class HasRecievedTransactionRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $event->transaction->reseller->notify(new TransactionRequestRecieved($event));
        Notification::send(User::all(), new TransactionRequestRecieved($event));
    }
}
