<?php

namespace App\Jobs\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Tenant\ChannelSync;
use App\Jobs\Tenant\ChannelSendJob;
use App\FlyHub;
use App\Models\Tenant\Channel;

class ChannelSendResourceJob extends ChannelBase implements ShouldQueue
{
    protected $resource;
    protected $name;
    protected $channels;

    /**
     * @param Model $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
        $this->name = ucfirst($resource->table);
        $this->channels = Channel::whereIn('code', FlyHub::CHANNELS)->get();
    }

    /** @return void  */
    public function handle()
    {
        try {
            $flyhubResource = $this->flyhubResource($this->name);

            foreach ($this->channels as $channel) {
                if ($flyhubResource->canSend($channel, $this->resource) && $this->jobNotInQueue($channel->code)) {
                    $this->dispatchChannelSendJob($channel, $flyhubResource->getData($this->resource));
                }
            }
        } catch (\Exception $e) {
            FlyHub::notifyException($e);
        }
    }

    /**
     * @param string $channelCode
     * @return bool
     */
    protected function jobNotInQueue($channelCode)
    {
        return !ChannelSync::where('status', 'in_queue')
            ->where('resource', $this->name)
            ->where('resource_id', $this->resource->id)
            ->where('channel', $channelCode)
            ->exists();
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $resourceData
     */
    protected function dispatchChannelSendJob($channel, $resourceData)
    {
        $syncLog = ChannelSync::create([
            'type' => 'send',
            'status' => 'in_queue',
            'channel' => $channel->code,
            'resource' => $this->name,
            'resource_id' => $this->resource->id,
            'total' => 1,
        ]);

        $syncLogResult = $syncLog->results()->create([
            'sync_log_id' => $syncLog->id,
            'status' => 'in_queue',
            'data' => json_encode($resourceData),
        ]);

        ChannelSendJob::dispatch($channel, $syncLog, $syncLogResult);
    }
}
