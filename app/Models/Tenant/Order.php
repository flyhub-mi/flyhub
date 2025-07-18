<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @OA\Schema (
 *      @OA\Xml(name="Order"),
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
 *          property="channel_name",
 *          description="channel_name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="is_guest",
 *          description="is_guest",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="customer_email",
 *          description="customer_email",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="customer_name",
 *          description="customer_name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="shipping_method",
 *          description="shipping_method",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="coupon_code",
 *          description="coupon_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="is_gift",
 *          description="is_gift",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="total_item_count",
 *          description="total_item_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="total_qty_ordered",
 *          description="total_qty_ordered",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="grand_total",
 *          description="grand_total",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="grand_total_invoiced",
 *          description="grand_total_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="grand_total_refunded",
 *          description="grand_total_refunded",
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
 *          property="sub_total_invoiced",
 *          description="sub_total_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="sub_total_refunded",
 *          description="sub_total_refunded",
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
 *          property="discount_invoiced",
 *          description="discount_invoiced",
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
 *          property="tax_amount",
 *          description="tax_amount",
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
 *          property="tax_amount_refunded",
 *          description="tax_amount_refunded",
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
 *          property="shipping_invoiced",
 *          description="shipping_invoiced",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="shipping_refunded",
 *          description="shipping_refunded",
 *          type="number",
 *          format="number"
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
 *          property="channel_id",
 *          description="channel_id",
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
 * @property string|null $status
 * @property string|null $channel_name
 * @property int|null $is_guest
 * @property string|null $customer_email
 * @property string|null $customer_name
 * @property string $customer_name
 * @property string|null $shipping_method
 * @property string|null $coupon_code
 * @property int $is_gift
 * @property int|null $total_item_count
 * @property int|null $total_qty_ordered
 * @property string|null $grand_total
 * @property string|null $grand_total_invoiced
 * @property string|null $grand_total_refunded
 * @property string|null $sub_total
 * @property string|null $sub_total_invoiced
 * @property string|null $sub_total_refunded
 * @property string|null $discount_percent
 * @property string|null $discount_amount
 * @property string|null $discount_invoiced
 * @property string|null $discount_refunded
 * @property string|null $tax_amount
 * @property string|null $tax_amount_invoiced
 * @property string|null $tax_amount_refunded
 * @property string|null $shipping_amount
 * @property string|null $shipping_invoiced
 * @property string|null $shipping_refunded
 * @property int|null $customer_id
 * @property int|null $channel_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $note
 * @property string|null $private_note
 * @property string|null $issued_date
 * @property string|null $remote_id
 * @property string|null $base_grand_total
 * @property string|null $base_grand_total_invoiced
 * @property string|null $base_grand_total_refunded
 * @property string|null $base_sub_total
 * @property string|null $base_sub_total_invoiced
 * @property string|null $base_sub_total_refunded
 * @property string|null $base_discount_amount
 * @property string|null $base_discount_invoiced
 * @property string|null $base_discount_refunded
 * @property string|null $base_tax_amount
 * @property string|null $base_tax_amount_invoiced
 * @property string|null $base_tax_amount_refunded
 * @property string|null $base_shipping_amount
 * @property string|null $base_shipping_invoiced
 * @property string|null $base_shipping_refunded
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Tenant\Channel|null $channel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelOrder[] $channelsOrder
 * @property-read int|null $channels_order_count
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderPayment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Refund[] $refunds
 * @property-read int|null $refunds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shipment[] $shipments
 * @property-read int|null $shipments_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseDiscountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseDiscountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseGrandTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseGrandTotalRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseShippingInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseShippingRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseSubTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseSubTotalRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseTaxAmountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBaseTaxAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChannelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChannelOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGrandTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGrandTotalRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIncrementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIssuedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrivateNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubTotalInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubTotalRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTaxAmountInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTaxAmountRefunded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalItemCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalQtyOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\Tenant\Address|null $billingAddress
 * @property-read \App\Models\Tenant\Address|null $shippingAddress
 * @mixin \Eloquent
 */
class Order extends Model
{
    /**
     * @var string
     */
    public $table = 'orders';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    public static $rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelsOrder()
    {
        return $this->hasMany(ChannelOrder::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shippingAddress()
    {
        return $this->hasOne(Address::class, 'order_id')->where('address_type', 'shipping');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'order_id')->where('address_type', 'billing');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refunds()
    {
        return $this->hasMany(Refund::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'order_id');
    }
}
