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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin_approved')->default(false)->after('email_verified_at');
            $table->string('admin_approval_token')->nullable()->after('admin_approved');
            $table->timestamp('admin_approved_at')->nullable()->after('admin_approval_token');
            $table->unsignedBigInteger('approved_by')->nullable()->after('admin_approved_at');

            // Add foreign key for approved_by
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['admin_approved', 'admin_approval_token', 'admin_approved_at', 'approved_by']);
        });
    }
};
