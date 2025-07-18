<?php

namespace App\Jobs\Tenant;

use function _\get;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;
use FlyHub;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\MassAssignmentException;

class ChannelReceiveJob extends ChannelBase implements ShouldQueue
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

    /** @return void  */
    public function handle()
    {
        try {
            $this->updateStatus('in_progress');

            $channelResource = $this->channelResource();
            $hasPagination = method_exists($channelResource, 'paginationInfo');
            $hasMoreInfo = method_exists($channelResource, 'getMoreInfo');
            $page = $hasPagination ? $this->getCurrentPage() : 1;
            $items = $channelResource->receive($page, $this->syncLog->last_received_at);
            $total = is_array($items) ? count($items) : 0;

            if ($hasPagination && $total > 0) {
                $paginationInfo = $channelResource->paginationInfo();

                $this->scheduleToReceiveNextPage($paginationInfo);
            } else {
                $this->incrementColumn('total', $total);
            }

            if ($hasMoreInfo && $total > 0) {
                $this->getMoreInfo($items);
            } elseif ($total > 0) {
                $this->save($items, $hasPagination);
            } else {
                $this->saveError('Nemhum dado para salvar.');
            }
        } catch (\Exception $e) {
            $this->saveError($e->getTraceAsString());

            FlyHub::notifyException($e);
        }
    }

    /**
     * @param mixed $paginationInfo
     * @return void
     * @throws MassAssignmentException
     */
    private function scheduleToReceiveNextPage($paginationInfo)
    {
        $totalItems = get($paginationInfo, 'total_items', 0);
        $totalPages = get($paginationInfo, 'total_pages', 1);
        $currentPage = $this->getCurrentPage();

        $this->updateTotalItems($totalItems);
        $this->updateTotalPages($totalPages);

        if ($totalPages > $currentPage) {
            $this->incrementColumn('current_page');

            ChannelReceiveJob::dispatch($this->channel, $this->syncLog);
        }
    }

    /**
     * @param mixed $mappedItems
     * @return void
     */
    private function getMoreInfo($mappedItems)
    {
        DB::table('sync_log_results')->insert(
            array_map(
                fn ($item) => [
                    'type' => 'receive',
                    'sync_log_id' => $this->syncLog->id,
                    'status' => 'in_queue',
                    'data' => json_encode($item),
                ],
                $mappedItems,
            ),
        );

        ChannelMoreInfoJob::dispatch($this->channel, $this->syncLog);
    }

    /**
     * @param array $mappedItems
     * @param bool $hasPagination
     * @return void
     * @throws MassAssignmentException
     */
    private function save($mappedItems, $hasPagination)
    {
        $flyhubResource = $this->flyhubResource();
        $result = $flyhubResource->save($this->channel, $mappedItems);

        $this->saveResult(is_string($result) ? $result : json_encode($result));

        if (!$hasPagination || $this->isComplete()) {
            $this->updateStatus('complete');
        }

        $this->incrementColumn('processed', count($mappedItems));
    }

    /** @return bool  */
    private function isComplete()
    {
        $totalProcessed = $this->syncLog->processed + $this->syncLog->failed;
        $isAllProcessed = $totalProcessed >= $this->syncLog->total;
        $isAllPagesProcessed = $this->syncLog->current_page >= $this->syncLog->total_pages;

        return $isAllProcessed && $isAllPagesProcessed;
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
