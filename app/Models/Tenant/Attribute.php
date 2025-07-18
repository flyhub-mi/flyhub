<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attribute
 *
 * @OA\Schema (
 *      @OA\Xml(name="Attribute"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="validation",
 *          description="validation",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="position",
 *          description="position",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="is_required",
 *          description="is_required",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="value_per_channel",
 *          description="value_per_channel",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="is_configurable",
 *          description="is_configurable",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="is_user_defined",
 *          description="is_user_defined",
 *          type="boolean"
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
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string|null $validation
 * @property int|null $position
 * @property bool $is_required
 * @property bool $is_unique
 * @property bool $value_per_channel
 * @property bool $is_filterable
 * @property bool $is_configurable
 * @property bool $is_user_defined
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeSet[] $attributeSets
 * @property-read int|null $attribute_sets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeOption[] $options
 * @property-read int|null $options_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Query\Builder|Attribute onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsConfigurable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsFilterable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsUnique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsUserDefined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereValuePerChannel($value)
 * @method static \Illuminate\Database\Query\Builder|Attribute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attribute withoutTrashed()
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    /**
     * @var string
     */
    public $table = 'attributes';

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
        'is_required' => 'boolean',
        'is_unique' => 'boolean',
        'value_per_channel' => 'boolean',
        'is_filterable' => 'boolean',
        'is_configurable' => 'boolean',
        'is_user_defined' => 'boolean',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributeSets()
    {
        return $this->belongsToMany(AttributeSet::class, 'attribute_set_mappings');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }
}
