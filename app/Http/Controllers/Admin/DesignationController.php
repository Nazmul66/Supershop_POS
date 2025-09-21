<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DesignationController extends Controller
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
        $departments = Department::where('status', 1)->get();
        return view('admin.pages.designation.index', compact('departments'));
    }

    public function getData()
    {
        // get all data
        $designations = Designation::leftJoin('departments', 'departments.id', 'designations.department_id')
                ->select('designations.*', 'departments.department')
                ->get();

        return DataTables::of($designations)
            ->addIndexColumn()
            ->addColumn('department', function ($designation) {
                 return $designation->department;
            })
            ->addColumn('members', function ($designation) {
                $total_members = \App\Models\Employee::where('designation_id', $designation->id)->get();
                $html = '<div class="avatar-list-stacked avatar-group-sm">';
            
                if ($total_members->count() <= 3) {
                    foreach ($total_members as $item) {
                        $html .= '<span class="avatar avatar-rounded">
                                    <img class="border border-white" src="' . asset($item->image ?? 'default.jpg') . '" alt="img">
                                  </span>';
                    }
                } else {
                    foreach ($total_members->take(4) as $item) {
                        $html .= '<span class="avatar avatar-rounded">
                                    <img class="border border-white" src="' . asset($item->image ?? 'default.jpg') . '" alt="img">
                                  </span>';
                    }
            
                    // Random image for the "+X"
                    $randomImage = $total_members->random()->image ?? 'default.jpg';
                    $remaining   = $total_members->count() - 4;
            
                    $html .= '<a class="avatar avatar-rounded text-fixed-white fs-10 fw-medium position-relative" href="javascript:void(0);">
                                <img src="' . asset($randomImage) . '" alt="img">
                                <span class="position-absolute top-50 start-50 translate-middle text-center">+' . $remaining . '</span>
                              </a>';
                }
            
                $html .= '</div>';
            
                return $html;
            })
            ->addColumn('total_members', function ($designation) {
                $total_members_count = \App\Models\Employee::where('designation_id', $designation->id)->get()->count();
                return $total_members_count;
            })
            ->addColumn('status', function ($designation) {
                if(auth("admin")->user()->can("status.designation"))
                    if ($designation->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$designation->id.'" data-status="'.$designation->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$designation->id.'" data-status="'.$designation->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($designation) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$designation->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.designation"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$designation->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.designation"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$designation->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['designation' => $designation]);
                return $actionHtml;
            })
            ->rawColumns(['department', 'members', 'total_members', 'status', 'action'])
            ->make(true);
    }

    public function changeDesignationStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.designation')) {
            throw UnauthorizedException::forPermissions(['status.designation']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Designation::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.designation')) {
            throw UnauthorizedException::forPermissions(['create.designation']);
        }

        $request->validate([
            'designation'      => 'required|string|max:150|unique:designations,designation',
            'department_id'    => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $designation                         =  new Designation();
            $designation->designation            = Str::title($request->designation);
            $designation->department_id          = $request->department_id;
            $designation->status                 = $request->status;
            $designation->created_at             = now();
            $designation->updated_at             = now();
            // dd($designation);
            $designation->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Designation Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        if (!$this->user || !$this->user->can('update.designation')) {
            throw UnauthorizedException::forPermissions(['update.designation']);
        }

        // dd($designation);
        return response()->json(['success' => $designation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.designation')) {
            throw UnauthorizedException::forPermissions(['update.designation']);
        }

        $request->validate([
            'designation'      => 'required|string|max:150|unique:designations,designation,'.$id,
            'department_id'    => 'required|integer',
        ]);

        $designation  = Designation::find($id);

        DB::beginTransaction();
        try {
            $designation->designation            = Str::title($request->designation);
            $designation->department_id          = $request->department_id;
            $designation->status                 = $request->status;
            $designation->updated_at             = now();
            $designation->save();
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
    public function destroy(Designation $designation)
    {
        if (!$this->user || !$this->user->can('delete.designation')) {
            throw UnauthorizedException::forPermissions(['delete.designation']);
        }

        $designation->delete();
        return response()->json(['message' => 'Designation has been deleted.'], 200);
    }


    public function designationView($id)
    {
        $designation = Designation::leftJoin('departments', 'departments.id', 'designations.department_id')
            ->select('designations.*', 'departments.department')
            ->where('designations.id', $id)
            ->first();
        // dd($designation);

        $total_members_count = \App\Models\Employee::where('designation_id', $id)->get()->count();

        $statusHtml = '';
        if ($designation->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $total_members = \App\Models\Employee::where('designation_id', $designation->id)->get();
        $html = '<div class="avatar-list-stacked avatar-group-sm">';
    
        if ($total_members->count() <= 3) {
            foreach ($total_members as $item) {
                $html .= '<span class="avatar avatar-rounded">
                            <img class="border border-white" src="' . asset($item->image ?? 'default.jpg') . '" alt="img">
                            </span>';
            }
        } else {
            foreach ($total_members->take(4) as $item) {
                $html .= '<span class="avatar avatar-rounded">
                            <img class="border border-white" src="' . asset($item->image ?? 'default.jpg') . '" alt="img">
                            </span>';
            }
    
            // Random image for the "+X"
            $randomImage = $total_members->random()->image ?? 'default.jpg';
            $remaining   = $total_members->count() - 4;
    
            $html .= '<a class="avatar avatar-rounded text-fixed-white fs-10 fw-medium position-relative" href="javascript:void(0);">
                        <img src="' . asset($randomImage) . '" alt="img">
                        <span class="position-absolute top-50 start-50 translate-middle text-center">+' . $remaining . '</span>
                        </a>';
        }
    
        $html .= '</div>';

        $created_date = date('d F, Y', strtotime($designation->created_at));
        $updated_date = date('d F, Y', strtotime($designation->updated_at));

        return response()->json([
            'success'               => $designation,
            'statusHtml'            => $statusHtml,
            'members'               => $html,
            'total_members_count'   => $total_members_count,
            'created_date'          => $created_date,
            'updated_date'          => $updated_date,
        ]);
    }


    public function allDesignationPdf()
    {
        if (!$this->user || !$this->user->can('pdf.designation')) {
            throw UnauthorizedException::forPermissions(['pdf.designation']);
        }
        
        $designations = Designation::leftJoin('departments', 'departments.id', 'designations.department_id')
                ->select('designations.*', 'departments.department')
                ->get();

        $pdf = Pdf::loadView('admin.pages.designation.pdf', compact('designations'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Designation.pdf');
        // return view('admin.pages.designation.pdf', compact('designations'));
    }

}
