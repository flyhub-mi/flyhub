<?php

namespace App\Integration\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Tenant\CategoryRepository;
use App\Models\Channel;
use App\FlyHub;
use App\Models\Tenant\Category;

class Categories extends Base
{
    /**
     * @param array $mappedItems
     * @param int $tenantId
     * @param \App\Models\Tenant\Channel $channel
     * @return array
     * @throws \Throwable
     */
    public function save($channel, $mappedItems = [])
    {
        $results = [];
        $repository = new CategoryRepository();

        foreach ($mappedItems as $values) {
            try {
                $category = $repository->updateOrCreate([
                    'name' => $values['name'],
                ], $values);

                if (isset($values['remote_id'])) {
                    $this->saveChannelCategory($channel, $values['remote_id'], $category->id);
                }

                $results[] = $this->getData($category);

                $this->saveChannelCategory($channel, $category);
            } catch (\Exception $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);
                $results[] = $e->getMessage();
            } catch (\Throwable $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);
                $results[] = $e->getMessage();
            }
        }

        return $results;
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function canSend($channel, $model)
    {
        return $channel->can('send', 'categories');
    }

    /**
     * @param Model $resource
     * @return array
     */
    public function getData($model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'remote_id' => $model->remote_id,
        ];
    }

    /**
     * @param Model|Channel $channel
     * @return array
     */
    public function itemsToSend($channel)
    {
        $rootCategory = Category::whereNull('parent_id')->first();

        return $rootCategory->children()->get(['id'])->toArray();
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \App\Models\Tenant\Category $category
     * @param array $values
     * @return void
     */
    private function saveChannelCategory($channel, $category)
    {
        if(!isset($category->children)) {
            return;
        }

        foreach ($category->children as $childCategory) {
            $attributes = [
                'channel_id' => $channel->id,
                'category_id' => $childCategory->id,
            ];
            $values = array_merge($attributes, [
                'remote_category_id' => $childCategory->remote_id,
                'remote_category_name' => $childCategory->name,
            ]);

            $channel->channelCategories()->updateOrCreate(
                $attributes,
                $values
            );

            $this->saveChannelCategory($channel, $childCategory);
        }
    }
}
