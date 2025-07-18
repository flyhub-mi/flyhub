<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
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
            'state' => $this->faker->word,
            'email_sent' => $this->faker->word,
            'total_qty' => $this->faker->randomDigitNotNull,
            'sub_total' => $this->faker->word,
            'base_sub_total' => $this->faker->word,
            'grand_total' => $this->faker->word,
            'base_grand_total' => $this->faker->word,
            'shipping_amount' => $this->faker->word,
            'base_shipping_amount' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'base_tax_amount' => $this->faker->word,
            'discount_amount' => $this->faker->word,
            'base_discount_amount' => $this->faker->word,
            'order_id' => $this->faker->randomDigitNotNull,
            'transaction_id' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
