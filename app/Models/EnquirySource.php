<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquirySource extends Model
{
    use HasFactory;

    protected $table = "enquiry_sources";
    protected $fillable = [
        'name','parent_id','status', 'created_by'
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquery::class, 'source_parent');
    }

    public function parents()
    {
        return $this->belongsTo(EnquirySource::class, 'parent_id');
    }
}
