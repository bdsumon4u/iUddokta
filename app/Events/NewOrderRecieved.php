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

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $order, public $reseller) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): \Illuminate\Broadcasting\Channel
    {
        return new Channel('admin-notice-count');
    }

    public function broadcastAs(): string
    {
        return 'admin.notice.count';
    }

    public function broadcastWith(): array
    {
        return [
            'notice_count' => 'increment',
        ];
    }
}
