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
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hire_purchase_id')->constrained('hire_purchases')->onDelete('cascade');
            $table->date('returned_at'); // Sales Return Date
            $table->string('reason'); // or enum: cash_purchase_change, technical_issue, etc.
            $table->decimal('return_amount', 15, 2); // Total product value being returned
            $table->decimal('refund_amount', 15, 2)->default(0); // Amount refunded to customer
            $table->decimal('other_income', 15, 2)->default(0); // Amount kept as income
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_returns');
    }
};
