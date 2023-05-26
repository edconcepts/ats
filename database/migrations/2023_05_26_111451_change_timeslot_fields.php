<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('store_manager_time_slots', function (Blueprint $table) {
            $table->dropColumn('to_date_time');
            $table->dropColumn('from_date_time');

            $table->dateTime('start');
        });
    }

    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
