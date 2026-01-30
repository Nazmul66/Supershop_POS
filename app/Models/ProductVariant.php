<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_id',
        'variant_name',
        'variant_code',
        'qty',
        'alert_qty',
        'purchase_price',
        'profit_margin',
        'selling_price',
        'status',
    ];
}
