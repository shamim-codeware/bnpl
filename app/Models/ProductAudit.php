<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAudit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'updated_by',
        'previous_data',
        'current_data',
        'changed_fields',
        'updated_at',
    ];

    protected $casts = [
        'previous_data' => 'array',
        'current_data' => 'array',
        'changed_fields' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
