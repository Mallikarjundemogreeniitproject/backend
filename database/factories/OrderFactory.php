<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'         => $this->faker->name(),
            'state'       => $this->faker->name(),
            'zip'       => $this->faker->zipcode(),
            'amount'       => random_int(0, 11),
            'qty'       => random_int(0, 2),
            'item'       => $this->faker->name(),
        ];
    }
}
