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
        Schema::create('erp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->nullable();
            $table->boolean('update_flag')->default(false);
            $table->boolean('cancel_flag')->default(false);
            $table->json('cus_info')->nullable();         // Customer info in JSON
            $table->json('order_info')->nullable();       // General order info
            $table->json('order_details')->nullable();    // Order item-level details
            $table->json('response')->nullable();         // Response from ERP
            $table->boolean('sent')->default(false);      // Whether data was sent
            $table->integer('retry')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_logs');
    }
};
