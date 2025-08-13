<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HirePurchaseProduct extends Model
{
    use HasFactory;


    protected $table = "hire_purchase_products";
    protected $fillable = [
        'hire_purchase_id','product_group_id','product_category_id','product_model_id','product_brand_id','invoice_no','cash_price','hire_price', 'down_payment','installment_month','monthly_installment','product_size_id','serial_no','total_paid','advance_pay'
    ];

    public function hire_purchase(){
        return $this->belongsTo(HirePurchase::class, 'hire_purchase_id')->selectRaw('id,name');
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id')->selectRaw('id,name');
    }

    public function product_group()
    {
        return $this->belongsTo(ProductType::class, 'product_group_id')->selectRaw('id,name');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_model_id')->selectRaw('id,product_model');
    }

    public function product_size()
    {
        return $this->belongsTo(Size::class, 'product_size_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'product_brand_id')->selectRaw('id,name');
    }

    public function product_type(){
        return $this->belongsTo(HirePurchase::class, 'hire_purchase_id');
    }
}
