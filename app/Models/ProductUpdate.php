<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUpdate extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'admin_id',
        'ip_address',
        'device',
        'user_agent',
        'country',
        'changes',
        'updated_at',
    ];
}
