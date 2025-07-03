<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id('record_id');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('lorry_amount', 10, 2)->default(0);
            $table->decimal('lorry_units', 8, 2)->default(0); // cubic meters
            $table->decimal('tractor_amount', 10, 2)->default(0);
            $table->decimal('tractor_units', 8, 2)->default(0); // cubic meters
            $table->decimal('expected_profit_lorry', 10, 2)->default(0);
            $table->decimal('expected_profit_tractor', 10, 2)->default(0);
            $table->decimal('total_expected_profit', 10, 2)->default(0);
            $table->decimal('confirmed_cubic_meters', 8, 2)->default(0);
            $table->decimal('extra_cubic', 8, 2)->default(0);
            $table->decimal('less_cubic', 8, 2)->default(0);
            $table->integer('deleted')->default(0); // 0 = active, 1 = deleted
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
