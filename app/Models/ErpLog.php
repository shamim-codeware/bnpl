<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErpLog extends Model
{
    use HasFactory;
    protected $table = "erp_logs";
    protected $fillable = [
        'tracking_number', 'update_flag', 'cancel_flag', 'cus_info', 'order_info', 'order_details', 'response', 'sent', 'retry'
    ];


    public function order()
    {
        return $this->belongsTo(HirePurchase::class, 'tracking_number');
    }

}
