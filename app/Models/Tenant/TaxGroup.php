<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaxGroup
 *
 * @OA\Schema (
 *      @OA\Xml(name="TaxGroup"),
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
 *          property="description",
 *          description="description",
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
 * @property string|null $parent_tag
 * @property string $tag
 * @property string $name
 * @property string $show_when
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tax[] $taxes
 * @property-read int|null $taxes_count
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|TaxGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereParentTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereShowWhen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TaxGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaxGroup withoutTrashed()
 * @mixin \Eloquent
 */
class TaxGroup extends Model
{
    /**
     * @var string
     */
    public $table = 'tax_groups';

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
        'name' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'tax_group_mappings', 'tax_group_id', 'tax_id');
    }
}
