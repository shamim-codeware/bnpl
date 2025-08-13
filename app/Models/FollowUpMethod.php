<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpMethod extends Model
{
    use HasFactory;

    protected $table = "follow_up_methods";
   
    protected $fillable = [
        'name','status', 'created_by'
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
