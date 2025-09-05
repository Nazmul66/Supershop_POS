<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateRequest;
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
use Illuminate\Support\Str;

class GeneralSettingController extends Controller
{

    use ImageUploadTraits;

    public function profile()
    {
      $setting = Admin::first();
      return view('admin.pages.general_settings.adminProfile', compact('setting'));
    }

    public function profile_update(AdminUpdateRequest $request, $id)
    {
        // dd($request->all());
          DB::beginTransaction();
          try {
            $admin = Admin::findOrFail($id);
  
            // Handle image upload
            if ($admin && $request->hasFile('image')) {
                $imagePath = $this->deleteImageAndUpload($request, 'image', 'admins', $admin->image);
            } elseif (!$admin && $request->hasFile('image')) {
                $imagePath = $this->imageUpload($request, 'image', 'admins');
            } else {
                $imagePath = $admin->image ?? null;
            }
  
            // Now save with updateOrCreate
            Admin::updateOrCreate(
                ['id' => $admin->id], 
                [
                    'name'             => $request->name,
                    'username'         => Str::lower($request->username),
                    'phone'            => $request->phone,
                    'address'          => $request->address,
                    'country'          => $request->country,
                    'state'            => $request->state,
                    'city'             => $request->city,
                    'postal_code'      => $request->postal_code,
                    'image'            => $imagePath,
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

    public function security()
    {
        return view('admin.pages.general_settings.security');
    }
    
     public function notification()
    {
        return view('admin.pages.general_settings.notifications');
    }

}
