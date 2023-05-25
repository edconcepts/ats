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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kik_id')
                ->unique();

            $table->foreignId('location_id')
                ->references('kik_id')
                ->on('locations')
                ->onDelete('cascade');

            $table->string('slug');
            $table->string('title')->nullable();
            $table->timestamp('kik_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
