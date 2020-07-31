<?php

namespace App\Jobs;

use App\Project;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteServerOnProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The project instance.
     *
     * @param  \App\Project
     */
    public $project;

    /**
     * The server's provider ID.
     *
     * @var string
     */
    public $providerServerId;

    /**
     * Create a new job instance.
     *
     * @param \App\Project $project
     * @param string       $providerServerId
     *
     * @return void
     */
    public function __construct(Project $project, $providerServerId)
    {
        $this->project = $project;
        $this->providerServerId = $providerServerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->project->withProvider()->deleteServerById(
            $this->providerServerId
        );
    }

    /**
     * Handle a job failure.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->project->alerts()->create([
            'type'      => 'ServerDeletionFailed',
            'exception' => (string) $exception,
            'meta'      => [],
        ]);
    }
}
