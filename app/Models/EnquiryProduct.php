<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryProduct extends Model
{
    use HasFactory;
    protected $table = "enquiry_products";
    protected $fillable = [
        'enquiry_id', 'group_name', 'category_name', 'product_name', 'group_id', 'category_id', 'product_id'
    ];

    public function enquiries()
    {
        return $this->belongsTo(Enquery::class, 'enquiry_id');
    }
}
