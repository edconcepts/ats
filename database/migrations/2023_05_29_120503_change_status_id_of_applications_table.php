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
        Schema::table('applications', function(Blueprint $table)
        {
            $table->dropForeign('applications_status_id_foreign');
            $table->dropColumn('status_id');
        });

        Schema::table('applications', function(Blueprint $table)
        {
            $table->foreignId('status_id')->default(2)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
