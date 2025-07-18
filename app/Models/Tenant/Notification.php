<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notification
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    /**
     * @var string
     */
    public $table = 'notifications';

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * @param string $type
     * @return string
     */
    public function getNotificationTypeName($type)
    {
        $name = '';

        if ($type === 'orders') {
            $name = 'Pedido';
        } elseif ($type === 'products') {
            $name = 'Produto';
        }

        return $name;
    }

    /**
     * Mark notifications as read with current time
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
}
