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
     * @return void
     */
    public function handle($event)
    {
        $event->transaction->reseller->notify(new TransactionRequestRecieved($event));
        Notification::send(User::all(), new TransactionRequestRecieved($event));
    }
}
