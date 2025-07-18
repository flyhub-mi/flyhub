<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InventorySource
 *
 * @OA\Schema (
 *      @OA\Xml(name="InventorySource"),
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
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="contact_name",
 *          description="contact_name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="contact_email",
 *          description="contact_email",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="contact_number",
 *          description="contact_number",
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
 *          property="street",
 *          description="street",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="postcode",
 *          description="postcode",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="priority",
 *          description="priority",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          description="latitude",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          description="longitude",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="status",
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
 * @property string $name
 * @property string|null $description
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_number
 * @property string|null $contact_fax
 * @property string $street
 * @property string|null $number
 * @property string|null $complement
 * @property string|null $neighborhood
 * @property string $country
 * @property string|null $state
 * @property string|null $city
 * @property string $postcode
 * @property int $priority
 * @property string|null $latitude
 * @property string|null $longitude
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductInventory[] $productInventories
 * @property-read int|null $product_inventories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shipment[] $shipments
 * @property-read int|null $shipments_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource newQuery()
 * @method static \Illuminate\Database\Query\Builder|InventorySource onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereContactFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InventorySource withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InventorySource withoutTrashed()
 * @mixin \Eloquent
 */
class InventorySource extends Model
{
    /**
     * @var string
     */
    public $table = 'inventory_sources';

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
        'status' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'contact_name' => 'required',
        'contact_email' => 'required',
        'contact_number' => 'required',
        'state' => 'required',
        'city' => 'required',
        'street' => 'required',
        'postcode' => 'required',
        'priority' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channel_inventory_sources');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productInventories()
    {
        return $this->hasMany(ProductInventory::class, 'inventory_source_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'inventory_source_id');
    }
}
