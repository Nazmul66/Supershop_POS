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

class AppSettingsController extends Controller
{

    use ImageUploadTraits;

    public function invoice_settings()
    {
      return view('admin.pages.app_settings.invoice_setting');
    }

      public function invoice_template()
    {
      return view('admin.pages.app_settings.invoice_template');
    }
    
     public function printer()
    {
      return view('admin.pages.app_settings.printer');
    }

     public function pos_setting()
    {
      return view('admin.pages.app_settings.pos');
    }

    public function signature()
    {
      return view('admin.pages.app_settings.signature');
    }


}
