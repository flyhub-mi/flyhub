<?php

namespace Database\Factories;

use App\Models\Tenant\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = State::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'country_code' => $this->faker->word,
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'country_id' => $this->faker->randomDigitNotNull
        ];
    }
}
