<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyUpdateRequest;
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
      return view('admin.pages.website_settings.system_settings');
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
