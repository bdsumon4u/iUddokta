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
     * @return void
     */
    public function handle($event)
    {
        Notification::send(User::all(), new NewOrderRecieved($event));
    }
}
