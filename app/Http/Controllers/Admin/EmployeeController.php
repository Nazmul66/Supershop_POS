<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateEmployeeRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use App\Models\Department;
use App\Models\Designation;
use App\Traits\ImageUploadTraits;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class EmployeeController extends Controller
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

        return view('admin.pages.employee.index');
    }

    public function getData()
    {
        // get all data
        $employees = Employee::all();

        return DataTables::of($employees)
            ->addIndexColumn()
            // ->addColumn('categoryImg', function ($employee) {
            //     return '<a href="'.asset( $employee->image ).'" target="__target">
            //          <img src="'.asset( $employee->image ).'" width="50px" height="50px" >
            //     </a>';
            // })
            ->addColumn('status', function ($employee) {
                if(auth("admin")->user()->can("status.category"))
                    if ($employee->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$employee->id.'" data-status="'.$employee->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$employee->id.'" data-status="'.$employee->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($employee) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$employee->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.category"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$employee->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.category"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$employee->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['employee' => $employee]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {        
        $departments  = Department::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();
        $countries    = Country::where('status', 1)->get();
        $cities       = City::where('status', 1)->get();
        $states       = State::where('status', 1)->get();
        return view('admin.pages.employee.create',compact('countries','cities','states','departments','designations'));
    }

    public function changeEmployeeStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.category')) {
            throw UnauthorizedException::forPermissions(['status.category']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Employee::findOrFail($id);
        $page->status = $status;
        $page->save();

        //Debugged this code --> return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        // dd($request->all());
        if (!$this->user || !$this->user->can('create.category')) {
            throw UnauthorizedException::forPermissions(['create.category']);
        }

        // dd($request->all());
        // DB::beginTransaction();
        // try {
            $lastId = Employee::max('id') ?? 1; 
            // dd($request->all());

            $employee     = new Employee();
            $employee->first_name             = $request->first_name;
            $employee->last_name              = $request->last_name;
            $employee->email                  = $request->email;
            $employee->contact_number         = $request->contact_number;
            $employee->employee_code          = getSetting()->employee_prefix . 1000 + $lastId;
            $employee->date_of_birth          = $request->date_of_birth;
            $employee->gender                 = $request->gender;
            $employee->nationality            = $request->nationality;
            $employee->religion               = $request->religion;
            $employee->joining_date           = $request->joining_date;
            $employee->department_id          = $request->department_id;
            $employee->designation_id         = $request->designation_id;
            $employee->blood_group            = $request->blood_group;
            $employee->about                  = $request->about;
            $employee->address                = $request->address;
            $employee->country_id             = $request->country_id;
            $employee->city_id                = $request->city_id;
            $employee->state_id               = $request->state_id;
            $employee->zip_code               = $request->zip_code;
            $employee->emergency_number_1     = $request->emergency_number_1;
            $employee->emergency_number_2     = $request->emergency_number_2;
            $employee->emergency_relation_1   = $request->emergency_relation_1;
            $employee->emergency_relation_2   = $request->emergency_relation_2;
            $employee->relation_name_1        = $request->relation_name_1;
            $employee->relation_name_2        = $request->relation_name_2;
            $employee->bank_name              = $request->bank_name;
            $employee->account_number         = $request->account_number;
            $employee->routing_number         = $request->routing_number;
            $employee->branch_name            = $request->branch_name;
            $employee->status                 = $request->status;


            // Handle image with ImageUploadTraits function
            $uploadImage                      = $this->imageUpload($request, 'image', 'employee');

            $employee->image           =  $uploadImage;
            $employee->save();
            dd($employee);
        // }
        // catch(\Exception $ex){
        //     DB::rollBack();
        //     throw $ex;
        //     // dd($ex->getMessage());
        // }

        // DB::commit();
        return redirect()->route('admin.hrm.employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        if (!$this->user || !$this->user->can('update.category')) {
            throw UnauthorizedException::forPermissions(['update.category']);
        }

        $departments  = Department::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();
        $countries    = Country::where('status', 1)->get();
        $cities       = City::where('status', 1)->get();
        $states       = State::where('status', 1)->get();
        return view('admin.pages.employee.edit',compact('countries','cities','states','departments','designations', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.category')) {
            throw UnauthorizedException::forPermissions(['update.category']);
        }

        $employee  = Employee::find($id);

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $category->category_name          = $request->category_name;
            $category->slug                   = Str::slug($request->category_name);
            $category->front_status           = $request->front_status;
            $category->status                 = $request->status;

            $uploadImages                     = $this->deleteImageAndUpload($request, 'category_img', 'category', $category->category_img );
            $category->category_img           =  $uploadImages;

            $category->save();
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
    public function destroy(Employee $employee)
    {
        if (!$this->user || !$this->user->can('delete.category')) {
            throw UnauthorizedException::forPermissions(['delete.category']);
        }

        if ($employee->image) {
            if (file_exists($employee->image)) {
                unlink($employee->image);
            }
        }

        $employee->delete();

        return response()->json(['message' => 'Employee has been deleted.'], 200);
    }

    public function employeeView($id)
    {
        $employee  = Employee::find($id);
        // dd($employee);

        $statusHtml = '';
        if ($employee->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($employee->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($employee->updated_at));

        return response()->json([
            'success'           => $employee,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }



    public function allEmployeePdf()
    {
        if (!$this->user || !$this->user->can('pdf.category')) {
            throw UnauthorizedException::forPermissions(['pdf.category']);
        }
        
        $employees = Employee::get();

        $pdf = Pdf::loadView('admin.pages.employee.pdf', compact('employees'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Employees.pdf');
        // return view('admin.pages.employee.pdf', compact('employees'));
    }
}
