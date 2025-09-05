<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\BanIp;
use App\Traits\ImageUploadTraits;
use App\Models\Brand;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class BannedIpController extends Controller
{
    use ImageUploadTraits;
    
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
        return view('admin.pages.other_settings.ban_ip_address');
    }

    public function getData()
    {
        // get all data
        $banIps = BanIp::all();

        return DataTables::of($banIps)
            ->addIndexColumn()
            ->addColumn('status', function ($banIp) {
                if(auth("admin")->user()->can("status.banip"))
                    if ($banIp->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$banIp->id.'" data-status="'.$banIp->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$banIp->id.'" data-status="'.$banIp->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('date_time', function ($banIp) {
                $time = date('d M Y', strtotime($banIp->updated_at));
                return $time;
            })
            ->addColumn('description', function ($banIp) {
                return Str::limit($banIp->description, 17);
            })
            ->addColumn('action', function ($banIp) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            @if(auth("admin")->user()->can("update.banip"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$banIp->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.banip"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$banIp->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['banIp' => $banIp]);
                return $actionHtml;
            })
            ->rawColumns(['description', 'date_time', 'status', 'action'])
            ->make(true);
    }

    public function changeBanIpStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.banip')) {
            throw UnauthorizedException::forPermissions(['status.banip']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = BanIp::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.banip')) {
            throw UnauthorizedException::forPermissions(['create.banip']);
        }

        $request->validate([
            'ip_address'  => ['required', 'string', 'unique:ban_ips,ip_address'],
            'description' => ['required', 'string', 'max:512'],
        ]);

        DB::beginTransaction();
        try {
            $banIp = new BanIp();
            $banIp->ip_address             = $request->ip_address;
            $banIp->description            = $request->description;
            $banIp->status                 = $request->status;
            $banIp->created_at             = now();
            $banIp->updated_at             = now();

            // dd($banIp);
            $banIp->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Brand Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BanIp $banIp)
    {
        if (!$this->user || !$this->user->can('update.banip')) {
            throw UnauthorizedException::forPermissions(['update.banip']);
        }

        // dd($category);
        return response()->json(['success' => $banIp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.banip')) {
            throw UnauthorizedException::forPermissions(['update.banip']);
        }

        $request->validate([
            'ip_address'  => 'required|string|unique:ban_ips,ip_address,' . $id,
            'description' => ['required', 'string', 'max:512'],
        ]);

        $banIp  = BanIp::find($id);

        DB::beginTransaction();
        try {
            $banIp->ip_address             = $request->ip_address;
            $banIp->description            = $request->description;
            $banIp->status                 = $request->status;
            $banIp->updated_at             = now();
            $banIp->save();
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
    public function destroy(BanIp $banIp)
    {
        if (!$this->user || !$this->user->can('delete.banip')) {
            throw UnauthorizedException::forPermissions(['delete.banip']);
        }

        $banIp->delete();
        return response()->json(['message' => 'banIp has been deleted.'], 200);
    }

}
