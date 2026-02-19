<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariantName;
use App\Models\VariantValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class VariantValueController extends Controller
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
        if (!$this->user || !$this->user->can('index.attribute')) {
            throw UnauthorizedException::forPermissions(['index.attribute']);
        }

        $variant_names = VariantName::where('status', 1)->get();
        return view('admin.pages.variant.variant_values', compact('variant_names'));
    }

    public function getData()
    {
        // get all data
        $variantValues = VariantValue::get();

        return DataTables::of($variantValues)
            ->addIndexColumn()
            ->addColumn('variant_name', function ($variantValue) {
                return '<span class="btn btn-dark">'. $variantValue->variant_name .'</span>';
            })
            ->addColumn('color_value', function ($variantValue) {
                if ($variantValue->variant_name === 'Color') {
                    return '<div class="d-flex gap-2 align-items-center">
                            <div class="circle_rounded" style="background:'. $variantValue->color_value .'"></div>
                            <span class="text-dark">' . $variantValue->color_value . '</span>
                        </div>
                    ';
                } else {
                    return '<span class="btn btn-danger">N/A</span>';
                }
            })
            ->addColumn('variant_value', function ($variantValue) {
                return '<span class="btn btn-secondary">'. $variantValue->variant_value .'</span>';
            })
            ->addColumn('date_info', function ($variantValue) {
                $created_by = \App\Models\Admin::find($variantValue->created_by)?->name ?? 'Unknown';
                $updated_by = \App\Models\Admin::find($variantValue->updated_by)?->name ?? 'Unknown';

                return '<div class="">
                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Created at:</span> '. $variantValue->created_at->format('M j, Y h:i A') .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Updated at:</span> '. $variantValue->updated_at->format('M j, Y h:i A') .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Created by:</span> '. $created_by.'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Updated by:</span> '. $updated_by .'</p>
                </div>';
            })
            ->addColumn('status', function ($variantValue) {
                if(auth("admin")->user()->can("status.attribute"))
                    if ($variantValue->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$variantValue->id.'" data-status="'.$variantValue->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$variantValue->id.'" data-status="'.$variantValue->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($variantValue) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$variantValue->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.attribute"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$variantValue->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.attribute"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$variantValue->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['variantValue' => $variantValue]);
                return $actionHtml;
            })
            ->rawColumns(['variant_name', 'color_value', 'variant_value', 'status', 'date_info', 'action'])
            ->make(true);
    }

    public function changeStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.attribute')) {
            throw UnauthorizedException::forPermissions(['status.attribute']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = VariantValue::findOrFail($id);
        $page->status = $status;
        $page->save();

        //Debugged this code --> return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.attribute')) {
            throw UnauthorizedException::forPermissions(['create.attribute']);
        }

        // dd($request->all());
        $request->validate(
            [
                'color_value' => ['nullable'],
                'variant_value' => ['required', 'max:255', 'unique:variant_values,variant_value' ],
            ],
            [
                'variant_value.required' => 'Please fill up the variant value',
                'variant_value.max' => 'Character might be 255 word',
                'variant_value.unique' => 'Character might be unique',
            ]
        );

        DB::beginTransaction();
        try {
            $variantValue = new VariantValue();

            $variantValue->variant_name       = $request->variant_name;
            if( $request->variant_name === 'Color' ){
                $variantValue->color_value	  = $request->color_value;
            }
            else{
                $variantValue->color_value	  = null;
            }
            $variantValue->variant_value      = ucwords($request->variant_value);
            $variantValue->status             = 1;
            // dd($variantValue);
            $variantValue->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Variant Value Created!", 'status' => true]);
    }


    public function edit(VariantValue $variantValue)
    {
        if (!$this->user || !$this->user->can('update.attribute')) {
            throw UnauthorizedException::forPermissions(['update.attribute']);
        }

        // dd($variantValue);
        return response()->json(['success' => $variantValue]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.attribute')) {
            throw UnauthorizedException::forPermissions(['update.attribute']);
        }

        $variantValue  = VariantValue::find($id);
        // dd($request->all(), $variantValue);

        $request->validate(
            [
                'color_value' => ['nullable'],
                'variant_value' => ['required', 'max:255', 'unique:variant_values,variant_value,'. $variantValue->id ],
            ],
            [
                'variant_value.required' => 'Please fill up the value',
                'variant_value.max' => 'Character might be 255 word',
                'variant_value.unique' => 'Character might be unique',
            ]
        );

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $variantValue->variant_name       = $request->variant_name;
            if( $request->variant_name === 'Color' ){
                $variantValue->color_value	  = $request->color_value;
            }
            else{
                $variantValue->color_value	  = null;
            }
            $variantValue->variant_value      = ucwords($request->variant_value);
            $variantValue->status             = 1;
            // dd($variantValue);
            $variantValue->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        return response()->json(['message'=> "success"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariantValue $variantValue)
    {
        if (!$this->user || !$this->user->can('delete.attribute')) {
            throw UnauthorizedException::forPermissions(['delete.attribute']);
        }

        $variantValue->delete();
        return response()->json(['message' => 'Variant Value has been deleted.'], 200);
    }

}
