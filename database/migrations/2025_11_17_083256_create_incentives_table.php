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
        Schema::create('incentives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hire_purchase_id')->constrained('hire_purchases')->cascadeOnDelete();
            $table->foreignId('showroom_user_id')->constrained('show_room_users')->cascadeOnDelete();
            $table->string('type'); // 'down_payment', 'collection'
            $table->decimal('amount', 10, 2);
            $table->decimal('incentive_rate', 5, 2);
            $table->decimal('incentive_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, paid
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incentives');
    }
};
