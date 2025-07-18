<?php

namespace Database\Factories;

use App\Models\Tenant\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->word,
            'is_subscribed' => $this->faker->word,
            'token' => $this->faker->word,
            'channel_id' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
