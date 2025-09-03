<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CredentialSetting extends Model
{
    use HasFactory;

    protected $table = 'credential_setting';

    protected $fillable = [
        'rechaptcha_secrect_key','rechaptcha_site_key','google_map_id','google_tag_manager','facebook_pixel_id'
    ];
    
}
