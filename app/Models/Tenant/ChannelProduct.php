<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelProduct
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelProduct"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="local_product_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="channel_product_id",
 *          description="channel_product_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="channel_product_name",
 *          description="channel_product_name",
 *          type="string",
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
 * @property int $product_id
 * @property int $channel_id
 * @property string|null $remote_product_id
 * @property string|null $remote_category_id
 * @property string $remote_initial_quantity
 * @property string $remote_sold_quantity
 * @property string|null $remote_link
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelProductAttribute[] $variations_attributes
 * @property-read int|null $variations_attributes_count
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereRemoteCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereRemoteInitialQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereRemoteLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereRemoteProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereRemoteSoldQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelProduct extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_products';

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
        'product_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ChannelProductAttribute::class, 'channel_product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function variations_attributes()
    {
        return $this->hasManyThrough(
            ChannelProductAttribute::class,
            Product::class,
            'parent_id',
            'channel_product_id',
            'product_id',
            'id',
        );
    }
}
