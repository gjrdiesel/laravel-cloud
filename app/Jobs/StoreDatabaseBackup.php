<?php

namespace App\Jobs;

use App\Callbacks\CheckDatabaseBackup;
use App\DatabaseBackup;
use App\Scripts\StoreDatabaseBackup as StoreDatabaseBackupScript;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreDatabaseBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The database backup instance.
     *
     * @var \App\DatabaseBackup
     */
    public $backup;

    /**
     * Create a new job instance.
     *
     * @param  \App\DatabaseBackup  $backup
     * @return void
     */
    public function __construct(DatabaseBackup $backup)
    {
        $this->backup = $backup;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->backup->markAsRunning();

        $this->backup->database->runInBackground(new StoreDatabaseBackupScript($this->backup), [
            'then' => [
                new CheckDatabaseBackup($this->backup->id),
            ],
        ]);
    }
}
