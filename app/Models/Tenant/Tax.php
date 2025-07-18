<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tax
 *
 * @OA\Schema (
 *      @OA\Xml(name="Tax"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="identifier",
 *          description="identifier",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="is_zip",
 *          description="is_zip",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="zip_code",
 *          description="zip_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="zip_from",
 *          description="zip_from",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="zip_to",
 *          description="zip_to",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="state",
 *          description="state",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="state_from",
 *          description="state_from",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="state_to",
 *          description="state_to",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="country",
 *          description="country",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="tax_rate",
 *          description="tax_rate",
 *          type="number",
 *          format="number"
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
 * @property string $tag
 * @property string $name
 * @property string $type
 * @property string $size
 * @property string|null $description
 * @property string $tax_rate
 * @property string|null $formula
 * @property bool $required
 * @property bool $visible
 * @property string|null $default_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\TaxOption[] $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereFormula($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereVisible($value)
 * @method static \Illuminate\Database\Query\Builder|Tax withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tax withoutTrashed()
 * @mixin \Eloquent
 */
class Tax extends Model
{
    /**
     * @var string
     */
    public $table = 'taxes';

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
        'state_rate' => 'boolean',
        'required' => 'boolean',
        'visible' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(TaxOption::class, 'tax_id');
    }
}
