<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;


    protected $table = "brands";
    protected $fillable = [
        'name', 'created_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
   
}
