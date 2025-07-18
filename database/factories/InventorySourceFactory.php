<?php

namespace Database\Factories;

use App\Models\Tenant\InventorySource;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventorySourceFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = InventorySource::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'contact_name' => $this->faker->word,
            'contact_email' => $this->faker->word,
            'contact_number' => $this->faker->word,
            'contact_fax' => $this->faker->word,
            'country' => $this->faker->word,
            'state' => $this->faker->word,
            'city' => $this->faker->word,
            'street' => $this->faker->word,
            'postcode' => $this->faker->word,
            'priority' => $this->faker->randomDigitNotNull,
            'latitude' => $this->faker->word,
            'longitude' => $this->faker->word,
            'status' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
