<?php

namespace Database\Factories;

use App\Models\Tenant\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->word,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'url_key' => $this->faker->word,
            'new' => $this->faker->word,
            'status' => $this->faker->word,
            'thumbnail' => $this->faker->word,
            'price' => $this->faker->word,
            'cost' => $this->faker->word,
            'special_price' => $this->faker->word,
            'special_price_from' => $this->faker->word,
            'special_price_to' => $this->faker->word,
            'gross_weight' => 1,
            'net_weight' => 1,
            'unit' => $this->faker->word,
            'color' => $this->faker->colorName,
            'size' => $this->faker->word,
            'channel' => $this->faker->word,
            'short_description' => $this->faker->text,
            'meta_title' => $this->faker->text,
            'meta_keywords' => $this->faker->text,
            'meta_description' => $this->faker->text,
            'width' => $this->faker->word,
            'height' => $this->faker->word,
            'depth' => $this->faker->word,
            'min_price' => $this->faker->word,
            'max_price' => $this->faker->word,
            'visible_individually' => $this->faker->word,
            'parent_id' => $this->faker->randomDigitNotNull,
            'attribute_set_id' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
