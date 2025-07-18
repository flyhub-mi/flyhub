<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelProductAttribute
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelProductAttribute"),
 *      required={""},
 *      @OA\Property(
 *          property="channel_product_id",
 *          description="channel_product_id",
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
 * @property int $channel_product_id
 * @property string $code
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant\ChannelProduct $channelProduct
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereChannelProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProductAttribute whereValue($value)
 * @mixin \Eloquent
 */
class ChannelProductAttribute extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_product_attributes';

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
        'channel_product_id' => 'required',
        'code' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channelProduct()
    {
        return $this->belongsTo(ChannelProduct::class, 'channel_product_id');
    }
}
