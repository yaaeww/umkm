<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $sender;
    public $receiver;

    /**
     * Buat event baru
     */
    public function __construct(Chat $chat, ?User $sender = null, ?User $receiver = null)
    {
        $this->chat = $chat;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    /**
     * Tentukan channel broadcast
     */
    public function broadcastOn()
    {
        if ($this->receiver) {
            return new PrivateChannel('chat.' . $this->receiver->id);
        }

        // default untuk AI / sistem
        return new PrivateChannel('chat.general');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'message' => $this->chat->message,
            'sender_id' => $this->chat->sender_id,
            'receiver_id' => $this->chat->receiver_id,
            'is_ai' => $this->chat->is_ai,
            'created_at' => $this->chat->created_at->toDateTimeString(),
            'sender_name' => $this->sender?->name,
        ];
    }
}
