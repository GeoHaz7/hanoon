<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Edition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => $this->faker->paragraph(5),
            'short_brief' => $this->faker->paragraph(1),
            'author' => fake()->name(),
            // 'author' => fake()->category(),
            'edition_id' => Edition::all()->random()->id,

        ];
    }
}
