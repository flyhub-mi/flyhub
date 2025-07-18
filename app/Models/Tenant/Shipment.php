<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shipment
 *
 * @OA\Schema (
 *      @OA\Xml(name="Shipment"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="status",
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
 *          property="width",
 *          description="width",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="height",
 *          description="height",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="depth",
 *          description="depth",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="carrier_code",
 *          description="carrier_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="carrier_title",
 *          description="carrier_title",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="track_number",
 *          description="track_number",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email_sent",
 *          description="email_sent",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="customer_id",
 *          description="customer_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="customer_type",
 *          description="customer_type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="inventory_source_id",
 *          description="inventory_source_id",
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * @property int $id
 * @property string|null $status
 * @property int|null $total_qty
 * @property int|null $total_weight
 * @property string $total_price
 * @property string $total_tax
 * @property string|null $method
 * @property string|null $carrier
 * @property string|null $track_number
 * @property bool $email_sent
 * @property int|null $customer_id
 * @property int $order_id
 * @property int|null $address_id
 * @property int|null $inventory_source_id
 * @property float|null $width
 * @property float|null $height
 * @property float|null $depth
 * @property-read \App\Models\Tenant\InventorySource|null $inventorySource
 * @property-read \App\Models\Tenant\Order $order
 * @property-read \App\Models\Tenant\Address|null $orderAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ShipmentItem[] $shipmentItems
 * @property-read int|null $shipment_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCarrier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereInventorySourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereOrderAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTotalQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTrackNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereWidth($value)
 * @mixin \Eloquent
 */
class Shipment extends Model
{

    /**
     * @var string
     */
    public $table = 'shipments';

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
    protected $casts = [
        'email_sent' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email_sent' => 'required',
        'order_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventorySource()
    {
        return $this->belongsTo(InventorySource::class, 'inventory_source_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipmentItems()
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_id');
    }
}
