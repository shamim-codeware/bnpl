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
        Schema::create('hire_purchase_product_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hire_purchase_product_id');
            $table->unsignedBigInteger('updated_by'); // User ID who made the update
            $table->json('previous_data'); // Store previous values
            $table->json('current_data'); // Store current values after update
            $table->json('changed_fields')->nullable(); // Store only the fields that changed
            $table->timestamp('updated_at');

            $table->foreign('hire_purchase_product_id')->references('id')->on('hire_purchase_products')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hire_purchase_product_audits');
    }
};
