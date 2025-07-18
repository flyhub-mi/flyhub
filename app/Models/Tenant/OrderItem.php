<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderItem
 *
 * @OA\Schema (
 *      @OA\Xml(name="OrderItem"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="sku",
 *          description="sku",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="coupon_code",
 *          description="coupon_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="weight",
 *          description="weight",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="total_weight",
 *          description="total_weight",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="qty_ordered",
 *          description="qty_ordered",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="qty_shipped",
 *          description="qty_shipped",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="qty_invoiced",
 *          description="qty_invoiced",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="qty_canceled",
 *          description="qty_canceled",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="qty_refunded",
 *          description="qty_refunded",
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
 *          property="total_invoiced",
 *          description="total_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_total_invoiced",
 *          description="base_total_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="amount_refunded",
 *          description="amount_refunded",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_amount_refunded",
 *          description="base_amount_refunded",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="discount_percent",
 *          description="discount_percent",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="discount_amount",
 *          description="discount_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_discount_amount",
 *          description="base_discount_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="discount_invoiced",
 *          description="discount_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_discount_invoiced",
 *          description="base_discount_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="discount_refunded",
 *          description="discount_refunded",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_discount_refunded",
 *          description="base_discount_refunded",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="tax_percent",
 *          description="tax_percent",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="tax_amount",
 *          description="tax_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_tax_amount",
 *          description="base_tax_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="tax_amount_invoiced",
 *          description="tax_amount_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_tax_amount_invoiced",
 *          description="base_tax_amount_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="tax_amount_refunded",
 *          description="tax_amount_refunded",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_tax_amount_refunded",
 *          description="base_tax_amount_refunded",
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
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="parent_id",
 *          description="parent_id",
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
 * @property string|null $sku
 * @property string|null $name
 * @property string|null $coupon_code
 * @property string|null $weight
 * @property string|null $total_weight
 * @property int|null $qty_ordered
 * @property int|null $qty_shipped
 * @property int|null $qty_invoiced
 * @property int|null $qty_canceled
 * @property int|null $qty_refunded
 * @property string $price
 * @property string $total
 * @property string $total_invoiced
 * @property string $amount_refunded
 * @property string|null $discount_percent
 * @property string|null $discount_amount
 * @property string|null $discount_invoiced
 * @property string|null $discount_refunded
 * @property string|null $tax_percent
 * @property string|null $tax_amount
 * @property string|null $tax_amount_invoiced
 * @property string|null $tax_amount_refunded
 * @property int|null $product_id
 * @property int|null $order_id
 * @property int|null $parent_id
 * @property string|null $additional
 * @property string|null $unit
 * @property string|null $base_price
 * @property string|null $base_total
 * @property string|null $base_total_invoiced
 * @property string|null $base_amount_refunded
 * @property string|null $base_discount_amount
 * @property string|null $base_discount_invoiced
 * @property string|null $base_discount_refunded
 * @property string|null $base_tax_amount
 * @property string|null $base_tax_amount_invoiced
 * @property string|null $base_tax_amount_refunded
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RefundItem[] $refundItems
 * @property-read int|null $refund_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseDiscountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseDiscountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseTaxAmountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseTaxAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereBaseTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQtyCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQtyInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQtyOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQtyRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQtyShipped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTaxAmountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTaxAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereWeight($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    /**
     * @var string
     */
    public $table = 'order_items';

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
        'price' => 'required',
        'total' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refundItems()
    {
        return $this->hasMany(RefundItem::class, 'order_item_id');
    }
}
