<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = Status::inRandomOrder()->first();
        return [
            'kik_id' => fake()->unique()->randomNumber(),
            'slug' => fake()->slug(),
            'title' => fake()->title(),
            'kik_date' => fake()->date(),
            'name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'vacancy_id' => Vacancy::inRandomOrder()->first()->kik_id,
            'kik_application_status' => $status->name,
            'status_id' => $status->id
        ];
    }
}
