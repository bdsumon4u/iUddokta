<?php

namespace App\Listeners;

use App\Notifications\OrderStatusChanged;

class HasChangedOrderStatus
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
        $event->order->reseller->notify(new OrderStatusChanged($event));
    }
}
