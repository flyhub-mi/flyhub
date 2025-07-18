<?php

namespace Database\Factories;

use App\Models\Tenant\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ProductAttribute::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'channel' => $this->faker->word,
            'value' => $this->faker->text,
            'product_id' => $this->faker->randomDigitNotNull,
            'attribute_id' => $this->faker->randomDigitNotNull
        ];
    }
}
