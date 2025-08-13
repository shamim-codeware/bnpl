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
        Schema::table('hire_purchases', function (Blueprint $table) {
            $table->text('rejection_note')->nullable()->after('status');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejection_note');
            $table->timestamp('rejected_at')->nullable()->after('rejected_by');

            // Add foreign key constraint for rejected_by
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hire_purchases', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn(['rejection_note', 'rejected_by', 'rejected_at']);
        });
    }
};
