<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTraits;
use App\Models\Warranty;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class WarrantiesController extends Controller
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
        return view('admin.pages.warranties.index');
    }

    public function getData()
    {
        // get all data
        $warranties = Warranty::all();

        return DataTables::of($warranties)
            ->addIndexColumn()
            ->addColumn('duration', function ($warranty) {
                return ' <span> '. $warranty->duration . ' ' . Str::title($warranty->period) .' </span>';
            })
            ->addColumn('created_by', function ($category) {
                $adminName = \App\Models\Admin::find($category->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($category->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($category->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                      <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                      <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                      </div>
                </div>';
            })
            ->addColumn('status', function ($warranty) {
                if(auth("admin")->user()->can("status.warranty"))
                    if ($warranty->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$warranty->id.'" data-status="'.$warranty->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$warranty->id.'" data-status="'.$warranty->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($warranty) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$warranty->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.warranty"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$warranty->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.warranty"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$warranty->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['warranty' => $warranty]);
                return $actionHtml;
            })
            ->rawColumns(['duration', 'created_by', 'status', 'action'])
            ->make(true);
    }

    public function changeWarrantiesStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.warranty')) {
            throw UnauthorizedException::forPermissions(['status.warranty']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Warranty::findOrFail($id);
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
        if (!$this->user || !$this->user->can('create.warranty')) {
            throw UnauthorizedException::forPermissions(['create.warranty']);
        }

        $request->validate([
            'warranty'     => 'required|string|max:255',
            'duration'     => 'required|integer',
            'period'       => 'required|string|max:120',
            'description'  => 'required|string|max:512',
        ]);

        DB::beginTransaction();
        try {

            $warranty     = new Warranty();
            $warranty->warranty               = $request->warranty;
            $warranty->duration               = $request->duration;
            $warranty->period                 = $request->period;
            $warranty->description            = $request->description;
            $warranty->status                 = $request->status;
            $warranty->created_by             = Auth::guard('admin')->id();
            $warranty->created_at             = now();
            $warranty->updated_at             = now();
            $warranty->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        // return response()->json(['message'=> "Successfully Warranty Created!", 'status' => true]);
        return response()->json([
            'status' => true,
            'message'=> "Successfully Warranty Created!", 
            'warranties' => [
                'id'        => $warranty->id,
                'duration'  => $warranty->duration,
                'period'    => ucfirst($warranty->period),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warranty $warranty)
    {
        if (!$this->user || !$this->user->can('update.warranty')) {
            throw UnauthorizedException::forPermissions(['update.warranty']);
        }

        // dd($warranty);
        return response()->json(['success' => $warranty]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!$this->user || !$this->user->can('update.warranty')) {
            throw UnauthorizedException::forPermissions(['update.warranty']);
        }

        $request->validate([
            'warranty'     => 'required|string|max:255',
            'duration'     => 'required|integer',
            'period'       => 'required|string|max:120',
            'description'  => 'required|string|max:512',
        ]);

        $warranty  = Warranty::find($id);

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $warranty->warranty               = $request->warranty;
            $warranty->duration               = $request->duration;
            $warranty->period                 = $request->period;
            $warranty->description            = $request->description;
            $warranty->status                 = $request->status;
            $warranty->created_by             = Auth::guard('admin')->id();
            $warranty->updated_at             = now();
            $warranty->save();
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
    public function destroy(Warranty $warranty)
    {
        if (!$this->user || !$this->user->can('delete.warranty')) {
            throw UnauthorizedException::forPermissions(['delete.warranty']);
        }

        $warranty->delete();
        return response()->json(['message' => 'Warranty has been deleted.'], 200);
    }

    public function warrantiesView($id)
    {
        $warranty  = Warranty::find($id);
        // dd($warranty);

        $statusHtml = '';
        if ($warranty->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($warranty->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($warranty->updated_at));

        return response()->json([
            'success'           => $warranty,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allWarrantiesPdf()
    {
        if (!$this->user || !$this->user->can('pdf.category')) {
            throw UnauthorizedException::forPermissions(['pdf.category']);
        }
        
        $warranties = Warranty::get();

        $pdf = Pdf::loadView('admin.pages.warranties.pdf', compact('warranties'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Warranty.pdf');
        // return view('admin.pages.warranties.pdf', compact('warranties'));
    }
}
