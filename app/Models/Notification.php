<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


    protected $table = "notifications";
  
    protected $fillable = [
        'name','next_follow_up_date','followup_id','enquiry_id','showroom_id','customer_id','assign',
        'created_by','status','ex_seen','man_seen','admin_seen','notifications_type'
    ];

    
    public function showroom()
    {
        return $this->belongsTo(ShowRoom::class, 'showroom_id')->selectRaw('id, zone_id, name,  number, email, contact_person, street_address');
    }

    public function assign_by()
    {
        return $this->belongsTo(User::class, 'assign')->selectRaw('id, name, email, phone, address');
    }

    
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by')->selectRaw('id, name, email, phone, address');
    }

    public function notificationSeen()
    {
        return $this->hasMany(NotificationSeen::class, 'notification_id', 'id');
    }
    public function hirepurchase(){
        return $this->belongsTo(HirePurchase::class,'hire_id', 'id');
    }
}
