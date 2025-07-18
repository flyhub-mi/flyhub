<?php

namespace Database\Factories;

use App\Models\Tenant\TaxGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxGroupFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = TaxGroup::class;

    /**
     * @return array
     */
    public function definition()
    {

        return [
            'channel_id' => $this->faker->randomDigitNotNull,
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
