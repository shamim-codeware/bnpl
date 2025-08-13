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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('showroom_id')->nullable()->index();
            $table->unsignedBigInteger('enquiry_type_id')->nullable()->index();
            $table->string('event_code');
            $table->string('name');
            $table->string('number');
            $table->unsignedBigInteger('source_parent')->nullable();
            $table->unsignedBigInteger('source_child')->nullable();
            $table->unsignedBigInteger('purchase_mode')->nullable();
            $table->timestamp('sales_date')->nullable();
            $table->string('buying_aspect')->nullable();
            $table->tinyInteger('offers')->nullable();
            $table->string('type_of_offer')->nullable();
            $table->timestamp('next_follow_up_date')->nullable();
            $table->timestamp('last_attend_date')->nullable();
            $table->tinyInteger('assign')->default(1);
            $table->tinyInteger('seen')->default(1);
            $table->tinyInteger('enquiry_status')->default(1);
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
           
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enquiry_type_id')->references('id')->on('enquiry_types')->onDelete('cascade');
            $table->foreign('source_parent')->references('id')->on('enquiry_sources')->onDelete('cascade');
            $table->foreign('source_child')->references('id')->on('enquiry_sources')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
