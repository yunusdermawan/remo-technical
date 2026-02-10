<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public Task $task
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('tasks');
    }

    public function broadcastAs(): string
    {
        return 'task.status.updated';
    }
}
