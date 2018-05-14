<?php

namespace App\Events;

use App\Chat;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $chat)
    {
        $this->message = $message;

        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        Log::info('nou missatge');
        return new PresenceChannel("Chat.".$this->chat->id);
//        return new PrivateChannel('channel-name');
    }
}
