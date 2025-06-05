<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public function __construct(Message $message)
    {
        $message->load('sender');
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('public');
    }

    public function broadcastAs()
    {
        return 'chat';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
