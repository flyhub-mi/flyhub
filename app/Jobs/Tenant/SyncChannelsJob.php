<?php

namespace App\Jobs\Tenant;

use DB;
use Throwable;
use App\FlyHub;
use App\Models\Tenant\ChannelSync;
use InvalidArgumentException;
use App\Integration\Mapping\Utils;
use App\Models\Tenant\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use RuntimeException;

class SyncChannelsJob extends BaseJob implements ShouldQueue
{
    private $type;
    private $resource;

    /**
     * @param null|string $type
     * @param null|string $resource
     * @return void
     */
    public function __construct($type = 'receive', $resource = 'all')
    {
        $this->type = strtolower($type);
        $this->resource = strtolower($resource);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function handle()
    {
        $channels = Channel::whereIn('code', FlyHub::CHANNELS)->get();

        foreach ($channels as $channel) {
            try {
                $this->syncResources($channel);
            } catch (\Exception $e) {
                FlyHub::notifyExceptionWithMetaData($e, [
                    'channel' => $channel->toArray(),
                    'type' => $this->type,
                    'resource' => $this->resource,
                ]);
            }
        }
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    private function syncResources($channel)
    {
        foreach (FlyHub::RESOURCES as $resource) {
            if ($this->resource !== 'all' && $this->resource !== strtolower($resource)) {
                continue;
            }

            $channelResource = $this->channelResource($channel, $resource);
            if (is_null($channelResource) || !method_exists($channelResource, $this->type)) {
                continue;
            }

            if ($channel->can($this->type, $resource) && $this->jobNotInQueue($channel, $resource)) {
                $this->{$this->type}($channel, $resource);
            }
        }
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param string $resource
     * @return void
     */
    public function receive($channel, string $resource)
    {
        $syncLog = ChannelSync::create([
            'type' => 'receive',
            'status' => 'in_queue',
            'channel' => $channel->code,
            'resource' => $resource,
            'last_received_at' => $channel->getLastReceivedAt($resource),
        ]);

        ChannelReceiveJob::dispatch($channel, $syncLog);
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param string $resource
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function send($channel, string $resource)
    {
        $itemsToSend = $this->flyhubResource($resource)->itemsToSend($channel);
        $total = count($itemsToSend);

        if ($total > 0) {
            $channelSync = ChannelSync::create([
                'type' => 'send',
                'status' => 'in_queue',
                'channel' => $channel->code,
                'resource' => $resource,
                'total' => $total,
            ]);

            $results = array_map(
                fn ($item) => [
                    'channel_sync_id' => $channelSync->id,
                    'status' => 'in_queue',
                    'data' => json_encode($item),
                ],
                $itemsToSend,
            );

            DB::table('channel_sync_results')->insert($results);

            ChannelSendJob::dispatch($channel, $channelSync);
        }
    }

    /** @return \App\Integration\Resources\Base|null  */
    protected function flyhubResource($resource)
    {
        $resourceClass = Utils::buildNamespace('App\Integration\Resources', ucfirst($resource));

        return class_exists($resourceClass) ? new $resourceClass() : null;
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param mixed $resource
     * @return object|null
     */
    protected function channelResource($channel, $resource)
    {
        $resourceClass = Utils::buildNamespace('App\Integration\Channels', $channel->code, 'Resources', ucfirst($resource));

        return class_exists($resourceClass) ? new $resourceClass($channel) : null;
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param mixed $resource
     * @return bool
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    private function jobNotInQueue($channel, $resource)
    {
        return !ChannelSync::whereIn('status', ['in_queue', 'in_progress'])
            ->where('channel', $channel->code)
            ->where('resource', ucfirst($resource))
            ->exists();
    }
}
