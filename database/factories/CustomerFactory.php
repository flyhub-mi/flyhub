<?php

namespace Database\Factories;

use App\Models\Tenant\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Customer::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'channel_id' => $this->faker->randomDigitNotNull,
            'name' => $this->faker->word,
            'gender' => $this->faker->word,
            'birthdate' => $this->faker->date(),
            'email' => $this->faker->word,
            'status' => $this->faker->word,
            'customer_group_id' => $this->faker->randomDigitNotNull,
            'subscribed_to_news_letter' => $this->faker->word,
            'phone' => $this->faker->word,
            'notes' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
