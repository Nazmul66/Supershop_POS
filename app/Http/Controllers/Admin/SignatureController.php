<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Signature;
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

class SignatureController extends Controller
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
        return view('admin.pages.app_settings.signature');
    }

    public function getData()
    {
        // get all data
        $signatures = Signature::all();

        return DataTables::of($signatures)
            ->addIndexColumn()
            ->addColumn('image', function ($signature) {
                return '<a href="'.asset( $signature->image ).'" target="__blank">
                     <img src="'.asset( $signature->image ).'" width="50px" height="50px">
                </a>';
            })
            ->addColumn('status', function ($signature) {
                if(auth("admin")->user()->can("status.banip"))
                    if ($signature->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$signature->id.'" data-status="'.$signature->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$signature->id.'" data-status="'.$signature->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($signature) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            @if(auth("admin")->user()->can("update.banip"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$signature->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.banip"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$signature->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['signature' => $signature]);
                return $actionHtml;
            })
            ->rawColumns(['image','status', 'action'])
            ->make(true);
    }

    public function changeSignatureStatus(Request $request)
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

        $page = Signature::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!$this->user || !$this->user->can('create.banip')) {
            throw UnauthorizedException::forPermissions(['create.banip']);
        }

        $request->validate([
            'name' => ['required', 'unique:signatures,name', 'max:255'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:3072'],
        ]);

        DB::beginTransaction();
        try {
            $signature = new Signature();
            $signature->name                   = $request->name;
            $signature->status                 = $request->status ? 1 : 0;
            $signature->created_at             = now();
            $signature->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImage                   = $this->imageUpload($request, 'image', 'signatures');
            $signature->image              =  $uploadImage;

            // dd($signature);
            $signature->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Signature Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signature $signature)
    {
        if (!$this->user || !$this->user->can('update.banip')) {
            throw UnauthorizedException::forPermissions(['update.banip']);
        }

        // dd($category);
        return response()->json(['success' => $signature]);
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
            'name' => 'required|string|unique:signatures,name,' . $id, 'max:255',
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:3072'],
        ]);

        $signature  = Signature::find($id);

        DB::beginTransaction();
        try {
            $signature->name                   = $request->name;
            $signature->status                 = $request->status ? 1 : 0;
            $signature->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'signatures', $signature->image );
            $signature->image                  =  $uploadImages;

            $signature->save();
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
    public function destroy(Signature $signature)
    {
        if (!$this->user || !$this->user->can('delete.banip')) {
            throw UnauthorizedException::forPermissions(['delete.banip']);
        }

        if ($signature->image) {
            if (file_exists($signature->image)) {
                unlink($signature->image);
            }
        }

        $signature->delete();
        return response()->json(['message' => 'Signature has been deleted.'], 200);
    }

}
