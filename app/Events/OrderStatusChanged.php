<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged //implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public $before;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {
        $this->order = $param['order'];
        $this->before = $param['before'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("reseller-{$this->order->reseller->id}-notice-count");
    }

    public function broadcastAs()
    {
        return 'reseller.notice.count';
    }

    public function broadcastWith()
    {
        return [
            'notice_count' => $this->order->reseller->unreadNotifications->count() + 1,
        ];
    }
}
