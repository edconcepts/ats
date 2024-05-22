<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kik_id' => fake()->unique()->randomNumber(),
            'slug' => fake()->slug(),
            'title' => fake()->jobTitle(),
            'kik_date' => fake()->date(),
            'location_id' => Location::inRandomOrder()->first()->kik_id,
        ];
    }
}
