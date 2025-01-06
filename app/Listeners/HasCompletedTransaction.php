<?php

namespace App\Listeners;

use App\Notifications\TransactionCompleted;

class HasCompletedTransaction
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
    public function handle($event): void
    {
        $event->transaction->reseller->notify(new TransactionCompleted($event));
    }
}
