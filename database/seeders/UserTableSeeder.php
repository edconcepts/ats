<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'HR gebruiker',
            'email' => 'hr@werkenbijkik.nl',
            'role' => 'hr'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@werkenbijkik.nl',
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Regio manager',
            'email' => 'regiomanager@werkenbijkik.nl',
            'role' => 'area_manager'
        ]);
    }
}
