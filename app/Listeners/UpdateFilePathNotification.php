<?php

namespace App\Listeners;

use App\Events\StoreableUpdated;


class UpdateFilePathNotification
{
    /**
     * Handle the event.
	 *
	 * @param StoreableUpdated $event
     */
    public function handle(StoreableUpdated $event) : void
    {
        $storeable = $event->storeable;
		$storeable->renameFile();
    }
}
