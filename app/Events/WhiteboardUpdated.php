<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhiteboardUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $data;

    public $sessionId;

    public function __construct($data, $sessionId)
    {
        $this->data = $data;
        $this->sessionId = $sessionId;
    }

    public function broadcastOn()
    {
        return new Channel('whiteboard.'.$this->sessionId);
    }

    public function broadcastAs()
    {
        return 'whiteboard-updated';
    }
}
