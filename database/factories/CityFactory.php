<?php

namespace Database\Factories;

use App\Models\Tenant\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = City::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->word
        ];
    }
}
