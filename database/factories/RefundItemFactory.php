<?php

namespace Database\Factories;

use App\Models\Tenant\RefundItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = RefundItem::class;

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
            'price' => $this->faker->word,
            'base_price' => $this->faker->word,
            'total' => $this->faker->word,
            'base_total' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'base_tax_amount' => $this->faker->word,
            'discount_percent' => $this->faker->word,
            'discount_amount' => $this->faker->word,
            'base_discount_amount' => $this->faker->word,
            'product_id' => $this->faker->randomDigitNotNull,
            'product_type' => $this->faker->word,
            'order_item_id' => $this->faker->randomDigitNotNull,
            'refund_id' => $this->faker->randomDigitNotNull,
            'parent_id' => $this->faker->randomDigitNotNull,
            'additional' => $this->faker->text
        ];
    }
}
