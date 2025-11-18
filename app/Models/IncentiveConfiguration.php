<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncentiveConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reference_id',
        'name',
        'incentive_amount',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'incentive_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'reference_id')->where('type', 'category');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'reference_id')->where('type', 'model');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper method to get the incentive for a product
    public static function getIncentiveForProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return 0;
        }

        // First check for model-specific incentive
        $modelIncentive = self::active()
            ->where('type', 'model')
            ->where('reference_id', $productId)
            ->first();

        if ($modelIncentive) {
            return $modelIncentive->incentive_amount;
        }

        // Then check for category-wise incentive
        $categoryIncentive = self::active()
            ->where('type', 'category')
            ->where('reference_id', $product->category_id)
            ->first();

        if ($categoryIncentive) {
            return $categoryIncentive->incentive_amount;
        }

        return 0;
    }
}
