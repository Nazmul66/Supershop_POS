<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRoleRequest;
use App\Http\Requests\Admin\UpdateAdminRoleRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Device;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminRoleController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = Auth::guard('admin')->user();
        if (!$this->user) {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->user || !$this->user->can('index.admin-role')) {
            throw UnauthorizedException::forPermissions(['index.admin-role']);
        }

        $admins = Admin::where('status', 1)->get();
        return view('admin.pages.role_and_permission.admin.index',[
            "admins" => $admins,
        ]);
    }

    public function create()
    {
        if (!$this->user || !$this->user->can('create.admin-role')) {
            throw UnauthorizedException::forPermissions(['create.admin-role']);
        }

        $roles  = Role::where('guard_name', 'admin')->pluck('name', 'name')->all();
        $device = Device::where('status', 1)->select('id', 'branch_id', 'device_name')->get();
        $branch = Branch::where('status', 1)->select('id','name')->get();
        return view('admin.pages.role_and_permission.admin.create',[
            'roles'  => $roles,
            'device' => $device,
            'branch' => $branch,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAdminRoleRequest $request)
    {
        if (!$this->user || !$this->user->can('create.admin-role')) {
            throw UnauthorizedException::forPermissions(['create.admin-role']);
        }
        // dd($request->all());

        DB::beginTransaction();
        try {
           $admin =  Admin::create([
                'current_branch_id'     => $request->branch_name,
                'current_device_id'     => $request->device_name,
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'password'   => Hash::make($request->password),
                'status'     => $request->status,
            ]);

            $admin->syncRoles($request->roles); // sync roles
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            dd($ex->getMessage());
            Toastr::error('New Admin create error', 'Error', ["positionClass" => "toast-top-right"]);
            return back();
        }

        DB::commit();
        Toastr::success('New Admin create successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.admin-role.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!$this->user || !$this->user->can('update.admin-role')) {
            throw UnauthorizedException::forPermissions(['update.admin-role']);
        }

        $admin     = Admin::findOrFail($id);
        $roles     = Role::where('guard_name', 'admin')->pluck('name', 'name')->all();
        $userRoles = $admin->roles->pluck('name', 'name')->all();
        $device = Device::where('status', 1)->select('id', 'branch_id', 'device_name')->get();
        $branch = Branch::where('status', 1)->select('id','name')->get();
        
        return view('admin.pages.role_and_permission.admin.edit',[
            'admin'     => $admin,
            'roles'     => $roles,
            'userRoles' => $userRoles,
            'device'    => $device,
            'branch'    => $branch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRoleRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.admin-role')) {
            throw UnauthorizedException::forPermissions(['update.admin-role']);
        }
        // dd($request->all());

        DB::beginTransaction();
        try {
            $admin = Admin::findOrFail($id);

            // Update admin details
            $admin->update([
                'current_branch_id'     => $request->branch_name,
                'current_device_id'     => $request->device_name,
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => $request->password ? Hash::make($request->password) : $admin->password, // Update password only if provided
                'status'     => $request->status,
            ]);
 
            $admin->syncRoles($request->roles); // sync roles
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            // dd($ex->getMessage());
            Toastr::error('Admin updated error', 'Error', ["positionClass" => "toast-top-right"]);
            return back();
        }

        DB::commit();
        Toastr::success('Admin updated successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.admin-role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!$this->user || !$this->user->can('delete.admin-role')) {
            throw UnauthorizedException::forPermissions(['delete.admin-role']);
        }

        // dd($id);
        $admin = Admin::findOrFail($id);

        if( !empty($admin->image) ){
            @unlink($admin->image);
        }
        $admin->delete();

        Toastr::success('Admin User delete successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

}
