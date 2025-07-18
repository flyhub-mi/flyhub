<?php

namespace Database\Factories;

use App\Models\Tenant\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
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
            'code' => $this->faker->word,
            'name' => $this->faker->name,
            'type' => $this->faker->word,
            'validation' => $this->faker->word,
            'position' => $this->faker->randomDigitNotNull,
            'is_required' => $this->faker->word,
            'is_unique' => $this->faker->word,
            'value_per_channel' => $this->faker->word,
            'is_filterable' => $this->faker->word,
            'is_configurable' => $this->faker->word,
            'is_user_defined' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
