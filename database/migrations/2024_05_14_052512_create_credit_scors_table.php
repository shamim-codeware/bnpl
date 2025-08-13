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
        Schema::create('credit_scors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('showroom_id')->nullable()->index();
            $table->tinyInteger('blacklist')->nullable();
            $table->tinyInteger('bad_creditor')->nullable();
            $table->tinyInteger('is_nid')->nullable();
            $table->integer('age')->nullable();
            $table->integer('customer_status')->nullable();
            $table->integer('monthly_income')->nullable();
            $table->integer('profession')->nullable();
            $table->string('other_profession')->nullable();
            $table->integer('length_profession')->nullable();
            $table->integer('family_size')->nullable();
            $table->integer('residence_status')->nullable();
            $table->integer('permanent_address_mentioned')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('gaurantors')->nullable();
            $table->integer('educational_qualification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_scors');
    }
};
