<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourcePermission extends Model
{
    use HasFactory;

    protected $table = "source_permissions";
    protected $fillable = [
        'source_id', 'role_id'
    ];
}
