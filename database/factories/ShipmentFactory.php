<?php

namespace Database\Factories;

use App\Models\Tenant\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
            'total_qty' => $this->faker->randomDigitNotNull,
            'total_weight' => $this->faker->randomDigitNotNull,
            'carrier_code' => $this->faker->word,
            'carrier_title' => $this->faker->word,
            'track_number' => $this->faker->text,
            'email_sent' => $this->faker->word,
            'customer_id' => $this->faker->randomDigitNotNull,
            'customer_type' => $this->faker->word,
            'order_id' => $this->faker->randomDigitNotNull,
            'inventory_source_id' => $this->faker->randomDigitNotNull
        ];
    }
}
