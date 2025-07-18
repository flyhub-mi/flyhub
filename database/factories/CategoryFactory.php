<?php

namespace Database\Factories;

use App\Models\Tenant\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->word,
            'description' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            '_lft' => $this->faker->randomDigitNotNull,
            '_rgt' => $this->faker->randomDigitNotNull,
            'parent_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
