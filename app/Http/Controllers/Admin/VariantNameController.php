<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariantName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Yajra\DataTables\DataTables;

class VariantNameController extends Controller
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
        if (!$this->user || !$this->user->can('index.variant.name')) {
            throw UnauthorizedException::forPermissions(['index.variant.name']);
        }
        return view('admin.pages.variant.variant_name');
    }

    public function getData()
    {
        // get all data
        $variantNames = VariantName::all();

        return DataTables::of($variantNames)
            ->addColumn('name', function ($variantName) {
                return '<span class="btn btn-info">'. $variantName->name .'</span>';
            })
            ->addColumn('created_by', function ($variantName) {
                $adminName = \App\Models\Admin::find($variantName->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($variantName->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($variantName->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                      <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                      <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                      </div>
                </div>';
            })
            ->addColumn('status', function ($variantName) {
                if ($variantName->status == 1) {
                    return ' <a class="status" id="status" href="javascript:void(0)"
                        data-id="'.$variantName->id.'" data-status="'.$variantName->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x text-success"></i>
                    </a>';
                } else {
                    return '<a class="status" id="status" href="javascript:void(0)"
                        data-id="'.$variantName->id.'" data-status="'.$variantName->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                    </a>';
                }
            })

            ->addColumn('action', function ($variantName) {
                $actionHtml = Blade::render('
                    <div class="d-flex gap-3">
                        @if(auth("admin")->user()->can("update.variant.name"))
                            <a class="btn btn-sm btn-primary" id="editButton" href="javascript:void(0)" data-id="'.$variantName->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-edit"></i></a>
                        @endif

                        @if(auth("admin")->user()->can("delete.variant.name"))
                            <a class="btn btn-sm btn-danger" href="javascript:void(0)" data-id="'.$variantName->id.'" id="deleteBtn"> <i class="fas fa-trash"></i></a>
                        @endif
                    </div>
                ', ['variantName' => $variantName]);
                return $actionHtml;
            })
            ->rawColumns(['created_by','name', 'status', 'action'])
            ->make(true);
    }

    public function changeStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.variant.name')) {
            throw UnauthorizedException::forPermissions(['status.variant.name']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = VariantName::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.variant.name')) {
            throw UnauthorizedException::forPermissions(['create.variant.name']);
        }

        $request->validate(
            [
                'name' => ['required', 'unique:variant_names,name', 'max:255'],
            ],
            [
                'name.required' => 'Please fill up the name',
                'name.max' => 'Character might be 255 word',
                'name.unique' => 'Character might be unique',
            ]
        );

        DB::beginTransaction();
        try {

            $variantName = new VariantName();
            $variantName->name           = Str::title($request->name);
            $variantName->status         = 1;
            $variantName->created_by     = Auth::guard('admin')->id();
            $variantName->created_at     = now();
            $variantName->updated_at     = now();

            // dd($variantName);
            $variantName->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Variant Name Created!", 'status' => true]);
    }


    public function edit(VariantName $variantName)
    {
        if (!$this->user || !$this->user->can('update.variant.name')) {
            throw UnauthorizedException::forPermissions(['update.variant.name']);
        }

        // dd($variantName);
        return response()->json(['success' => $variantName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.variant.name')) {
            throw UnauthorizedException::forPermissions(['update.variant.name']);
        }

        $variantName  = VariantName::find($id);
        // dd($variantName);
        $request->validate(
            [
                'name' => ['required', 'max:255', 'unique:variant_names,name,'. $variantName->id ],
            ],
            [
                'name.required' => 'Please fill up the name',
                'name.max' => 'Character might be 255 words',
                'name.unique' => 'Character might be unique',
            ]
        );

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $variantName->name           = Str::title($request->name);
            $variantName->status         = 1;
            $variantName->created_by     = Auth::guard('admin')->id();
            $variantName->updated_at     = now();

            $variantName->save();
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
    public function destroy(VariantName $variantName)
    {
        if (!$this->user || !$this->user->can('delete.variant.name')) {
            throw UnauthorizedException::forPermissions(['delete.variant.name']);
        }
        
        $variantName->delete();
        return response()->json(['message' => 'Variant Name has been deleted.'], 200);
    }

}
