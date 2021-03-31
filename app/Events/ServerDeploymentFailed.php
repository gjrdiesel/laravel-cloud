<?php

namespace App\Events;

use App\ServerDeployment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServerDeploymentFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The server deployment instance.
     *
     * @var \App\ServerDeployment
     */
    public $deployment;

    /**
     * Create a new event instance.
     *
     * @param \App\ServerDeployment $deployment
     *
     * @return void
     */
    public function __construct(ServerDeployment $deployment)
    {
        $this->deployment = $deployment;
    }
}
