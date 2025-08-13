<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowRoomUser extends Model
{
    use HasFactory;

    protected $table = "show_room_users";
    protected $fillable = [
        'name',
        'code',
        'password',
        'phone',
        'address',
        'profile_photo_path','showroom_id','created_by','is_active'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by')->selectRaw('users.id, users.name, users.email, users.phone');
    }

    public function showrooms()
    {
        return $this->belongsTo(ShowRoom::class, 'showroom_id')->selectRaw('show_rooms.id, show_rooms.name, show_rooms.number, show_rooms.email,show_rooms.zone_id');
    }

}
