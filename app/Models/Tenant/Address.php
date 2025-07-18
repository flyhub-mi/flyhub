<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderAddress
 *
 * @OA\Schema (
 *      @OA\Xml(name="OrderAddress"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
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
 *      ),
 *      @OA\Property(
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="customer_id",
 *          description="customer_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="address_type",
 *          description="address_type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="gender",
 *          description="gender",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="cpf_cnpj",
 *          description="cpf_cnpj",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="phone",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="street",
 *          description="street",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="number",
 *          description="number",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="country",
 *          description="country",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="postcode",
 *          description="postcode",
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
 *          property="metadata",
 *          description="metadata",
 *          type="string"
 *      )
 * )
 * @property int $id
 * @property string $name
 * @property string $street
 * @property string|null $number
 * @property string|null $complement
 * @property string|null $neighborhood
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $postcode
 * @property string $address_type
 * @property int $order_id
 * @property int|null $customer_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shipment[] $shipments
 * @property-read int|null $shipments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreet($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    /**
     * @var string
     */
    public $table = 'addresses';

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
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
