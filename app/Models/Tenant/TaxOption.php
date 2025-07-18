<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaxOption
 *
 * @OA\Schema (
 *      @OA\Xml(name="TaxOption"),
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
 *          property="value",
 *          description="value",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="tax_id",
 *          description="tax_id",
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * @property int $id
 * @property string $label
 * @property string $value
 * @property int $tax_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Tenant\Tax $tax
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxOption whereValue($value)
 * @mixin \Eloquent
 */
class TaxOption extends Model
{
    /**
     * @var string
     */
    public $table = 'tax_options';

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
        'label' => 'required',
        'value' => 'required',
        'tax_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
