<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttributeSet
 *
 * @OA\Schema (
 *      @OA\Xml(name="AttributeSet"),
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
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet newQuery()
 * @method static \Illuminate\Database\Query\Builder|AttributeSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereIsUserDefined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AttributeSet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AttributeSet withoutTrashed()
 * @mixin \Eloquent
 */
class AttributeSet extends Model
{
    /**
     * @var string
     */
    public $table = 'attribute_sets';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = ['name' => 'required'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_set_mappings', 'attribute_set_id', 'attribute_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'attribute_set_id');
    }
}
