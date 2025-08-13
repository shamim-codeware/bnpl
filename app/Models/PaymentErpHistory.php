<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentErpHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_erp_histories';
    protected $fillable = ['tracking_id','transaction_id','installment_id','erp_data','erp_status','response'];

    protected $casts = [
        'erp_data' => 'array'
    ];
}
