<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    use HasFactory;

    protected $fillable = [
        'hire_purchase_id',
        'showroom_user_id',
        'type',
        'amount',
        'incentive_rate',
        'incentive_amount',
        'status',
        'payment_date'
    ];
}
