<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestRate extends Model
{
    use HasFactory;
    protected $table = "interest_rates";
    protected $fillable = [
        'month','interest_rate','created_by','updated_by'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updateusers()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
