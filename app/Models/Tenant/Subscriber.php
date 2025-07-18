<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscriber
 *
 * @OA\Schema (
 *      @OA\Xml(name="Subscriber"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="is_subscribed",
 *          description="is_subscribed",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="token",
 *          description="token",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="channel_id",
 *          description="channel_id",
 *          type="integer",
 *          format="int64"
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
 * @property string $email
 * @property bool $is_subscribed
 * @property string|null $token
 * @property int $channel_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant\Channel $channel
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Query\Builder|Subscriber onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Subscriber withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Subscriber withoutTrashed()
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    /**
     * @var string
     */
    public $table = 'subscribers';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_subscribed' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'is_subscribed' => 'required',
        'channel_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
