<?php

namespace App\Observers;

use App\Models\Tenant\ChannelSyncResult;

class ChannelSyncResultObserver
{
    /**
     * @param \App\Models\Tenant\ChannelSyncResult $syncResult
     * @return void
     */
    public function updated(ChannelSyncResult $syncResult)
    {
        if ($syncResult->wasChanged('current') && $syncResult->current >= $syncResult->total) {
            $syncResult->update(['status' => 'complete']);
        }
    }
}
