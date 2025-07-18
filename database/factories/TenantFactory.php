<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'company' => $this->faker->word,
            'cnpj' => $this->faker->word,
            'cpf' => $this->faker->word,
            'email' => $this->faker->word,
            'ie' => $this->faker->word,
            'logo' => $this->faker->word,
            'address1' => $this->faker->word,
            'address2' => $this->faker->word,
            'country' => $this->faker->word,
            'state' => $this->faker->word,
            'city' => $this->faker->word,
            'postcode' => $this->faker->word,
            'phone' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
