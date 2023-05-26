<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
<<<<<<<< HEAD:database/migrations/2023_05_25_223016_add_end_email_sent_to_interviews_table.php
        Schema::table('interviews', function (Blueprint $table) {
            $table->boolean('end_email_sent')->default(0);
========
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->constrained();
>>>>>>>> 4908c5db905cdc092aff3a704dbfee3031e96045:database/migrations/2023_05_25_235325_invert_relationship_location_user.php
        });
    }

    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2023_05_25_223016_add_end_email_sent_to_interviews_table.php
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('end_email_sent');
========
        Schema::table('', function (Blueprint $table) {
            //
>>>>>>>> 4908c5db905cdc092aff3a704dbfee3031e96045:database/migrations/2023_05_25_235325_invert_relationship_location_user.php
        });
    }
};
