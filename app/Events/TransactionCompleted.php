<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCompleted //implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    public $type;

    public $timezone;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($transaction, $type, $timezone)
    {
        $this->transaction = $transaction;
        $this->type = $type;
        $this->timezone = $timezone;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("reseller-{$this->transaction->reseller->id}-notice-count");
    }

    public function broadcastAs()
    {
        return 'reseller.notice.count';
    }

    public function broadcastWith()
    {
        return [
            'notice_count' => $this->transaction->reseller->unreadNotifications->count() + 1,
        ];
    }
}
