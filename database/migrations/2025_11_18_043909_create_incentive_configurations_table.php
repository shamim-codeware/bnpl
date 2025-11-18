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
        Schema::create('incentive_configurations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['category', 'model']);
            $table->unsignedBigInteger('reference_id'); // category_id or product_model_id
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('name'); // category name or model name
            $table->decimal('incentive_amount', 10, 2); // Fixed incentive amount
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incentive_configurations');
    }
};
