<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\State
 *
 * @OA\Schema (
 *      @OA\Xml(name="State"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="country_code",
 *          description="country_code",
 *          type="string"
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
 *          property="ibge_id",
 *          description="ibge_id",
 *          type="integer",
 *          format="int32"
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
 *      )
 * )
 * @property int $id
 * @property string $country_code
 * @property string $code
 * @property string $name
 * @property int $ibge_id
 * @property float $lat
 * @property float $lng
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereIbgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @mixin \Eloquent
 */
class State extends Model
{
    /**
     * @var string
     */
    public $table = 'states';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_ibge_id');
    }
}
