<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquery extends Model
{
    use HasFactory;

    protected $table = "enquiries";
    protected $fillable = [
        'name','number','event_code','customer_id','enquiry_type_id','source_parent','source_child','purchase_mode','sales_date','buying_aspect','offers','type_of_offer','next_follow_up_date','last_attend_date','status','created_by','updated_by','showroom_id', 'assign', 'enquiry_status', 'parent_status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    public function enquirystatus()
    {
        return $this->belongsTo(EnqueryStatus::class, 'enquiry_status');
    }

    public function product()
    {
        return $this->hasMany(EnquiryProduct::class, 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->selectRaw('id,age,name, number, email, gender, type_id');
    }

    public function enquiry_type()
    {
        return $this->belongsTo(EnquiryType::class, 'enquiry_type_id');
    }

    public function enquiry_source()
    {
        return $this->belongsTo(EnquirySource::class, 'source_parent');
    }

    public function enquiry_source_child()
    {
        return $this->belongsTo(EnquirySource::class, 'source_child')->selectRaw('id, name, parent_id');
    }

    public function purchase_modes()
    {
        return $this->belongsTo(PurchaseMode::class, 'purchase_mode');
    }

    public function showroom()
    {
        return $this->belongsTo(ShowRoom::class, 'showroom_id')->selectRaw('id, zone_id, name,  number, email, contact_person, street_address');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by')->selectRaw('id, name, email, phone, address');
    }

    public function follow_ups()
    {
        return $this->hasMany(FollowUp::class, 'enquiry_id');
    }


    public function assign_by()
    {
        return $this->belongsTo(User::class, 'assign')->selectRaw('id, name, email, phone, address');
    }
}
