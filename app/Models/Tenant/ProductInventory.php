<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductInventory
 *
 * @property int $id
 * @property int $qty
 * @property int $product_id
 * @property int $inventory_source_id
 * @property-read \App\Models\InventorySource $inventory_source
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory whereInventorySourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventory whereQty($value)
 * @mixin \Eloquent
 */
class ProductInventory extends Model
{
    /**
     * @var string
     */
    public $table = 'product_inventories';

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
    public function inventory_source()
    {
        return $this->belongsTo(InventorySource::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
