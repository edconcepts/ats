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
            ['id' => 1, 'order' => 0, 'name' => 'Gearchiveerd', 'visible' => false],
            ['id' => 2, 'order' => 1, 'name' => 'Gesolliciteerd', 'visible' => true],
            ['id' => 3, 'order' => 2, 'name' => 'Afgewezen', 'visible' => true],
            ['id' => 4, 'order' => 3, 'name' => 'Gebeld geen contact', 'visible' => true],
            ['id' => 5, 'order' => 4, 'name' => '2e keer gebeld geen contact', 'visible' => true],
            ['id' => 6, 'order' => 5, 'name' => '3e keer gebeld, geen contact, afgewezen', 'visible' => true],
            ['id' => 7, 'order' => 6, 'name' => 'Gesprek ingepland', 'visible' => true],
            ['id' => 8, 'order' => 7, 'name' => '2e gesprek ingepland', 'visible' => true],
            ['id' => 9, 'order' => 8, 'name' => 'Hired / Contract aangeboden', 'visible' => true],
            ['id' => 10, 'order' => 9, 'name' => 'Doorgezet naar regiomanager', 'visible' => true],
        ]);
    }
}
