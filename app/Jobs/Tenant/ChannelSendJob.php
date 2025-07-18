<?php

namespace App\Jobs\Tenant;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Channel;
use FlyHub;

use function _\get;

class ChannelSendJob extends ChannelBase implements ShouldQueue
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
     * @return void
     * @throws MassAssignmentException
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        $this->updateStatus('in_progress');

        $channelResource = $this->channelResource();

        try {
            $result = $channelResource->send($this->data);
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
            ChannelSendJob::dispatch($this->channel, $this->syncLog, $nextJob);

            $itemUpdatedAt = get($this->data, 'updated_at');
            if (!empty($itemUpdatedAt)) {
                $this->channel->setLastSendAt($this->syncLog->model, $itemUpdatedAt);
            }
        }
    }
}
