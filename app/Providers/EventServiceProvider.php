<?php

namespace App\Providers;

use App\Events\NewOrderRecieved;
use App\Events\OrderStatusChanged;
use App\Events\SendingContactEmail;
use App\Events\TransactionCompleted;
use App\Events\TransactionRequestRecieved;
use App\Listeners\HasChangedOrderStatus;
use App\Listeners\HasCompletedTransaction;
use App\Listeners\HasRecievedNewOrder;
use App\Listeners\HasRecievedTransactionRequest;
use App\Listeners\SendContactEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrderRecieved::class => [
            HasRecievedNewOrder::class,
        ],
        OrderStatusChanged::class => [
            HasChangedOrderStatus::class,
        ],
        TransactionRequestRecieved::class => [
            HasRecievedTransactionRequest::class,
        ],
        TransactionCompleted::class => [
            HasCompletedTransaction::class,
        ],
        SendingContactEmail::class => [
            SendContactEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        //
    }
}
