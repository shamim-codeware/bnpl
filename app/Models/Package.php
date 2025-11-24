<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active', 'created_by'];

    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }

    // Remove withPivot('quantity') since that column doesn't exist
    public function products()
    {
        return $this->belongsToMany(Product::class, 'package_items', 'package_id', 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
