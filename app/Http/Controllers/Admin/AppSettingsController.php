<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
      $setting = Setting::first();
      return view('admin.pages.app_settings.pos', compact('setting'));
    }

    public function pos_setting_update(Request $request)
    {
      // dd($request->all());

      $request->validate([
          'printer_paper' => ['nullable', 'string', 'max:20'],
          'enable_sound'  => ['nullable']
      ]);

      DB::beginTransaction();
      try {
         $setting = Setting::first();

          // Now save with updateOrCreate
          Setting::updateOrCreate(
              ['id' => $setting->id], 
              [
                  'printer_paper'        => $request->printer_paper,
                  'enable_sound'         => $request->enable_sound ? 1 : 0,
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
        Toastr::success('Data updated', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
  }


}
