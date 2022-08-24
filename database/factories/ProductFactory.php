<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' =>  Category::pluck('id')[$this->faker->numberBetween(1,Category::count()-1)],
            'name' =>  fake()->unique()->name(),
            'description' => fake()->sentence(),
        ];
    }
}
