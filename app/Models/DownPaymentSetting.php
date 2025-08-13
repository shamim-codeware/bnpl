<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownPaymentSetting extends Model
{
    use HasFactory;

    protected $table = "down_payment_settings";
    protected $fillable = [
        'payment_percentage'
    ];
}
