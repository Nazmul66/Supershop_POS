<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'branch_id',
        'device_code',
        'device_name',
        'ip_address',
        'last_active_at',
        'is_online',
        'status',
    ];
}
