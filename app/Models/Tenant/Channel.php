<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Log;

use function _\get;

/**
 * App\Models\Channel
 *
 * @OA\Schema (
 *      @OA\Xml(name="Channel"),
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
 *          property="timezone",
 *          description="timezone",
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
 * @property string $code
 * @property string $name
 * @property string|null $last_send_at
 * @property string|null $last_received_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelCustomer[] $channelCustomers
 * @property-read int|null $channel_customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelOrder[] $channelOrders
 * @property-read int|null $channel_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelProduct[] $channelProducts
 * @property-read int|null $channel_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelConfig[] $configs
 * @property-read int|null $configs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventorySource[] $inventorySources
 * @property-read int|null $inventory_sources_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newQuery()
 * @method static \Illuminate\Database\Query\Builder|Channel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereLastReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereLastSendAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Channel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Channel withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant\ChannelCategory> $channelCategories
 * @property-read int|null $channel_categories_count
 * @mixin \Eloquent
 */
class Channel extends Model
{
    /**
     * @var string
     */
    public $table = 'channels';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    public static $rules = [];

    /**
     * @var array
     */
    private $configList;

    public function getConfigs()
    {
        if (!isset($this->configList) || is_null($this->configList) || count($this->configList) === 0) {
            $this->configList = $this->configs()
                ->pluck('value', 'code')
                ->toArray();
        }

        return $this->configList;
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getConfig($code)
    {
        $configs = $this->getConfigs();

        return get($configs, strtolower($code));
    }

    /**
     * @param string $code
     * @param mixed $value
     * @return mixed
     */
    public function setConfig($code, $value)
    {
        return $this->configs()->updateOrCreate(
            ['code' => strtolower($code)],
            ['value' => $value]
        );
    }

    /**
     * @param mixed $action
     * @param mixed $model
     * @return bool
     */
    public function can($action, $model)
    {
        $code = strtolower(implode('_', [$model, $action]));
        $config = $this->getConfig($code);

        return boolval($config);
    }

    /**
     * @param null|string $format
     * @return null|string
     */
    public function getLastReceivedAt(string $resource, $format = 'Y-m-d H:i:s')
    {
        $resourceLastReceivedAt = $this->getConfig($resource . '_last_received_at');

        if (empty($resourceLastReceivedAt)) {
            return null;
        }

        return date($format, strtotime($resourceLastReceivedAt));
    }

    /**
     * @param null|string $format
     * @param string|datetime|Carbon $datetime
     * @return void
     */
    public function setLastReceivedAt(string $resource, $datetime)
    {
        $code = $resource . '_last_received_at';
        $currrentDateTime = $this->getConfig($code);
        $newDateTime = Carbon::parse($datetime);

        if (Carbon::parse($currrentDateTime)->lt($newDateTime)) {
            $this->setConfig($code, $newDateTime);
        }
    }

    /**
     * @param null|string $format
     * @return null|string
     */
    public function getLastSendAt(string $resource, $format = 'Y-m-d H:i:s')
    {
        $resourceLastReceivedAt = $this->getConfig($resource . '_last_send_at');

        if (empty($resourceLastReceivedAt)) {
            return null;
        }

        return date($format, strtotime($resourceLastReceivedAt));
    }

    /**
     * @param null|string $format
     * @param string|datetime|Carbon $datetime
     * @return void
     */
    public function setLastSendAt(string $resource, $datetime)
    {
        $code = $resource . '_last_send_at';
        $currrentDateTime = $this->getConfig($code);
        $newDateTime = Carbon::parse($datetime);

        if (Carbon::parse($currrentDateTime)->lt($newDateTime)) {
            $this->setConfig($code, $newDateTime);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelCategories()
    {
        return $this->hasMany(ChannelCategory::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelOrders()
    {
        return $this->hasMany(ChannelOrder::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelProducts()
    {
        return $this->hasMany(ChannelProduct::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelCustomers()
    {
        return $this->hasMany(ChannelCustomer::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function configs()
    {
        return $this->hasMany(ChannelConfig::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventorySources()
    {
        return $this->belongsToMany(InventorySource::class, 'channel_inventory_sources');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'channel_id');
    }
}
