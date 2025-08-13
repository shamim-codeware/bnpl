<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'showroom_id',
        'credit',
        'created_by'
    ];


    public function show_room()
    {
        return $this->belongsTo(ShowRoom::class, 'showroom_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
