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

class GeneralSettingController extends Controller
{

    use ImageUploadTraits;

    public function profile()
    {
      return view('admin.pages.general_settings.adminProfile ');
    }

    public function security()
    {
        return view('admin.pages.general_settings.security');
    }
    
     public function notification()
    {
        return view('admin.pages.general_settings.notifications');
    }

}
