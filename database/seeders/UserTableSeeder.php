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
            'name' => 'Test Hr User',
            'email' => 'hr@example.com',
            'role' => 'hr'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Store Manager User',
            'email' => 'storemanager@example.com',
            'role' => 'store_manager'
        ]);

    }
}
