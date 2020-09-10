<?php

namespace App\Policies;

use App\Database;
use App\DatabaseBackup;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatabaseBackupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the database backup.
     *
     * @param \App\User           $user
     * @param \App\DatabaseBackup $backup
     *
     * @return mixed
     */
    public function delete(User $user, DatabaseBackup $backup)
    {
        return $user->projects->contains($backup->database->project);
    }
}
