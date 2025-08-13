<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";
    protected $fillable = [
        'name','number','alt_number','email','profession','gender','status', 'created_by','updated_by','type_id','showroom_id','district_id','upazila_id','age','pa_house_no','pa_road_no','nid'
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function customer_types()
    {
        return $this->belongsTo(CustomerType::class, 'type_id')->selectRaw('id, name');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }


}