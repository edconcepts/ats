<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'Gesolliciteerd'],
            ['id' => 2, 'name' => 'Afgewezen'],
            ['id' => 3, 'name' => 'Gebeld geen contact'],
            ['id' => 4, 'name' => '2e keer gebeld geen contact'],
            ['id' => 5, 'name' => 'Gesprek ingepland'],
            ['id' => 6, 'name' => '2e gesprek ingepland'],
            ['id' => 7, 'name' => 'Contract aangeboden'],
            ['id' => 8, 'name' => 'Hired'],
        ]);
    }
}
