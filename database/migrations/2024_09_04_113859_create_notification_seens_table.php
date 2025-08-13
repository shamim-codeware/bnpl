<?php

use App\Models\User;
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
        Schema::create('notification_seens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('notification_id');
            $table->tinyInteger('is_seen')->comment('1 = seen , 0 = unseen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_seens');
    }
};
