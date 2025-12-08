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
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_id')->constrained('installments')->cascadeOnDelete();
            $table->string('order_no');
            $table->enum('notice_no',['1st', '2nd', '3rd']);
            $table->enum('type', ['customer', 'granter']);
            $table->enum('status', ['pending', 'yes', 'no'])->default('pending');
            $table->enum('action', [1, 0])->default(0);
            $table->timestamp('status_date')->nullable();
            $table->timestamp('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
