<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        'name',
        'type_id',
        'category_id',
        'brand_id',
        'product_model',
        'hire_price',
        'product_code',
        'created_by',
        'updated_by',
        'product_desc',
        'size',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function types()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }

    public function audits()
    {
        return $this->hasMany(ProductAudit::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

}
