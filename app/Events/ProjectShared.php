<?php

namespace App\Events;

use App\Project;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectShared
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The project instance.
     *
     * @var \App\Project
     */
    public $project;

    /**
     * The user instance.
     *
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $user)
    {
        $this->user = $user;
        $this->project = $project;
    }
}
