<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShipmentItem
 *
 * @OA\Schema (
 *      @OA\Xml(name="ShipmentItem"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
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
 *          property="sku",
 *          description="sku",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="qty",
 *          description="qty",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="weight",
 *          description="weight",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_price",
 *          description="base_price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="total",
 *          description="total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_total",
 *          description="base_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="product_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="product_type",
 *          description="product_type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="order_item_id",
 *          description="order_item_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="shipment_id",
 *          description="shipment_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="additional",
 *          description="additional",
 *          type="string"
 *      )
 * )
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $sku
 * @property int|null $qty
 * @property int|null $weight
 * @property string|null $price
 * @property string|null $total
 * @property int|null $product_id
 * @property int|null $order_item_id
 * @property int $shipment_id
 * @property string|null $additional
 * @property string|null $base_price
 * @property string|null $base_total
 * @property-read \App\Models\Tenant\Shipment $shipment
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereBaseTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereShipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereWeight($value)
 * @mixin \Eloquent
 */
class ShipmentItem extends Model
{
    /**
     * @var string
     */
    public $table = 'shipment_items';

    /**
     * @var bool
     */
    public $timestamps = false;

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
        'shipment_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
