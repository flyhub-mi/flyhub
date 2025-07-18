<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelCategory
 *
 * @OA\Schema (
 *      @OA\Xml(name="ChannelCategory"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="category_id",
 *          description="local_category_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="remote_category_id",
 *          description="remote_category_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="remote_category_name",
 *          description="remote_category_name",
 *          type="string",
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
 * @property int $category_id
 * @property string $remote_category_id
 * @property string $remote_category_name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant\Category $localCategory
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereChannelCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereChannelCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategory whereUpdatedAt($value)
 * @property-read \App\Models\Tenant\Category|null $category
 * @property-read \App\Models\Tenant\Channel|null $channel
 * @mixin \Eloquent
 */
class ChannelCategory extends Model
{
    /**
     * @var string
     */
    public $table = 'channel_categories';

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
        'channel_id' => 'required',
        'category_id' => 'required',
        'remote_category_id' => 'required',
        'remote_category_name' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'channel_id');
    }
}
