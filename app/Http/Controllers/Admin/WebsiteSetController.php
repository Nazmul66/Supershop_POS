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

class WebsiteSetController extends Controller
{

    use ImageUploadTraits;

    public function system_settings()
    {
      return view('admin.pages.website_settings.system_settings');
    }

      public function company_settings()
    {
      return view('admin.pages.website_settings.company_settings');
    }
    
     public function localization()
    {
      return view('admin.pages.website_settings.localization_settings');
    }

     public function prefixes()
    {
      return view('admin.pages.website_settings.prefixes_settings');
    }


    public function language()
    {
      return view('admin.pages.website_settings.language_settings');
    }


}
