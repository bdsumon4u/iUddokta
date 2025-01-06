<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewOrderRecieved;
use Illuminate\Support\Facades\Notification;

class HasRecievedNewOrder
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
        Notification::send(User::all(), new NewOrderRecieved($event));
    }
}
