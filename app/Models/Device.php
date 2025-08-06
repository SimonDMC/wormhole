<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'room_id', 
        'name', 
        'endpoint', 
        'p256dh', 
        'auth'
    ];
}
