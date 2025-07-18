<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @OA\Schema (
 *      @OA\Xml(name="City"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="state_ibge_id",
 *          description="state_ibge_id",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="state_code",
 *          description="state_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="lat",
 *          description="lat",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="lng",
 *          description="lng",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="capital",
 *          description="capital",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="ibge_id",
 *          description="ibge_id",
 *          type="integer",
 *          format="int32"
 *      ),
 * )
 * @property int $id
 * @property int $state_ibge_id
 * @property string $state_code
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property int $capital
 * @property int $ibge_id
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereIbgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateIbgeId($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    /**
     * @var string
     */
    public $table = 'cities';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_ibge_id', 'ibge_id');
    }
}
