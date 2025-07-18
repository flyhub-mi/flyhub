<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelOrder
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelOrder"),
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
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="remote_order_id",
 *          description="remote_order_id",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="active",
 *          description="active",
 *          type="boolean"
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
 *      ),
 * )
 * @property int $id
 * @property int $channel_id
 * @property int $order_id
 * @property string|null $remote_order_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereRemoteOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelOrder extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_orders';

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
        'order_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
