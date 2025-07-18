<?php

namespace Database\Factories;

use App\Models\Tenant\ShipmentItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ShipmentItem::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->word,
            'sku' => $this->faker->word,
            'qty' => $this->faker->randomDigitNotNull,
            'weight' => $this->faker->randomDigitNotNull,
            'price' => $this->faker->word,
            'base_price' => $this->faker->word,
            'total' => $this->faker->word,
            'base_total' => $this->faker->word,
            'product_id' => $this->faker->randomDigitNotNull,
            'product_type' => $this->faker->word,
            'order_item_id' => $this->faker->randomDigitNotNull,
            'shipment_id' => $this->faker->randomDigitNotNull,
            'additional' => $this->faker->text
        ];
    }
}
