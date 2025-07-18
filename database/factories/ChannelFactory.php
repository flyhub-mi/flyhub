<?php

namespace Database\Factories;

use App\Models\Tenant\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Channel::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'timezone' => $this->faker->word,
            'hostname' => $this->faker->word,
            'logo' => $this->faker->word,
            'favicon' => $this->faker->word,
            'root_category_id' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
