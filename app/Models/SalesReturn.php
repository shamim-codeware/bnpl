<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'hire_purchase_id',
        'returned_at',
        'reason',
        'return_amount',
        'refund_amount',
        'other_income',
        'notes',
    ];
}
