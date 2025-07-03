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
        Schema::create('daily_transportation_profits', function (Blueprint $table) {
            $table->id('record_id');
            $table->foreignId('supplier_id')->constrained('suppliers', 'supplier_id')->onDelete('cascade');
            $table->date('transport_date');

            // Lorry transportation data
            $table->decimal('lorry_logs_amount', 10, 2)->default(0.00);
            $table->integer('lorry_logs_units')->default(0);
            $table->decimal('expected_profit_lorry', 10, 2)->default(0.00);

            // Tractor transportation data
            $table->decimal('tractor_logs_amount', 10, 2)->default(0.00);
            $table->integer('tractor_logs_units')->default(0);
            $table->decimal('expected_profit_tractor', 10, 2)->default(0.00);

            // Total daily profit (calculated field)
            $table->decimal('total_expected_profit', 10, 2)->storedAs('expected_profit_lorry + expected_profit_tractor');

            $table->timestamps();

            // Ensure one record per supplier per day
            $table->unique(['supplier_id', 'transport_date'], 'unique_supplier_transport_date');

            // Add indexes for better query performance
            $table->index('transport_date');
            $table->index(['supplier_id', 'transport_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_transportation_profits');
    }
};
