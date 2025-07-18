<?php

namespace App\Jobs\Tenant;

use App\Models\Channel;
use FlyHub;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChannelMoreInfoJob extends ChannelBase implements ShouldQueue
{
    /**
     * @param Channel $channel
     * @param ChannelSync $syncLog
     * @param null|ChannelSyncResult $syncLogResult
     * @return void
     */
    public function __construct($channel, $syncLog, $syncLogResult = null)
    {
        parent::__construct($channel, $syncLog, $syncLogResult);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->updateStatus('in_progress');

            $channelResource = $this->channelResource();
            $channelResourceData = $channelResource->moreInfo($this->data);
            $flyhubResource = $this->flyhubResource();
            $result = $flyhubResource->save($this->channel, [$channelResourceData]);

            $this->saveResult(json_encode($result));
            $this->incrementColumn('processed');
        } catch (\Exception $e) {
            $this->saveError($e->getMessage());
            $this->incrementColumn('failed');

            FlyHub::notifyException($e);
        }

        $nextJob = $this->getNextJob();

        if (is_null($nextJob)) {
            $this->updateStatus('complete');
        } else {
            self::dispatch($this->channel, $this->syncLog, $nextJob);
        }
    }

    /**
     * @param Throwable $e
     * @return void
     */
    public function failed($e)
    {
        FlyHub::notifyException($e);
    }
}
