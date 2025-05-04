<?php

namespace Database\Factories;

use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Commerce($this->faker));

        //$name = $this->faker->unique()->words(2, true);       // old one
        $name = $this->faker->unique()->category;               // after add an outside library
        return [
            'name' => $name,
            'slug' => str::slug($name),
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
