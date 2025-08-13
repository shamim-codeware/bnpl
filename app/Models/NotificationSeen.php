<?php

namespace App\Models;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationSeen extends Model
{
    use HasFactory;

    public function notification(){
        return $this->belongsTo(Notification::class, 'notification_id', 'id');
    }
}
