<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductOrderedInventory
 *
 * @property int $id
 * @property int $qty
 * @property int $product_id
 * @property int $channel_id
 * @property-read \App\Models\Tenant\Channel $channel
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrderedInventory whereQty($value)
 * @mixin \Eloquent
 */
class ProductOrderedInventory extends Model
{
    /**
     * @var string
     */
    public $table = 'product_ordered_inventories';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
