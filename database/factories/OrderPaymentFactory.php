<?php

namespace Database\Factories;

use App\Models\Tenant\OrderPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPaymentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderPayment::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'method' => $this->faker->word,
            'method_title' => $this->faker->word,
            'order_id' => $this->faker->randomDigitNotNull
        ];
    }
}
