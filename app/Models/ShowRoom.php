<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowRoom extends Model
{
    use HasFactory;

    protected $table = "show_rooms";
    protected $fillable = [
        'name','ctp_name','number','contact_person','email','district_id','upazila_id','zone_id','post_code','street_address','status', 'created_by','updated_by','suffix','dealar','credit_score','remaining_credit'
    ];


    public function transactions()
{
    return $this->hasManyThrough(Transaction::class, HirePurchase::class);
}


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function showrooms()
    {
        return $this->hasMany(ShowRoom::class, 'showroom_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

}
