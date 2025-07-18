<?php

namespace Database\Factories;

use App\Models\Tenant\Refund;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Refund::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'state' => $this->faker->word,
            'email_sent' => $this->faker->word,
            'total_qty' => $this->faker->randomDigitNotNull,
            'adjustment_refund' => $this->faker->word,
            'base_adjustment_refund' => $this->faker->word,
            'adjustment_fee' => $this->faker->word,
            'base_adjustment_fee' => $this->faker->word,
            'sub_total' => $this->faker->word,
            'base_sub_total' => $this->faker->word,
            'grand_total' => $this->faker->word,
            'base_grand_total' => $this->faker->word,
            'shipping_amount' => $this->faker->word,
            'base_shipping_amount' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'base_tax_amount' => $this->faker->word,
            'discount_percent' => $this->faker->word,
            'discount_amount' => $this->faker->word,
            'base_discount_amount' => $this->faker->word,
            'order_id' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
