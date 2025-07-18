<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SyncLogResult
 *
 * @property int $id
 * @property int $sync_log_id
 * @property string|null $status
 * @property string|null $data
 * @property string|null $result
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SyncLog $sync_log
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereSyncLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSyncResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelSyncResult extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_sync_results';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = ['channel_sync_id' => 'required'];

    public function sync_log()
    {
        return $this->belongsTo(ChannelSync::class, 'channel_sync_id');
    }
}
