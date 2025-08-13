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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enquiry_id')->nullable()->index();
            $table->string('name');
            $table->string('event_code');
            $table->string('follow_up_info')->nullable();
            $table->tinyInteger('next_follow_up_method')->nullable();
            $table->timestamp('next_follow_up_date')->nullable();
            $table->timestamp('last_attend_date')->nullable();
            $table->tinyInteger('status_parent')->nullable();
            $table->tinyInteger('status_child')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
