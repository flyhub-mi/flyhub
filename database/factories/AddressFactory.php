<?php

namespace Database\Factories;

use App\Models\Tenant\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Address::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'order_id' => OrderFactory::factory(),
            'customer_id' => CustomerFactory::factory(),
            'address_type' => 'shipping',
            'name' => $this->faker->word,
            'gender' => $this->faker->word,
            'cpf_cnpj' => $this->faker->word,
            'email' => $this->faker->word,
            'phone' => $this->faker->word,
            'street' => $this->faker->word,
            'number' => $this->faker->word,
            'complement' => $this->faker->word,
            'neighborhood' => $this->faker->word,
            'country' => $this->faker->word,
            'postcode' => $this->faker->word,
            'state' => $this->faker->word,
            'city' => $this->faker->word,
            'metadata' => $this->faker->word,
        ];
    }
}
