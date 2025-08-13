<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuaranterInfo extends Model
{
    use HasFactory;
    protected $table = "guaranter_infos";

    protected $fillable = [
        "hire_purchase_id",'guarater_name','guarater_relation','guarater_relation_name','age','marital_status','number_of_children','other_family_member', 'guarater_address_present','guarater_nid','guarater_nid_image','guarater_phone','duration_of_staying','residense_status','guarater_address_permanent','proffession_id','designation','profession_phone','monthly_income','duration_current_profession','name_address_office','relation' 
    ];

    public function profession(){
        return $this->belongsTo(CustomerProfession::class, 'proffession_id');
    }




}
