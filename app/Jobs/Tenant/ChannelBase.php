<?php

namespace App\Jobs\Tenant;

use Throwable;
use App\Models\Tenant\ChannelSyncResult;
use App\Models\Tenant\ChannelSync;
use App\Models\Tenant\Channel;
use App\Jobs\Tenant\BaseJob;
use App\Integration\Mapping\Utils;
use App\Integration\ChannelResource;
use FlyHub;

class ChannelBase extends BaseJob
{
    /** @var array $data */
    protected $data = [];

    /** @var \App\Models\Tenant\Channel $channel */
    protected $channel;

    /** @var \App\Models\SyncLog $syncLog */
    protected $syncLog;

    /** @var null|\App\Models\SyncLogResult $syncLogResult */
    protected $syncLogResult = null;

    /**
     * @param Channel $channel
     * @param ChannelSync $syncLog
     * @param null|ChannelSyncResult $syncLogResult
     * @return void
     */
    public function __construct($channel, $syncLog, $syncLogResult)
    {
        $this->channel = $channel;
        $this->syncLog = $syncLog;
        $this->syncLogResult = $syncLogResult ?: $this->getNextJob();
        $this->data = is_null($this->syncLogResult) ? [] : json_decode($this->syncLogResult->data, true);
    }

    /** @return \App\Integration\Resources\Base|null  */
    protected function flyhubResource($resource = null)
    {
        $resourceClass = Utils::buildNamespace('App\Integration\Resources', $resource ?: $this->syncLog->resource);

        return class_exists($resourceClass) ? new $resourceClass() : null;
    }

    /** @return ChannelResource|null  */
    protected function channelResource($channel = null, $resource = null)
    {
        $resourceClass = Utils::buildNamespace('App\Integration\Channels', $channel ?: $this->channel->code, 'Resources', $resource ?: $this->syncLog->resource);

        return class_exists($resourceClass) ? new $resourceClass($this->channel) : null;
    }

    /**
     * @param string $status
     * @return void
     */
    protected function updateStatus($status)
    {
        if ($this->syncLog->status !== $status) {
            $this->syncLog->update(['status' => $status]);
        }
    }

    /**
     * @param string $result
     * @return void
     */
    protected function saveResult($result)
    {
        $attributes = ['status' => 'complete', 'result' => $result];

        if (is_null($this->syncLogResult)) {
            $this->syncLog->results()->create($attributes);
        } else {
            $this->syncLogResult->update($attributes);
        }
    }

    /**
     * @param string $error
     * @return void
     */
    protected function saveError($error)
    {
        $attributes = ['status' => 'failed', 'error' => $error];

        if ($this->syncLog->results()->count() === 0) {
            $this->syncLog->update($attributes);
        } elseif (is_null($this->syncLogResult)) {
            $this->syncLog->results()->create($attributes);
        } else {
            $this->syncLogResult->update($attributes);
        }
    }

    /**
     * @param string $column
     * @param null|int $amount
     * @return int
     */
    protected function incrementColumn($column, $amount = 1)
    {
        return $this->syncLog->increment($column, $amount);
    }

    /**
     * @param int $total
     * @return void
     */
    protected function updateTotalItems($total)
    {
        $this->syncLog->update(['total' => intval($total)]);
    }

    /**
     * @param int $totalPages
     * @return void
     */
    protected function updateTotalPages($totalPages)
    {
        $this->syncLog->update(['total_pages' => $totalPages]);
    }

    /** @return null|ChannelSyncResult  */
    protected function getNextJob()
    {
        return $this->syncLog
            ->results()
            ->where('id', '<>', is_null($this->syncLogResult) ? null : $this->syncLogResult->id)
            ->where('status', 'in_queue')
            ->first();
    }

    /** @return null|int  */
    protected function getCurrentPage()
    {
        $page = $this->syncLog?->current_page ?: 1;
        $isNewJob = $this->syncLog?->processed === 0;

        if ($isNewJob) {
            $lastFailedJob = ChannelSync::where([
                'channel' => $this->channel->code,
                'resource' => $this->syncLog->resource,
                'status' => 'failed',
            ])->orderBy('updated_at', 'desc')->first();

            if (is_null($lastFailedJob)) {
                return $page;
            }

            if ($lastFailedJob->current_page < $lastFailedJob->total_pages) {
                $page = $lastFailedJob->current_page;

                $this->syncLog->update(['current_page' => intval($page)]);
            }
        }

        return $page;
    }

    /**
     * @param \Throwable $e
     * @return void
     */
    public function failed($e)
    {
        $message = str_contains($e->getMessage(), 'timed out')
            ? 'Tempo esgotado: Não foi possivel receber os dados. O serviço remoto pode estar indisponível, ou instavel.'
            : $e->getMessage();

        $this->saveError($message);

        FlyHub::notifyException($e);
    }
}
