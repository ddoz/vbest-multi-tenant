<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\IdentitasVendor;

class LogIdentitasService
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $identitas;
    public $tipe;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($identitas, $tipe, $id)
    {
        $this->identitas = $identitas;
        $this->tipe = $tipe;
        $this->id = $id;
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
