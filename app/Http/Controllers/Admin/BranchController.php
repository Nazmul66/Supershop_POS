<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Admin\CreateBranchRequest;
use App\Http\Requests\Admin\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class BranchController extends Controller
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
        return view('admin.pages.branches.index');
    }

    public function getData()
    {
        // get all data
        $branches = Branch::all();

        return DataTables::of($branches)
            ->addIndexColumn()
            ->addColumn('created_by', function ($branch) {
                $adminName = \App\Models\Admin::find($branch->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($branch->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($branch->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                      <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                      <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                      </div>
                </div>';
            })
            ->addColumn('status', function ($branch) {
                if(auth("admin")->user()->can("status.branch"))
                    if ($branch->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$branch->id.'" data-status="'.$branch->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$branch->id.'" data-status="'.$branch->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($branch) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$branch->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.category"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$branch->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.category"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$branch->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['branch' => $branch]);
                return $actionHtml;
            })
            ->rawColumns(['created_by', 'status', 'action'])
            ->make(true);
    }

    public function changeBranchStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.branch')) {
            throw UnauthorizedException::forPermissions(['status.branch']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Branch::findOrFail($id);
        $page->status = $status;
        $page->save();

        //Debugged this code --> return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBranchRequest $request)
    {
        if (!$this->user || !$this->user->can('create.branch')) {
            throw UnauthorizedException::forPermissions(['create.branch']);
        }

        DB::beginTransaction();
        try {

            $branch = new Branch();
            $branch->name                   = $request->name;
            $branch->slug                   = Str::slug($request->name);
            $branch->status                 = $request->status;
            $branch->created_by             = Auth::guard('admin')->id();
            $branch->created_at             = now();
            $branch->updated_at             = now();
            $branch->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Successfully Branch Created!',
            'branch' => [
                'id' => $branch->id,
                'name' => $branch->name,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        if (!$this->user || !$this->user->can('update.branch')) {
            throw UnauthorizedException::forPermissions(['update.branch']);
        }

        // dd($branch);
        return response()->json(['success' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.branch')) {
            throw UnauthorizedException::forPermissions(['update.branch']);
        }

        $branch  = Branch::find($id);

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $branch->name                   = $request->name;
            $branch->slug                   = Str::slug($request->name);
            $branch->status                 = $request->status;
            $branch->updated_by             = Auth::guard('admin')->id();
            $branch->updated_at             = now();
            $branch->save();
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
    public function destroy(Branch $branch)
    {
        if (!$this->user || !$this->user->can('delete.branch')) {
            throw UnauthorizedException::forPermissions(['delete.branch']);
        }

        $branch->delete();

        return response()->json(['message' => 'Branch has been deleted.'], 200);
    }

    public function BranchView($id)
    {
        $branch  = Branch::find($id);
        // dd($branch);

        $statusHtml = '';
        if ($branch->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($branch->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($branch->updated_at));

        return response()->json([
            'success'           => $branch,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allBranchPdf()
    {
        if (!$this->user || !$this->user->can('pdf.branch')) {
            throw UnauthorizedException::forPermissions(['pdf.branch']);
        }
        
        $branches = Branch::get();

        $pdf = Pdf::loadView('admin.pages.branches.pdf', compact('branches'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Branch.pdf');
        // return view('admin.pages.branches.pdf', compact('branches'));
    }
}
