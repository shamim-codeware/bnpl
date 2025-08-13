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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hire_id')->constrained('hire_purchases')->cascadeOnDelete();
            $table->foreignId('showroom_id')->constrained('show_rooms')->cascadeOnDelete();
            $table->string('product_name', 300)->nullable();
            $table->string('amount', 300)->nullable();
            $table->tinyInteger('admin')->nullable();
            $table->tinyInteger('retail')->nullable();
            $table->tinyInteger('manager')->nullable();
            $table->tinyInteger('zone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
