<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;


    protected $table = "sizes";
    protected $fillable = [
        'name', 'created_by','gourp_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function group()
    {
        return $this->belongsTo(ProductType::class, 'gourp_id');
    }
}
