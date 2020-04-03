<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SearchedPlaces implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $query;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($query)
    {
        $this->query = $query;
        $this->user = Auth::user();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('searched-places');
    }

    public function broadcastAs()
    {
        return 'searched-place';
    }

    public function broadcastWith()
    {
        return [
            'query' => $this->query,
            'user' => [
                'user_email' => $this->user->email,
                'user_name' => $this->user->name,
            ],
        ];
    }
}
