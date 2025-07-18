<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductAttribute
 *
 * @OA\Schema (
 *      @OA\Xml(name="ProductAttribute"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="text_value",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="product_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="attribute_id",
 *          description="attribute_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="channel_id",
 *          description="channel_id",
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * @property int $id
 * @property string $value
 * @property int $product_id
 * @property int $attribute_id
 * @property int $channel_id
 * @property-read \App\Models\Attribute $attribute
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Tenant\Channel $channel
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereBooleanValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereDateValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereDatetimeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereFloatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereIntegerValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereJsonValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereTextValue($value)
 * @mixin \Eloquent
 */
class ProductAttribute extends Model
{
    /**
     * @var string
     */
    public $table = 'product_attributes';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'required',
        'attribute_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
