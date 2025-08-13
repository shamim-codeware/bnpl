<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonePermission extends Model
{
    use HasFactory;

    protected $table = "zone_permissions";
    protected $fillable = [
        'zone_id', 'user_id'
    ];
    
}
