<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invoice
 *
 * @OA\Schema (
 *      @OA\Xml(name="Invoice"),
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
 *          property="sub_total",
 *          description="sub_total",
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
 *          property="shipping_amount",
 *          description="shipping_amount",
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
 *          property="discount_amount",
 *          description="discount_amount",
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
 *          property="transaction_id",
 *          description="transaction_id",
 *          type="string"
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
 * @property string|null $sub_total
 * @property string|null $grand_total
 * @property string|null $shipping_amount
 * @property string|null $tax_amount
 * @property string|null $discount_amount
 * @property string|null $base_discount_amount
 * @property int|null $order_id
 * @property int|null $address_id
 * @property string|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Address|null $orderAddress
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBaseDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIncrementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOrderAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    /**
     * @var string
     */
    public $table = 'invoices';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['email_sent' => 'boolean'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = ['order_id' => 'required'];

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
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }
}
