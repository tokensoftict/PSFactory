<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class MaterialApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Collection $materials;
    public bool $add;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $materials, $add = false)
    {
        $this->materials = $materials;
        $this->add = $add;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
