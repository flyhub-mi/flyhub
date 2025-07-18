<?php

namespace Database\Factories;

use App\Models\Tenant\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
            'channel_name' => $this->faker->word,
            'is_guest' => $this->faker->word,
            'customer_email' => $this->faker->word,
            'customer_name' => $this->faker->word,
            'shipping_method' => $this->faker->word,
            'shipping_description' => $this->faker->word,
            'coupon_code' => $this->faker->word,
            'is_gift' => $this->faker->word,
            'total_item_count' => $this->faker->randomDigitNotNull,
            'total_qty_ordered' => $this->faker->randomDigitNotNull,
            'grand_total' => $this->faker->word,
            'base_grand_total' => $this->faker->word,
            'grand_total_invoiced' => $this->faker->word,
            'base_grand_total_invoiced' => $this->faker->word,
            'grand_total_refunded' => $this->faker->word,
            'base_grand_total_refunded' => $this->faker->word,
            'sub_total' => $this->faker->word,
            'base_sub_total' => $this->faker->word,
            'sub_total_invoiced' => $this->faker->word,
            'base_sub_total_invoiced' => $this->faker->word,
            'sub_total_refunded' => $this->faker->word,
            'base_sub_total_refunded' => $this->faker->word,
            'discount_percent' => $this->faker->word,
            'discount_amount' => $this->faker->word,
            'base_discount_amount' => $this->faker->word,
            'discount_invoiced' => $this->faker->word,
            'base_discount_invoiced' => $this->faker->word,
            'discount_refunded' => $this->faker->word,
            'base_discount_refunded' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'base_tax_amount' => $this->faker->word,
            'tax_amount_invoiced' => $this->faker->word,
            'base_tax_amount_invoiced' => $this->faker->word,
            'tax_amount_refunded' => $this->faker->word,
            'base_tax_amount_refunded' => $this->faker->word,
            'shipping_amount' => $this->faker->word,
            'base_shipping_amount' => $this->faker->word,
            'shipping_invoiced' => $this->faker->word,
            'base_shipping_invoiced' => $this->faker->word,
            'shipping_refunded' => $this->faker->word,
            'base_shipping_refunded' => $this->faker->word,
            'customer_id' => $this->faker->randomDigitNotNull,
            'customer_type' => $this->faker->word,
            'channel_id' => $this->faker->randomDigitNotNull,
            'channel_type' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
