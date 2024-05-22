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
            ['id' => 1, 'name' => 'Gearchiveerd', 'visible' => false],
            ['id' => 2, 'name' => 'Gesolliciteerd', 'visible' => true],
            ['id' => 3, 'name' => 'Afgewezen', 'visible' => true],
            ['id' => 4, 'name' => 'Gebeld geen contact', 'visible' => true],
            ['id' => 5, 'name' => '2e keer gebeld geen contact', 'visible' => true],
            ['id' => 6, 'name' => '3e keer gebeld, geen contact, afgewezen', 'visible' => true],
            ['id' => 7, 'name' => 'Gesprek ingepland', 'visible' => true],
            ['id' => 8, 'name' => '2e gesprek ingepland', 'visible' => true],
            ['id' => 9, 'name' => 'Hired / Contract aangeboden', 'visible' => true],
            ['id' => 10, 'name' => 'Doorgezet naar regiomanager', 'visible' => true],
        ]);
    }
}
