<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogService
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $original;
    public $model;
    public $tipe;
    public $table;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($original, $model, $tipe, $table, $id)
    {
        $this->original = $original;
        $this->model = $model;
        $this->tipe = $tipe;
        $this->table = $table;
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
