<?php

namespace App\Events;

use App\DatabaseBackup;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The database backup instance.
     *
     * @var \App\DatabaseBackup
     */
    public $backup;

    /**
     * Create a new event instance.
     *
     * @param  \App\DatabaseBackup  $backup
     * @return void
     */
    public function __construct(DatabaseBackup $backup)
    {
        $this->backup = $backup;
    }
}
