<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = "product_categories";
    protected $fillable = [
        'name', 'type_id','created_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function types()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }
}
