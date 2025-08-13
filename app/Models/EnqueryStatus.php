<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnqueryStatus extends Model
{
    use HasFactory;

    protected $table = "enquiry_statuses";
    protected $fillable = [
        'name','status', 'created_by','parent_id'
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parents()
    {
        return $this->belongsTo(EnqueryStatus::class, 'parent_id');
    }
}
