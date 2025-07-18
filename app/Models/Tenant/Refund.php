<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Refund
 *
 * @OA\Schema (
 *      @OA\Xml(name="Refund"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="state",
 *          description="state",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email_sent",
 *          description="email_sent",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="total_qty",
 *          description="total_qty",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="adjustment_refund",
 *          description="adjustment_refund",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_adjustment_refund",
 *          description="base_adjustment_refund",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="adjustment_fee",
 *          description="adjustment_fee",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_adjustment_fee",
 *          description="base_adjustment_fee",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="sub_total",
 *          description="sub_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_sub_total",
 *          description="base_sub_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="grand_total",
 *          description="grand_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_grand_total",
 *          description="base_grand_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="shipping_amount",
 *          description="shipping_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="base_shipping_amount",
 *          description="base_shipping_amount",
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
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
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
 * @property string|null $state
 * @property bool $email_sent
 * @property int|null $total_qty
 * @property string|null $adjustment_refund
 * @property string|null $adjustment_fee
 * @property string|null $sub_total
 * @property string|null $grand_total
 * @property string|null $shipping_amount
 * @property string|null $tax_amount
 * @property string|null $discount_percent
 * @property string|null $discount_amount
 * @property int|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\RefundItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Tenant\Order|null $order
 * @property-read \App\Models\Tenant\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newQuery()
 * @method static \Illuminate\Database\Query\Builder|Refund onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund query()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereAdjustmentFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereAdjustmentRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereIncrementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereTotalQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Refund withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Refund withoutTrashed()
 * @mixin \Eloquent
 */
class Refund extends Model
{
    /**
     * @var string
     */
    public $table = 'refunds';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'email_sent' => 'boolean',
    ];

    /**
     * Validation rules
     * @var array
     */
    public static $rules = [
        'email_sent' => 'required',
    ];

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
    public function items()
    {
        return $this->hasMany(RefundItem::class, 'refund_id')->whereNull('parent_id');
    }
}
