<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceItem
 *
 * @OA\Schema (
 *      @OA\Xml(name="InvoiceItem"),
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
 *          property="invoice_id",
 *          description="invoice_id",
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
 * @property int|null $product_id
 * @property string|null $product_type
 * @property int|null $order_item_id
 * @property int|null $invoice_id
 * @property int|null $parent_id
 * @property string|null $additional
 * @property string|null $discount_percent
 * @property string|null $discount_amount
 * @property-read \App\Models\Invoice|null $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|InvoiceItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|InvoiceItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InvoiceItem withoutTrashed()
 * @mixin \Eloquent
 */
class InvoiceItem extends Model
{
    /**
     * @var string
     */
    public $table = 'invoice_items';

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
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
