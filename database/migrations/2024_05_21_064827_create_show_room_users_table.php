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

        Schema::create('show_room_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('showroom_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->integer('is_active')->default(1);
            $table->string('profile_photo_path')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_room_users');
    }
};
