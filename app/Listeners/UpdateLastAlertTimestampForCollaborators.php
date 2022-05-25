<?php

namespace App\Listeners;

use App\Events\AlertCreated;
use App\User;
use DateTime;

class UpdateLastAlertTimestampForCollaborators
{
    /**
     * Handle the event.
     *
     * @param  AlertCreated  $event
     * @return void
     */
    public function handle(AlertCreated $event)
    {
        User::whereIn('id', $event->affectedIds())->update(
            ['last_alert_received_at' => new DateTime()]
        );
    }
}
