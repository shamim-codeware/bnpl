<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";
    protected $fillable = [
        'name','status','created_by','updated_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
