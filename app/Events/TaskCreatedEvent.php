<?php

namespace App\Events;

use App\Events\Event;
use App\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskCreatedEvent extends Event
{
    use SerializesModels;

    protected $task;

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
