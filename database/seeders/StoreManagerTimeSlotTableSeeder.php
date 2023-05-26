<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreManagerTimeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('store_manager_time_slots')->insert([
            [
                'user_id' => '2',
                'from_date_time' => now()->subDay(),
                'to_date_time' => now()
            ],
            [
                'user_id' => '2',
                'from_date_time' => now()->subDay(),
                'to_date_time' => now()->subDay()
            ]
            ,
            [
                'user_id' => '2',
                'from_date_time' => now()->subDay(),
                'to_date_time' => now()->addDay()
            ],
            [
                'user_id' => '2',
                'from_date_time' => now()->subDay(),
                'to_date_time' => now()->subDay()
            ],
            [
                'user_id' => '2',
                'from_date_time' => now()->subDay(),
                'to_date_time' => now()->addDay()
            ]
        ]);
    }
}
