<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @OA\Schema (
 *      @OA\Xml(name="Product"),
 *      required={""},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="sku",
 *          description="sku",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="type",
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
 *          property="short_description",
 *          description="short_description",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="new",
 *          description="new",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="status",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="thumbnail",
 *          description="thumbnail",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="cost",
 *          description="cost",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="special_price",
 *          description="special_price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="special_price_from",
 *          description="special_price_from",
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="special_price_to",
 *          description="special_price_to",
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="gross_weight",
 *          description="gross_weight",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="net_weight",
 *          description="net_weight",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="unit",
 *          description="unit",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="color",
 *          description="color",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="size",
 *          description="size",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="brand",
 *          description="brand",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="channels",
 *          description="channels",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="remote_id",
 *          description="remote_id",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="width",
 *          description="width",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="height",
 *          description="height",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="depth",
 *          description="depth",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="min_price",
 *          description="min_price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="max_price",
 *          description="max_price",
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="ncm",
 *          description="ncm",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="gtin",
 *          description="gtin",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="mpm",
 *          description="mpm",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="parent_id",
 *          description="parent_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="main_category_id",
 *          description="main_category_id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="attribute_set_id",
 *          description="attribute_set_id",
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
 *      )
 * )
 * @property int $id
 * @property string $sku
 * @property string|null $name
 * @property string|null $description
 * @property string|null $short_description
 * @property bool|null $new
 * @property string|null $status
 * @property string|null $thumbnail
 * @property float|null $price
 * @property string|null $cost
 * @property string|null $special_price
 * @property string|null $special_price_from
 * @property string|null $special_price_to
 * @property string|null $gross_weight
 * @property string|null $net_weight
 * @property string|null $unit
 * @property string|null $color
 * @property string|null $size
 * @property string|null $brand
 * @property string|null $channels
 * @property string|null $remote_id
 * @property string|null $width
 * @property string|null $height
 * @property string|null $depth
 * @property string|null $min_price
 * @property string|null $max_price
 * @property string|null $ncm
 * @property string|null $gtin
 * @property string|null $mpn
 * @property int|null $parent_id
 * @property int|null $main_category_id
 * @property int|null $attribute_set_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property-read \App\Models\AttributeSet|null $attributeSet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $attributes
 * @property-read int|null $attribute_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Tenant\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\ChannelProduct[] $channels
 * @property-read int|null $channels_count
 * @property-read float $stock_quantity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductInventory[] $inventories
 * @property-read int|null $inventories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductOrderedInventory[] $orderedInventories
 * @property-read int|null $ordered_inventories_count
 * @property-read Product|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaxGroup[] $taxes
 * @property-read int|null $taxes_count
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $variations
 * @property-read int|null $variations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActiveChannels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributeSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGrossWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGtin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNcm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPriceFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPriceTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant\TaxGroup> $taxGroups
 * @property-read int|null $tax_groups_count
 * @mixin \Eloquent
 */
class Product extends Model
{
    /**
     * @var string
     */
    public $table = 'products';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'new' => 'boolean',
        'price' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sku' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['stock_quantity'];

    /**
     * @return float
     */
    public function getStockQuantityAttribute()
    {
        return $this->inventories()->sum('qty') ?: 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeSet()
    {
        return $this->belongsTo(AttributeSet::class, 'attribute_set_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasMany(ChannelProduct::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany(ProductInventory::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderedInventories()
    {
        return $this->hasMany(ProductOrderedInventory::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxGroups()
    {
        return $this->hasMany(TaxGroup::class, 'product_id');
    }
}
