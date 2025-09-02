<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo','favicon','icon','dark_logo','site_name','fax',
        'website','whatsapp','phone','email',
        'email_optional','address','country',
        'state','city','postal_code',
        'currency_symbol',
        'currency_name',
        'timeZone',
    ];
}
