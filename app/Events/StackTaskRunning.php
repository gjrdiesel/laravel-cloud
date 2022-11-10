<?php

namespace App\Events;

use App\StackTask;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StackTaskRunning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The stack task instance.
     *
     * @var \App\StackTask
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param  \App\StackTask  $task
     * @return void
     */
    public function __construct(StackTask $task)
    {
        $this->task = $task;
    }
}
