<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyUpdateRequest;
use App\Http\Requests\Admin\LocalizationUpdateRequest;
use App\Models\CredentialSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageUploadTraits;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class WebsiteSetController extends Controller
{

    use ImageUploadTraits;

    public function system_settings()
    {
      $setting = CredentialSetting::first();
      return view('admin.pages.website_settings.system_settings', compact('setting'));
    }

    public function system_update(Request $request)
    {
      //  dd($request->all());
      $request->validate([
          'rechaptcha_secrect_key'     => ['nullable'],
          'rechaptcha_site_key'        => ['nullable'],
          'google_map_id'              => ['nullable'],
          'google_tag_manager'         => ['nullable'],
          'facebook_pixel_id'          => ['nullable'],
      ]);
      
       DB::beginTransaction();
        try {
          $setting = CredentialSetting::first();

          $rechaptcha_secrect_key = $request->rechaptcha_secrect_key ?? $setting->rechaptcha_secrect_key;
          $rechaptcha_site_key    = $request->rechaptcha_site_key ?? $setting->rechaptcha_site_key;
          $google_map_id          = $request->google_map_id ?? $setting->google_map_id;
          $google_tag_manager     = $request->google_tag_manager ?? $setting->google_tag_manager;
          $facebook_pixel_id      = $request->facebook_pixel_id ?? $setting->facebook_pixel_id;    

          // Now save with updateOrCreate
          CredentialSetting::updateOrCreate(
              ['id' => $setting->id ?? null], // if id exists update, else create
              [
                  'rechaptcha_secrect_key'        => $rechaptcha_secrect_key,
                  'rechaptcha_site_key'           => $rechaptcha_site_key,
                  'google_map_id'                 => $google_map_id,
                  'google_tag_manager'            => $google_tag_manager,
                  'facebook_pixel_id'             => $facebook_pixel_id,
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

    public function company_settings()
    {
      $setting = Setting::first();
      return view('admin.pages.website_settings.company_settings', compact('setting'));
    }

    public function company_update(CompanyUpdateRequest $request)
    {
      // dd($request->all());
        DB::beginTransaction();
        try {
          // Find existing setting (first row only)
          $setting = Setting::first();

          // Handle logo upload
          if ($setting && $request->hasFile('logo')) {
              $logoPath = $this->deleteImageAndUpload($request, 'logo', 'settings', $setting->logo);
          } elseif (!$setting && $request->hasFile('logo')) {
              $logoPath = $this->imageUpload($request, 'logo', 'settings');
          } else {
              $logoPath = $setting->logo ?? null;
          }


          // Handle icon upload
          if ($setting && $request->hasFile('icon')) {
            $iconPath = $this->deleteImageAndUpload($request, 'icon', 'settings', $setting->icon);
          } elseif (!$setting && $request->hasFile('icon')) {
              $iconPath = $this->imageUpload($request, 'icon', 'settings');
          } else {
              $iconPath = $setting->icon ?? null;
          }


        // Handle logo upload
        if ($setting && $request->hasFile('favicon')) {
          $faviconPath = $this->deleteImageAndUpload($request, 'favicon', 'settings', $setting->favicon);
        } elseif (!$setting && $request->hasFile('favicon')) {
            $faviconPath = $this->imageUpload($request, 'favicon', 'settings');
        } else {
            $faviconPath = $setting->favicon ?? null;
        }


        // Handle logo upload
        if ($setting && $request->hasFile('dark_logo')) {
          $darkLogoPath = $this->deleteImageAndUpload($request, 'dark_logo', 'settings', $setting->favicon);
        } elseif (!$setting && $request->hasFile('dark_logo')) {
            $darkLogoPath = $this->imageUpload($request, 'dark_logo', 'settings');
        } else {
            $darkLogoPath = $setting->dark_logo ?? null;
        }

          // Now save with updateOrCreate
          Setting::updateOrCreate(
              ['id' => $setting->id ?? null], // if id exists update, else create
              [
                  'site_name'        => $request->site_name,
                  'email'            => $request->email,
                  'phone'            => $request->phone,
                  'fax'              => $request->fax,
                  'address'          => $request->address,
                  'website'          => $request->website,
                  'country'          => $request->country,
                  'state'            => $request->state,
                  'city'             => $request->city,
                  'postal_code'      => $request->postal_code,
                  'logo'             => $logoPath,
                  'icon'             => $iconPath,
                  'favicon'          => $faviconPath,
                  'dark_logo'        => $darkLogoPath,
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
    
     public function localization()
    {
      $setting = Setting::first();
      return view('admin.pages.website_settings.localization_settings', compact('setting'));
    }

    public function localization_update(LocalizationUpdateRequest $request)
    {
      // dd($request->all());
        DB::beginTransaction();
        try {
          // Find existing setting (first row only)
          $setting = Setting::first();

          // Now save with updateOrCreate
          $data = Setting::updateOrCreate(
              ['id' => $setting->id ?? null], // if id exists update, else create
              [
                  'timeZone'         => $request->timeZone,
                  'date_format'      => $request->date_format,
                  'time_format'      => $request->time_format,
                  'month_format'     => $request->month_format,
                  'currency_name'    => $request->currency_name,
                  'currency_symbol'  => $request->currency_symbol,
                  'restrict_country' => $request->restrict_country,
                  'allow_files'      => $request->allow_files,
                  'file_size'        => $request->file_size,
              ]
          );

          // dd($data);
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

     public function prefixes()
    {
      $setting = Setting::first();
      return view('admin.pages.website_settings.prefixes_settings', compact('setting'));
    }
    
    public function prefixes_update(Request $request)
    {
      // dd($request->all());
        DB::beginTransaction();
        try {
          $setting = Setting::first();

          // Now save with updateOrCreate
          Setting::updateOrCreate(
              ['id' => $setting->id ?? null], // if id exists update, else create
              [
                  'product_prefix'                 => $request->product_prefix,
                  'supplier_prefix'                => $request->supplier_prefix,
                  'purchase_prefix'                => $request->purchase_prefix,
                  'purchase_return_prefix'         => $request->purchase_return_prefix,
                  'sales_return_prefix'            => $request->sales_return_prefix,
                  'sales_prefix'                   => $request->sales_prefix,
                  'customer_prefix'                => $request->customer_prefix,
                  'expense_prefix'                 => $request->expense_prefix,
                  'stock_transfer_prefix'          => $request->stock_transfer_prefix,
                  'stock_adjustment_prefix'        => $request->stock_adjustment_prefix,
                  'pos_invoice_prefix'             => $request->pos_invoice_prefix,
                  'sales_order_prefix'             => $request->sales_order_prefix,
                  'estimate_prefix'                => $request->estimate_prefix,
                  'transaction_prefix'             => $request->transaction_prefix,
                  'employee_prefix'                => $request->employee_prefix,
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
    


    public function language()
    {
      return view('admin.pages.website_settings.language_settings');
    }


}
