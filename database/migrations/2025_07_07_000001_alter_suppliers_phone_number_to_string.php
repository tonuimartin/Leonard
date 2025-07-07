<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('phone_number')->change();
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // If you want to revert, you may need to cast all values to integer or drop the column and re-add as unsignedBigInteger
            $table->unsignedBigInteger('phone_number')->change();
        });
    }
};
