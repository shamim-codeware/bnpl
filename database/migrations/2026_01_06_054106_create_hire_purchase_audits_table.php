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
        Schema::create('hire_purchase_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hire_purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->json('old_values');      // আগের ডেটা
            $table->json('new_values');      // নতুন ডেটা
            $table->json('changed_fields');  // শুধুমাত্র পরিবর্তিত ফিল্ড
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hire_purchase_audits');
    }
};
