<?php

namespace App\Repositories\Tenant;

use App\FlyHub;
use function _\get;
use InvalidArgumentException;
use App\Models\Tenant\Product;
use App\Models\Tenant\Category;
use App\Repositories\BaseRepository;
use App\Models\Tenant\InventorySource;
use App\Models\Tenant\ProductInventory;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToCheckExistence;
use Throwable;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'short_description',
        'new',
        'status',
        'price',
        'cost',
        'special_price',
        'special_price_from',
        'special_price_to',
        'gross_weight',
        'net_weight',
        'unit',
        'color',
        'size',
        'channels',
        'width',
        'height',
        'depth',
        'min_price',
        'max_price',
        'parent_id',
        'attribute_set_id',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection<mixed, Builder>|Builder|null
     * @throws InvalidArgumentException
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model
            ::with(['variations', 'variations.images', 'inventories', 'images', 'channels', 'attributes'])
            ->find($id, $columns);
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        return $this->updateOrCreate(
            [
                'sku' => $input['sku'],
            ],
            $input,
        );
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        return $this->updateOrCreate(['id' => $id], $input);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate($attributes, $values = [])
    {
        try {
            $values = $this->prepareValues($values);

            if (is_int(get($attributes, 'id'))) {
                $product = $this->model::findOrFail($attributes['id']);
                $product->update($values);
            } else {
                $product = $this->model::updateOrCreate($attributes, $values);
            }

            $this->saveProductRelations($product, $values);

            $thumbnail = get($values, 'thumbnail', '');
            if (!empty($thumbnail)) {
                $values['thumbnail'] = $this->storeImageOnS3($thumbnail, $product->id);
            } else {
                $image = $product->images()->first();

                if (!is_null($image)) {
                    $values['thumbnail'] = $image->url;
                    $product->update($values);
                }
            }

            return $product;
        } catch (\Exception $e) {
            FlyHub::notifyExceptionWithMetaData($e, [$values], true);
        } catch (\Throwable $e) {
            FlyHub::notifyExceptionWithMetaData($e, [$values], true);
        }
    }

    private function prepareValues($values = [])
    {
        if (isset($values['status']) && !is_bool($values['status'])) {
            $values['status'] = boolval($values['status']);
        }

        if (isset($values['new']) && !is_bool($values['new'])) {
            $values['new'] = boolval($values['new']);
        }

        $values = array_merge([
            'new' => true,
        ], $values);

        return $values;
    }

    /**
     * @param Product $product
     * @param array $values
     * @return mixed
     * @throws InvalidArgumentException
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     * @throws Throwable
     */
    private function saveProductRelations($product, $values)
    {
        if (isset($values['stock_quantity'])) {
            $this->updateOrCreateStock($product, $values['stock_quantity']);
        }

        $images = get($values, 'product_images') ?: get($values, 'images') ?: [];
        if (count($images) > 0) {
            $this->saveProductImages($images, $product);
        }

        $this->syncCategories($product, $values);

        foreach (get($values, 'variations', []) as $variation) {
            $variation['parent_id'] = $product->id;

            if (is_int(get($variation, 'id'))) {
                $this->update($variation['id'], $variation);
            } else {
                $this->updateOrCreate(['sku' => $variation['sku']], $variation);
            }
        }

        return $product;
    }

    private function saveProductImages($productImages, $product)
    {
        foreach ($productImages as $image) {
            if (isset($image['path']) && !empty($image['path'])) {
                $product->images()->updateOrCreate([
                    'path' => $this->storeImageOnS3($image['path'], $product->id),
                    'channel_id' => get($image, 'channel_id'),
                    'product_id' => $product->id,
                ]);
            }
        }
    }

    /**
     * @param Product $product
     * @param array $values
     * @return void
     */
    private function syncCategories($product, $values)
    {
        $caegoryIds = [];
        foreach (get($values, 'categories', []) as $cat) {
            $category = null;

            if (isset($cat['id'])) {
                $category = Category::find($cat['id']);
            }

            if (is_null($category) && !empty($cat['name'])) {
                $category = Category::whereRaw("LOWER(name) LIKE LOWER(?)", $cat['name'])->first();
            }

            if (is_null($category) && !empty($cat['name'])) {
                $category = Category::create($cat);
            }

            if (!is_null($category)) {
                $caegoryIds[] = $category->id;
            }
        }

        $product->categories()->sync($caegoryIds);
    }

    /**
     * @param $product
     * @param $stockQuantity
     */
    private function updateOrCreateStock($product, $stockQuantity)
    {
        if ($product->stock_quantity != intval($stockQuantity)) {
            ProductInventory::create([
                'qty' => $stockQuantity - $product->stock_quantity,
                'product_id' => $product->id,
                'inventory_source_id' => InventorySource::first()->id,
            ]);
        }
    }

    /**
     * @param mixed $image
     * @param mixed $productId
     * @return string
     * @throws InvalidArgumentException
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     * @throws Exception
     * @throws Throwable
     */
    private function storeImageOnS3($image, $productId)
    {
        $filename = basename($image);
        $path = "images/products/{$productId}/{$filename}";

        if (!Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->put($path, file_get_contents($image), 'public');
        }

        return $path;
    }
}
