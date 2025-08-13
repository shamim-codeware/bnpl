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

        Schema::create('guaranter_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hire_purchase_id')->nullable()->index();
            $table->string('guarater_one_name')->nullable();
            $table->string('guarater_one_relation')->nullable();
            $table->string('guarater_one_relation_name')->nullable();
            $table->string('guarater_one_address')->nullable();
            $table->string('guarater_one_nid')->nullable();
            $table->string('guarater_one_nid_image')->nullable();
            $table->string('guarater_one_phone')->nullable();
            $table->string('guarater_two_name')->nullable();
            $table->string('guarater_two_relation')->nullable();
            $table->string('guarater_two_relation_name')->nullable();
            $table->string('guarater_two_address')->nullable();
            $table->string('guarater_two_nid')->nullable();
            $table->string('guarater_two_nid_image')->nullable();
            $table->string('guarater_two_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guaranter_infos');
    }
};
