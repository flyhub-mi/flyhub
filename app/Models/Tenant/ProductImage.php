<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\ProductImage
 *
 * @OA\Schema (
 *      @OA\Xml(name="ProductImage"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="path",
 *          description="path",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="product_id",
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
 * @property string|null $type
 * @property string $path
 * @property int $product_id
 * @property int $channel_id
 * @property-read mixed $url
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereType($value)
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    /**
     * @var string
     */
    public $table = 'product_images';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $appends = ['url'];

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
        'file' => 'required|image|max:2000',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return mixed
     */
    public function url()
    {
        return Storage::disk('s3')->url($this->path);
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }
}
