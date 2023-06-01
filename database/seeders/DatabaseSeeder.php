<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            StatusTableSeeder::class,
            StoreManagerTimeSlotTableSeeder::class
        ]);

        \App\Models\Location::factory()->count(3)->create();
        \App\Models\Vacancy::factory()->count(3)->create();
        \App\Models\Application::factory()->count(10)->create();
        \App\Models\StatusEmail::factory()->count(3)->create();
    }


}
