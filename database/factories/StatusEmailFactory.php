<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusEmail>
 */
class StatusEmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->title(),
            'body' => fake()->text(120),
            'status_id' => \App\Models\Status::inRandomOrder()->first()->id
        ];
    }
}
