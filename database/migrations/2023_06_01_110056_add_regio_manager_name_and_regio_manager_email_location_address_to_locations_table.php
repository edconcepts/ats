<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('regio_manager_name')->nullable();
            $table->string('regio_manager_email')->nullable();
            $table->string('location_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('regio_manager_name');
            $table->dropColumn('regio_manager_email');
            $table->dropColumn('location_address');
        });
    }
};
