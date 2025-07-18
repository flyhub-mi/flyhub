<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelCustomer
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelCustomer"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="local_id",
 *          description="local_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="remote_id",
 *          description="remote_id",
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
 * @property int $channel_id
 * @property int $customer_id
 * @property string|null $remote_customer_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant\Channel $channel
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereRemoteCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCustomer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelCustomer extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_customers';

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
        'local_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
