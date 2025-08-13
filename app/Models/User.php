<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    CONST ADMIN = 1;
    CONST ZONE = 2;
    CONST MANAGER = 3;
    CONST RETAIL = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'profile_photo_path','role_id','showroom_id','created_by','is_active','last_seen','zone_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by')->selectRaw('users.id, users.name, users.email, users.phone');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id')->selectRaw('roles.id, roles.name');
    }

    public function showrooms()
    {
        return $this->belongsTo(ShowRoom::class, 'showroom_id')->selectRaw('show_rooms.id, show_rooms.name, show_rooms.number, show_rooms.email,show_rooms.zone_id');
    }

    public function zones()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }


    public function user_action($action)
    {
        $current_path = request()->path();
        $explode_path = explode('/', $current_path)[0];
        $permission   = MenuPermission::where('role_id', Auth::user()->role_id)
                            ->whereHas('menu', function ($q) use ($explode_path){
                                $q->where('url', $explode_path);
                            })->first();
        if($permission){
            return in_array($action, $permission->action)? true : false;
        }
        return false;
    }
}
