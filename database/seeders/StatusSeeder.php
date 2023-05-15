<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => 'Gesolliciteerd'],
            ['name' => 'Afgewezen'],
            ['name' => 'Gebeld geen contact'],
            ['name' => '2e keer gebeld geen contact'],
            ['name' => 'Gesprek ingepland'],
            ['name' => '2e gesprek ingepland'],
            ['name' => 'Contract aangeboden'],
            ['name' => 'Hired'],
        ]);
    }
}
