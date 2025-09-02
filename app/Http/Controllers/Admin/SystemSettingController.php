<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Traits\ImageUploadTraits;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SystemSettingController extends Controller
{

    use ImageUploadTraits;

    public function email_settings()
    {
      return view('admin.pages.system_settings.email_setting');
    }

      public function email_template()
    {
      return view('admin.pages.system_settings.email_template');
    }
    
     public function otp_setting()
    {
      return view('admin.pages.system_settings.otp');
    }


}
