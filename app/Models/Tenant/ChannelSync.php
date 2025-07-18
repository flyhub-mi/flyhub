<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SyncLog
 *
 * @property int $id
 * @property string $channel
 * @property string|null $type
 * @property string $model
 * @property int|null $model_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $current
 * @property int $processed
 * @property int $failed
 * @property int $total
 * @property int $current_page
 * @property int $total_pages
 * @property string|null $last_received_at
 * @property string|null $error
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SyncLogResult[] $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync orWhereEnum($key, $enumerables)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync orWhereNotEnum($key, $enumerables)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereCurrentPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereEnum($key, $enumerables)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereFailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereLastReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereNotEnum($key, $enumerables)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereTotalPages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelSync whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelSync extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_syncs';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'channel' => 'required',
        'resource' => 'required',
        'status' => 'required',
        'message' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(ChannelSyncResult::class, 'channel_sync_id');
    }
}
