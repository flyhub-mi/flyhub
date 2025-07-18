<?php

namespace App\Integration\Channels\MercadoLivre\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\MercadoLivre\Api;
use App\Integration\Mapping\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Dsc\MercadoLivre\Announcement\Item;
use Dsc\MercadoLivre\Announcement\Picture;
use Dsc\MercadoLivre\Requests\Category\Attribute;
use Dsc\MercadoLivre\Requests\Category\AttributeCombination;
use Dsc\MercadoLivre\Requests\Product\Variation;
use InvalidArgumentException;

use function _\get;

class Products extends ChannelResource
{
    protected $api;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'products');

        $this->api = new Api($channel);
    }

    /**
     * @param array $localProduct
     * @return array
     */
    public function send($localProduct)
    {
        $channelProduct = $this->channel->channelProducts()->where('product_id', $localProduct['id'])->first();

        $result = is_null($channelProduct)
            ? $this->api->createAnnouncement($this->createItem($localProduct))
            : $this->api->updateAnnouncement($channelProduct->remote_product_id, [
                'available_quantity' => $localProduct['stock_quantity'],
                'price' => $localProduct['price'],
            ]);

        $this->channel->channelProducts()->updateOrCreate(['product_id' => $localProduct['id']], [
            'remote_id' => $result->getId(),
            'remote_link' => $result->getPermalink(),
            'remote_category_id' => $result->getCategoryId(),
        ]);

        $this->channel->configs()->updateOrCreate(['code' => 'seller_id'], ['value' => $result->getSellerId()]);

        return Utils::objectToArray($result);
    }

    /**
     * @param array $product
     * @return Item
     * @throws \Exception
     */
    private function createItem($product)
    {
        $remoteCategoryId = $this->findChannelProductRemoteCategoryId($product);
        $categoryAttributes = $this->api->getCategoryAttributes($remoteCategoryId);
        $configurableAttrCodes = ['SIZE', 'COLOR'];
        $mainProductAttributes = $this->mainProductAttributes($product, $categoryAttributes, $configurableAttrCodes);

        $item = new Item();
        $item->setTitle($product['name']);
        $item->setCategoryId($remoteCategoryId);
        $item->setPrice($product['price']);
        $item->setCurrencyId('BRL');
        $item->setAvailableQuantity($product['stock_quantity']);
        $item->setBuyingMode(get($this->configs, 'buying_mode'));
        $item->setListingTypeId(get($this->configs, 'listing_type'));
        $item->setCondition('new');
        $item->setDescription($product['description']);
        $item->setAttributes($mainProductAttributes);

        foreach (get($product, 'images', []) as $image) {
            $item->addPicture((new Picture())->setSource($image['url']));
        }

        foreach (get($product, 'remoteVariations', []) as $remoteVariation) {
            $variation = $this->buildVariation($remoteVariation, $product['images'], $categoryAttributes, $configurableAttrCodes);
            $item->addVariation($variation);
        }

        return $item;
    }

    /**
     * @param array $productAttributes
     * @param $attributeId
     * @return mixed|null
     */
    private function getAttributeValue($productAttributes, $attributeId)
    {
        foreach ($productAttributes as $attribute) {
            if ($attribute['code'] == $attributeId) {
                return $attribute['value'];
            }
        }

        return null;
    }

    /**
     * @param $attributes
     * @param bool $haveVariations
     * @return mixed
     */
    private function mainProductAttributes($product, $categoryAttributes, $configurableAttrCodes)
    {
        $attributes = $this->mapProductAttributes($product, $categoryAttributes);
        $haveVariations = count($product['remoteVariations']) > 0;

        return $attributes->filter(
            fn ($attr) => $haveVariations || $this->isVariableProductAttribute($attr, $configurableAttrCodes)
        );
    }

    /**
     * @param Attribute $attribute
     * @param array $codes
     * @return bool
     */
    private function isVariableProductAttribute(Attribute $attribute, $codes)
    {
        $notVariationAttribute = !$attribute->getTags()->isVariationAttribute();
        $notReadOnly = $attribute->getTags()->isReadOnly();

        return $notVariationAttribute && $notReadOnly && in_array($attribute->getId(), $codes);
    }

    /**
     * @param array $localVariation
     * @param array $mainImages
     * @param $categoryAttributes
     * @return Variation
     */
    private function buildVariation($localVariation, $mainImages, $categoryAttributes, $configurableAttrCodes)
    {
        $result = new Variation();
        $result->setPrice($localVariation['price']);
        $result->setAvailableQuantity($localVariation['stock_quantity']);
        $result->setPictureIds($this->getVariationImages($localVariation, $mainImages));
        $result->addAttributeCombination($this->buildAttributeCombination('SIZE', $localVariation['size']));
        $result->addAttributeCombination($this->buildAttributeCombination('COLOR', $localVariation['color']));
        $result->setAttributes($this->variationAttributes($localVariation, $categoryAttributes, $configurableAttrCodes));

        return $result;
    }

    /**
     * @param array $localVariation
     * @param array $mainImages
     * @return mixed
     */
    private function getVariationImages($localVariation, $mainImages)
    {
        $variationHasImages = !empty($localVariation['images']);
        $images = $variationHasImages ? $mainImages : $localVariation['images'];

        return array_map(fn ($image) => $image['url'], $images);
    }

    /**
     * @param string $code
     * @param string $value
     * @return AttributeCombination
     */
    private function buildAttributeCombination($code,  $value)
    {
        return (new AttributeCombination())->setId($code)->setValueName($value);
    }

    /**
     * @param array $localVariation
     * @param Collection $categoryAttributes
     * @param array $codes
     * @return ArrayCollection
     * @throws InvalidArgumentException
     */
    private function variationAttributes($localVariation, Collection $categoryAttributes, $codes)
    {
        return $this->mapProductAttributes($localVariation['id'], $categoryAttributes)
            ->map(fn ($attribute) => $this->isVariationAttribute($attribute, $codes) ? $attribute : null)
            ->filter(fn ($item) => !is_null($item));
    }

    /**
     * @param Attribute $attribute
     * @param array $codes
     * @return bool
     */
    private function isVariationAttribute(Attribute $attribute, $codes)
    {
        $notMainProductAttribute = !(in_array($attribute->getId(), $codes) || $attribute->getTags()->isAllowVariations());
        $isVariationAttribute = $attribute->getTags()->isAllowVariations();
        $isValidAttribute = !empty($attribute->getValueId()) && !empty($attribute->getValueName());

        return $notMainProductAttribute && $isVariationAttribute && $isValidAttribute;
    }

    /**
     * @param $product
     * @param $attributes
     * @return ArrayCollection
     */
    private function mapProductAttributes($productId, Collection $categoryAttributes)
    {
        $productAttributes = $this->getProductAttributes($productId);

        return $categoryAttributes
            ->map(function (Attribute $attribute) use ($productAttributes) {
                $item = clone $attribute;
                $value = $this->getAttributeValue($productAttributes, $item->getId());

                if (is_null($value)) return null;

                if ($item->getValueType() == 'list') {
                    $item->setValueId($value);
                } elseif ($item->getId() == 'SIZE') {
                    // TODO map channel attributes to build this dynamic
                    $item->setValueName($this->getAttributeValue($productAttributes, 'PANT_SIZE'));
                } else {
                    $item->setValueName($value);
                }

                return $item;
            })
            ->filter(fn ($item) => !is_null($item));
    }
}
