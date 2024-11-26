<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderRecieved //implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public $reseller;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $reseller)
    {
        $this->order = $order;
        $this->reseller = $reseller;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-notice-count');
    }

    public function broadcastAs()
    {
        return 'admin.notice.count';
    }

    public function broadcastWith()
    {
        return [
            'notice_count' => 'increment',
        ];
    }
}
