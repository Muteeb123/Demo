<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\userdetails>
 */
class UserDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => \App\Models\User::factory(),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->state, 
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,    
        ];
    }
}
