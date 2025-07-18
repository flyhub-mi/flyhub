<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TenantAddress
 *
 * @OA\Schema (
 *      @OA\Xml(name="TenantAddress"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="tenant_id",
 *          description="tenant_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="street_name",
 *          description="street_name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="street_number",
 *          description="street_number",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="country",
 *          description="country",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="state",
 *          description="state",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="city",
 *          description="city",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="postcode",
 *          description="postcode",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="phone",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="default_address",
 *          description="default_address",
 *          type="boolean"
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
 * @property string|null $street
 * @property string|null $number
 * @property string|null $complement
 * @property string|null $neighborhood
 * @property string $country
 * @property string|null $state
 * @property string|null $city
 * @property string $postcode
 * @property string $phone
 * @property int $tenant_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TenantAddress extends Model
{
    /**
     * @var string
     */
    public $table = 'tenant_address';

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
        'postcode' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
