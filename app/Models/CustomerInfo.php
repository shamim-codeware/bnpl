<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;

    protected $table = "credit_scors";
    protected $fillable = [
        'name','relation','relation_person','nid','nid_image','age','marital_status', 'pr_house_no','pr_road_no','pr_district_id','pr_upazila_id','pr_phone','pr_residence_status','pr_duration_staying','pa_house_no','pa_road_no','pa_district_id','pa_upazila_id','pa_phone','profession_id','designation','duration_current_profe','organization_name','organization_short_desc','org_house_no','org_road_no','org_district_id','org_upazila_id','org_phone','month_income','number_of_children','other_family_member','name_age_family_member','product_name','sell_price','previously_purchased',
    ];
}
