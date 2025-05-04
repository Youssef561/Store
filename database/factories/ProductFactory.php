<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        $this->faker->addProvider(new Commerce($this->faker));

        $name = $this->faker->unique()->productName;
        return [
            'name' => $name,
            'slug' => str::slug($name),
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(600, 600),
            'price' => $this->faker->randomFloat(1, 1, 499),
            'compare_price' => $this->faker->randomFloat(1, 500, 999),
            'featured' => rand(0, 1),
            'category_id' => Category::inRandomOrder()->first()->id,
            'store_id' => Store::inRandomOrder()->first()->id,


        ];
    }
}
