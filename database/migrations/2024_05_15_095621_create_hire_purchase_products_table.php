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
        Schema::create('hire_purchase_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hire_purchase_id')->nullable()->index();
            $table->unsignedBigInteger('product_category_id')->nullable()->index();
            $table->unsignedBigInteger('product_model_id')->nullable()->index();
            $table->unsignedBigInteger('product_brand_id')->nullable()->index();
            $table->string('invoice_no')->nullable();
            $table->float('cash_price')->default(0);
            $table->float('hire_price')->default(0);
            $table->float('down_payment')->default(0);
            $table->integer('installment_month')->default(0);
            $table->float('monthly_installment')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hire_purchase_products');
    }
};
