<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HirePurchaseProductAudit extends Model
{
    use HasFactory;

    protected $table = 'hire_purchase_product_audits';

    protected $fillable = [
        'hire_purchase_product_id',
        'updated_by',
        'previous_data',
        'current_data',
        'changed_fields',
        'updated_at'
    ];

    protected $casts = [
        'previous_data' => 'array',
        'current_data' => 'array',
        'changed_fields' => 'array',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function hirePurchaseProduct()
    {
        return $this->belongsTo(HirePurchaseProduct::class, 'hire_purchase_product_id');
    }
}
