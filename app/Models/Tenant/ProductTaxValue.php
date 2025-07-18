<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductTaxValue
 *
 * @OA\Schema (
 *      @OA\Xml(name="ProductTaxValue"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="tag",
 *          description="tag",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="manual",
 *          description="manual",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="string_value",
 *          description="string_value",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="double_value",
 *          description="double_value",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="integer_value",
 *          description="integer_value",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="formula",
 *          description="formula",
 *          type="string",
 *          format="string"
 *      ),
 *      @OA\Property(
 *          property="formula_values",
 *          description="formula_values",
 *          type="string",
 *          format="string"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="product_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="tax_id",
 *          description="tax_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="tax_group_id",
 *          description="tax_group_id",
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
 * @property string|null $tag
 * @property int $manual
 * @property string|null $string_value
 * @property float|null $double_value
 * @property int|null $integer_value
 * @property string|null $formula
 * @property string|null $formula_values
 * @property int $product_id
 * @property int $tax_id
 * @property int $tax_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Tax $tax
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductTaxValue onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereDoubleValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereFormula($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereFormulaValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereIntegerValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereStringValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereTaxGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTaxValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductTaxValue withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductTaxValue withoutTrashed()
 * @mixin \Eloquent
 */
class ProductTaxValue extends Model
{
    /**
     * @var string
     */
    public $table = 'product_tax_values';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The taxes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'required',
        'tax_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
