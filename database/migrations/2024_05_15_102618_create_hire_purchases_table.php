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

        Schema::create('hire_purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('credit_id')->nullable()->index();
            $table->unsignedBigInteger('showroom_id')->nullable()->index();
            $table->unsignedBigInteger('pr_district_id')->nullable()->index();
            $table->unsignedBigInteger('pr_upazila_id')->nullable()->index();
            $table->unsignedBigInteger('pa_district_id')->nullable()->index();
            $table->unsignedBigInteger('org_district_id')->nullable()->index();
            $table->unsignedBigInteger('pa_upazila_id')->nullable()->index();
            $table->unsignedBigInteger('org_upazila_id')->nullable()->index();
            $table->unsignedBigInteger('profession_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('relation')->nullable();
            $table->string('relation_person')->nullable();
            $table->string('nid')->nullable();
            $table->string('nid_image')->nullable();
            $table->string('age')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('pr_house_no')->nullable();
            $table->string('pr_road_no')->nullable();
            $table->string('pr_phone')->nullable();
            $table->string('pr_residence_status')->nullable();
            $table->string('pr_duration_staying')->nullable();
            $table->string('pa_house_no')->nullable();
            $table->string('pa_road_no')->nullable();

            $table->string('pa_phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('duration_current_profe')->nullable();
            $table->string('organization_name')->nullable();

            $table->string('organization_short_desc')->nullable();
            $table->string('org_house_no')->nullable();
            $table->string('org_road_no')->nullable();
            $table->string('org_phone')->nullable();

            $table->float('month_income')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('other_family_member')->nullable();
            $table->string('name_age_family_member')->nullable();
           
            $table->string('product_name')->nullable();
            $table->float('sell_price')->nullable();
            $table->string('previously_purchased')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hire_purchases');
    }
};
