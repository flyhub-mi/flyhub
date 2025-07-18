<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaxGroupMapping
 *
 * @OA\Schema (
 *      @OA\Xml(name="TaxGroupMapping"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
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
 *          property="tax_id",
 *          description="tax_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="position",
 *          description="position",
 *          type="integer",
 *          format="int32"
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
 *      ),
 * )
 * @property int $id
 * @property int $tax_group_id
 * @property int $tax_id
 * @property int $position
 * @property-read \App\Models\Tenant\Tax $tax
 * @property-read \App\Models\Tenant\TaxGroup $taxGroup
 * @property-read \App\Models\Tenant\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping newQuery()
 * @method static \Illuminate\Database\Query\Builder|TaxGroupMapping onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping whereTaxGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroupMapping whereTaxId($value)
 * @method static \Illuminate\Database\Query\Builder|TaxGroupMapping withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaxGroupMapping withoutTrashed()
 * @mixin \Eloquent
 */
class TaxGroupMapping extends Model
{
    /**
     * @var string
     */
    public $table = 'tax_group_mappings';

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
        'tax_group_id' => 'required',
        'tax_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxGroup()
    {
        return $this->belongsTo(TaxGroup::class, 'tax_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
