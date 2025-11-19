<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralIncentiveConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'config_type',
        'value',
        'description',
        'is_active',
        'created_by'
    ];

    // Get the down payment threshold value
    public static function getDownPaymentThreshold()
    {
        $config = self::where('config_type', 'down_payment_threshold')
            ->where('is_active', true)
            ->first();
        return $config ? $config->value : 40.00; // Default 40%
    }

    // Get the down payment incentive rate
    public static function getDownPaymentIncentiveRate()
    {
        $config = self::where('config_type', 'down_payment_incentive_rate')
            ->where('is_active', true)
            ->first();
        return $config ? $config->value : 0.50; // Default 0.5%
    }

    // Get the collection incentive rate
    public static function getCollectionIncentiveRate()
    {
        $config = self::where('config_type', 'collection_incentive_rate')
            ->where('is_active', true)
            ->first();
        return $config ? $config->value : 2.50; // Default 2.5%
    }
}
