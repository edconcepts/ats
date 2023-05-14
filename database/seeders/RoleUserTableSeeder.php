<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hrUser = \App\Models\User::where('email', 'hr@example.com')->first();
        $storeManagerUser = \App\Models\User::where('email', 'storemanager@example.com')->first();

        $hrRole = \App\Models\Role::where('name','hr')->first();
        $storeManagerRole = \App\Models\Role::where('name','store_manager')->first();

        $hrUser->roles()->attach($hrRole->id);
        $storeManagerUser->roles()->attach($storeManagerRole->id);
    }
}
