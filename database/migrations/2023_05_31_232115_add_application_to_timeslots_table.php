<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('store_manager_time_slots', function (Blueprint $table) {
            $table->foreignId('application_id')->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('store_manager_time_slots', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropColumn('application_id');
        });
    }
};
