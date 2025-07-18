<?php

namespace Database\Factories;

use App\Models\Tenant\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->word,
            'type' => $this->faker->word,
            'name' => $this->faker->word,
            'coupon_code' => $this->faker->word,
            'weight' => $this->faker->word,
            'total_weight' => $this->faker->word,
            'qty_ordered' => $this->faker->randomDigitNotNull,
            'qty_shipped' => $this->faker->randomDigitNotNull,
            'qty_invoiced' => $this->faker->randomDigitNotNull,
            'qty_canceled' => $this->faker->randomDigitNotNull,
            'qty_refunded' => $this->faker->randomDigitNotNull,
            'price' => $this->faker->word,
            'base_price' => $this->faker->word,
            'total' => $this->faker->word,
            'base_total' => $this->faker->word,
            'total_invoiced' => $this->faker->word,
            'base_total_invoiced' => $this->faker->word,
            'amount_refunded' => $this->faker->word,
            'base_amount_refunded' => $this->faker->word,
            'discount_percent' => $this->faker->word,
            'discount_amount' => $this->faker->word,
            'base_discount_amount' => $this->faker->word,
            'discount_invoiced' => $this->faker->word,
            'base_discount_invoiced' => $this->faker->word,
            'discount_refunded' => $this->faker->word,
            'base_discount_refunded' => $this->faker->word,
            'tax_percent' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'base_tax_amount' => $this->faker->word,
            'tax_amount_invoiced' => $this->faker->word,
            'base_tax_amount_invoiced' => $this->faker->word,
            'tax_amount_refunded' => $this->faker->word,
            'base_tax_amount_refunded' => $this->faker->word,
            'product_id' => $this->faker->randomDigitNotNull,
            'product_type' => $this->faker->word,
            'order_id' => $this->faker->randomDigitNotNull,
            'parent_id' => $this->faker->randomDigitNotNull,
            'additional' => $this->faker->text
        ];
    }
}
