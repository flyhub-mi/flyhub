<?php

namespace Database\Factories;

use App\Models\Tenant\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Tax::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => $this->faker->word,
            'is_zip' => $this->faker->word,
            'zip_code' => $this->faker->word,
            'zip_from' => $this->faker->word,
            'zip_to' => $this->faker->word,
            'state' => $this->faker->word,
            'state_from' => $this->faker->word,
            'state_to' => $this->faker->word,
            'country' => $this->faker->word,
            'tax_rate' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
