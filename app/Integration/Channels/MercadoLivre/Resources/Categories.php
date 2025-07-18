<?php

namespace App\Integration\Channels\MercadoLivre\Resources;

use App\Integration\Channels\MercadoLivre\Api;
use Dsc\MercadoLivre\Requests\Category\Attribute;
use Dsc\MercadoLivre\Requests\Category\AttributeValue;

class Categories
{
    protected $api;

    /**
     * Categories constructor.
     */
    public function __construct()
    {
        $this->api = new Api();
    }

    /**
     * @param null $categoryId
     * @return \Illuminate\Support\Collection
     */
    public function getAll($categoryId = null)
    {
        $categories = $categoryId
            ? $this->api->getCategoryChildrens($categoryId)
            : $this->api->getCategories();

        return collect($categories->map(fn ($item) => ['id' => $item->getId(), 'name' => $item->getName()]));
    }

    /**
     * @param string $categoryId
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryAttributes($categoryId)
    {
        return collect(
            $this->service
                ->findCategoryAttributes($categoryId)
                ->map(fn (Attribute $item) => [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'type' => $item->getValueType(),
                    'required' => $item->getTags()->isRequired(),
                    'readOnly' => $item->getTags()->isReadOnly(),
                    'multiple' => $item->getTags()->isMultivalued(),
                    'allowVariations' => $item->getTags()->isAllowVariations(),
                    'variationAttribute' => $item->getTags()->isVariationAttribute(),
                    'values' => empty($item->getValues())
                        ? []
                        : array_map(function (AttributeValue $value) {
                            return ['name' => $value->getName(), 'value' => $value->getId()];
                        }, $item->getValues()->toArray()),
                ]),
        );
    }
}
