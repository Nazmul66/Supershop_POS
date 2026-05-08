<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Admin\CreateDeviceRequest;
use App\Http\Requests\Admin\UpdateDeviceRequest;
use App\Models\Branch;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DeviceController extends Controller
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
        $branches = Branch::where('status', 1)->get();
        return view('admin.pages.device.index', compact('branches'));
    }

    public function getData()
    {
        // get all data
        $devices = Device::all();

        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('created_by', function ($device) {
                $adminName = \App\Models\Admin::find($device->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($device->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($device->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                      <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                      <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                      </div>
                </div>';
            })
            ->addColumn('status', function ($device) {
                if(auth("admin")->user()->can("status.device"))
                    if ($device->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$device->id.'" data-status="'.$device->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$device->id.'" data-status="'.$device->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($device) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$device->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.device"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$device->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.device"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$device->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['device' => $device]);
                return $actionHtml;
            })
            ->rawColumns(['created_by', 'status', 'action'])
            ->make(true);
    }

    public function changeDeviceStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.device')) {
            throw UnauthorizedException::forPermissions(['status.device']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Device::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDeviceRequest $request)
    {
        if (!$this->user || !$this->user->can('create.device')) {
            throw UnauthorizedException::forPermissions(['create.device']);
        }

        DB::beginTransaction();
        try {
            $device = new Device();
            $device->branch_id              = $request->branch_id;
            $device->device_code            = Str::upper(Str::slug($request->device_code));
            $device->device_name            = $request->device_name;
            $device->ip_address             = $request->ip_address;
            $device->last_active_at         = $request->last_active_at;
            $device->is_online              = $request->is_online ?? 1;
            $device->status                 = $request->status;
            $device->created_by             = Auth::guard('admin')->id();
            $device->created_at             = now();
            $device->updated_at             = now();
            $device->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Successfully Device Created!',
            'device' => [
                'id' => $device->id,
                'name' => $device->name,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        if (!$this->user || !$this->user->can('update.device')) {
            throw UnauthorizedException::forPermissions(['update.device']);
        }

        // dd($device);
        return response()->json(['success' => $device]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.device')) {
            throw UnauthorizedException::forPermissions(['update.device']);
        }

        $device  = Device::find($id);
        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $device->branch_id              = $request->branch_id;
            $device->device_code            = Str::upper(Str::slug($request->device_code));
            $device->device_name            = $request->device_name;
            $device->ip_address             = $request->ip_address;
            $device->last_active_at         = $request->last_active_at;
            $device->is_online              = $request->is_online;
            $device->status                 = $request->status;
            $device->updated_by             = Auth::guard('admin')->id();
            $device->updated_at             = now();
            $device->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "success"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        if (!$this->user || !$this->user->can('delete.device')) {
            throw UnauthorizedException::forPermissions(['delete.device']);
        }

        $device->delete();
        return response()->json(['message' => 'Device has been deleted.'], 200);
    }

    public function deviceView($id)
    {
        $device  = Device::find($id);
        // dd($device);

        $statusHtml = '';
        if ($device->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($device->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($device->updated_at));

        return response()->json([
            'success'           => $device,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allDevicePdf()
    {
        if (!$this->user || !$this->user->can('pdf.device')) {
            throw UnauthorizedException::forPermissions(['pdf.device']);
        }
        
        $devices = Device::get();

        $pdf = Pdf::loadView('admin.pages.device.pdf', compact('devices'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Device.pdf');
        // return view('admin.pages.device.pdf', compact('devices'));
    }
}