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
        'sure_shot_type',
        'category_id',
        'product_model_id',
        'product_category_name',
        'product_model_name',
        'amount',
        'incentive_rate',
        'incentive_amount',
        'status',
        'payment_date',
        'created_at',
    ];

    public function hirePurchase()
    {
        return $this->belongsTo(HirePurchase::class);
    }

    public function showroomUser()
    {
        return $this->belongsTo(ShowRoomUser::class, 'showroom_user_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_model_id');
    }
}
