<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'weight' => $this->faker->randomFloat(2, 0.1, 1000),
            'description' => $this->faker->text,
        ];
    }
}
