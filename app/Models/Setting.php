<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo','favicon','icon','dark_logo','site_name','fax',
        'website','whatsapp','phone','email','phone_optional','address_optional',
        'email_optional','address','country','state','city','postal_code',
        'currency_symbol', 'currency_name','timeZone','date_format',
        'google_map', 'facebook','twitter','youtube','linkedin','instagram','pinterest',
        'reddit', 'quora','thread','facebook_pixel','google_analytics','tax',
        'time_format','month_format','restrict_country', 'allow_files', 'file_size',
        'product_prefix','supplier_prefix','purchase_prefix', 'purchase_return_prefix', 
        'sales_return_prefix','sales_prefix','customer_prefix', 'expense_prefix',
        'stock_transfer_prefix','stock_adjustment_prefix','pos_invoice_prefix',
        'sales_order_prefix','estimate_prefix','transaction_prefix', 'employee_prefix',
        'otp_type','otp_digit_limit','otp_exp_time'
    ];
    
}
