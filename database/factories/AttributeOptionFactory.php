<?php

namespace Database\Factories;

use App\Models\Tenant\AttributeOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeOptionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = AttributeOption::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'sort_order' => $this->faker->randomDigitNotNull,
            'attribute_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
