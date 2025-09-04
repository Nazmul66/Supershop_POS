<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EmailConfiguration;
use App\Models\Setting;
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
      $email_setting = EmailConfiguration::first();
      return view('admin.pages.system_settings.email_setting', compact('email_setting'));
    }

    public function email_update(Request $request)
    {
      // dd($request->all());
      $request->validate([
          'email'       => ['required', 'email'],
          'host'        => ['required', 'max: 200'],
          'username'    => ['required', 'max: 200'],
          'password'    => ['required', 'max: 200'],
          'port'        => ['required', 'max: 200'],
          'encryption'  => ['required', 'max: 200'],
      ]);

        DB::beginTransaction();
        try {
          // Find existing setting (first row only)
            $email_setting = EmailConfiguration::first();

          // Now save with updateOrCreate
          EmailConfiguration::updateOrCreate(
              ['id' => $email_setting->id ?? null], // if id exists update, else create
              [
                  'email'         => $request->email,
                  'host'          => $request->host,
                  'username'      => $request->username,
                  'password'      => $request->password,
                  'port'          => $request->port,
                  'encryption'    => $request->encryption,
                  'created_at'    => now(),
                  'updated_at'    => now(),
              ]
          );
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            // dd($ex->getMessage());
            Toastr::error('There is something wrong', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('Email Setting data updated', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    public function email_template()
    {
      return view('admin.pages.system_settings.email_template');
    }
    
     public function otp_setting()
    {
      $setting = Setting::first();
      return view('admin.pages.system_settings.otp', compact('setting'));
    }

    public function otp_update(Request $request)
    {
      // dd($request->all());
      $request->validate([
            'otp_type' => ['required', 'string'],
            'otp_digit_limit' => ['required', 'integer'],
            'otp_exp_time' => ['required', 'integer'],
      ]);

      DB::beginTransaction();
      try {
        // Find existing setting (first row only)
        $setting = Setting::first();

        // Now save with updateOrCreate
        Setting::updateOrCreate(
            ['id' => $setting->id ?? null], // if id exists update, else create
            [
                'otp_type'         => $request->otp_type,
                'otp_digit_limit'  => $request->otp_digit_limit,
                'otp_exp_time'     => $request->otp_exp_time,
            ]
        );
      }
      catch(\Exception $ex){
          DB::rollBack();
          // throw $ex;
          // dd($ex->getMessage());
          Toastr::error('There is something wrong', 'Error', ["positionClass" => "toast-top-right"]);
          return redirect()->back();
      }

      DB::commit();
      Toastr::success('Settings data updated', 'Success', ["positionClass" => "toast-top-right"]);
      return redirect()->back();
    }


}
