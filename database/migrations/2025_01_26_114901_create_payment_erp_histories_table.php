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
        Schema::create('payment_erp_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('tracking_id');
            $table->string('erp_data')->nullable();
            $table->string('erp_status')->nullable();
            $table->string('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_erp_histories');
    }
};
