<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        'name', 'type_id', 'category_id','brand_id','product_model','hire_price','product_code','created_by','product_desc','size'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function types()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
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
