<?php

use App\Models\ShowRoom;
use App\Exports\ShowroomExport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('showroom_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ShowRoom::class, 'showroom_id');
            $table->decimal('credit', 10, 2);
            $table->integer('created_by');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showroom_credits');
    }
};
