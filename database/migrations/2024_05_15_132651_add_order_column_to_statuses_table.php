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
        if (! Schema::hasColumn('statuses', 'order')) {
            Schema::table('statuses', function (Blueprint $table) {
                $table->unsignedInteger('order')->default(0)->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('statuses', 'order')) {
            Schema::table('statuses', function (Blueprint $table) {
                $table->dropColumn('order');
            });
        }
    }
};
