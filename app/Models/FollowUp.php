<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $table = "follow_ups";
   
    protected $fillable = [
        'name','event_code','follow_up_info','next_follow_up_date','next_follow_up_method','status_parent','enquiry_id','status_child','note','status','last_attend_date'
    ];
    
    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function followupmethod()
    {
        return $this->belongsTo(FollowUpMethod::class, 'next_follow_up_method');
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquery::class, 'enquiry_id');
    }

    public function enquiryparent()
    {
        return $this->belongsTo(EnqueryStatus::class, 'status_parent');
    }

    public function enquirychild()
    {
        return $this->belongsTo(EnqueryStatus::class, 'status_child');
    }
}
