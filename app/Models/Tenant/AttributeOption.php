<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttributeOption
 *
 * @OA\Schema (
 *      @OA\Xml(name="AttributeOption"),
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
 *          property="sort_order",
 *          description="sort_order",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="attribute_id",
 *          description="attribute_id",
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * @property int $id
 * @property string $name
 * @property int|null $sort_order
 * @property int $attribute_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributeOption extends Model
{
    /**
     * @var string
     */
    public $table = 'attribute_options';

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
        'attribute_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
