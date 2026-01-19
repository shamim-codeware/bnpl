<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HirePurchaseAudit extends Model
{
    use HasFactory;

    protected $table = 'hire_purchase_audits';
    protected $guarded = [];

    public $timestamps = true;
}
