<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelConfig
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelConfig"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="channel_id",
 *          description="channel_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 * @property int $id
 * @property int $channel_id
 * @property string $code
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant\Channel $channel
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelConfig whereValue($value)
 * @mixin \Eloquent
 */
class ChannelConfig extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_configs';

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
        'channel_id' => 'required',
        'code' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
