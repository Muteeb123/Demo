<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $images = [];
    public function definition(): array
    {

        

        if (empty(static::$images)) {
           
            $file = public_path('products.txt');
            if (file_exists($file)) {
                static::$images = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            }
        }
        return [
            //
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'stock' => fake()->numberBetween(1, 100),
            'image' => static::$images ? fake()->randomElement(static::$images) : null,
            'is_active' => true,
            'AddedBy' => \App\Models\User::factory(),
            'created_at' => now()->subDays(rand(1, 365)),
        ];
    }
}
