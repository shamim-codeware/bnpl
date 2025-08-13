<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditScor extends Model
{
    use HasFactory;
    
    protected $table = "credit_scors";
    protected $fillable = [
        'customer_id','showroom_id','blacklist','bad_creditor','is_nid','age','customer_status', 'monthly_income','profession','other_profession','length_profession','family_size','residence_status','permanent_address_mentioned','distance','gaurantors','educational_qualification','is_approved_id'
    ];
}
