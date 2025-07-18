<?php

namespace Database\Factories;

use App\Models\Tenant\AttributeSet;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeSetFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = AttributeSet::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'status' => $this->faker->word,
            'is_user_defined' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
