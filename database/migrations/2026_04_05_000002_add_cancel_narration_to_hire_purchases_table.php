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
        Schema::table('hire_purchases', function (Blueprint $table) {
            $table->text('cancel_narration')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hire_purchases', function (Blueprint $table) {
            $table->dropColumn('cancel_narration');
        });
    }
};
