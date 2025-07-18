<?php

namespace App\Jobs\Tenant;

use LogicException;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use App\Models\Tenant\ChannelSync;

class MaintenceJob extends BaseJob implements ShouldQueue
{
    public $task;

    /**
     * @param string $task
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws MassAssignmentException
     */
    public function handle()
    {
        if ($this->task === 'clear') {
            ChannelSync::where('created_at', '>=', Carbon::now()->addDays(7))->delete();
        }

        if ($this->task === 'mark-failed') {
            ChannelSync::where('updated_at', '<=', Carbon::now()->subHours(3))
                ->whereIn('status', ['in_queue', 'in_progress'])
                ->update(['status' => 'failed']);
        }
    }
}
