<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RefundItem
 *
 * @OA\Schema (
 *      @OA\Xml(name="RefundItem"),
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
 *          property="refund_id",
 *          description="refund_id",
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
 * @property string|null $name
 * @property string|null $description
 * @property string|null $sku
 * @property int|null $qty
 * @property string $price
 * @property string $total
 * @property string|null $tax_amount
 * @property string|null $discount_percent
 * @property string|null $discount_amount
 * @property int|null $product_id
 * @property string|null $product_type
 * @property int|null $order_item_id
 * @property int|null $refund_id
 * @property int|null $parent_id
 * @property string|null $additional
 * @property-read \App\Models\Tenant\OrderItem|null $orderItem
 * @property-read \App\Models\Tenant\Refund|null $refund
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|RefundItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundItem whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|RefundItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RefundItem withoutTrashed()
 * @mixin \Eloquent
 */
class RefundItem extends Model
{
    /**
     * @var string
     */
    public $table = 'refund_items';

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
        'base_price' => 'required',
        'total' => 'required',
        'base_total' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refund()
    {
        return $this->belongsTo(Refund::class, 'refund_id');
    }
}
