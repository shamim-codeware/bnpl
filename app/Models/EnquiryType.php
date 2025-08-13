<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryType extends Model
{
    use HasFactory;

    protected $table = "enquiry_types";
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
