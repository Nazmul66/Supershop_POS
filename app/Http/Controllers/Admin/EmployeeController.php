<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateEmployeeRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use App\Models\Department;
use App\Models\Designation;
use App\Traits\ImageUploadTraits;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
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
        $all_employees = Employee::leftJoin('departments', 'departments.id', 'employees.department_id')
                    ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                    ->leftJoin('cities', 'cities.id', 'employees.city_id')
                    ->leftJoin('states', 'states.id', 'employees.state_id')
                    ->leftJoin('countries', 'countries.id', 'employees.country_id')
                    ->select('employees.*', 'designations.designation', 'departments.department', 'cities.city_name', 'countries.country_name', 'states.state_name')
                    ->get();

        $total_employee    = Employee::count();
        $active_employee   = Employee::where('status', 1)->count();
        $inActive_employee = Employee::where('status', 0)->count();
        $new_employee      = Employee::where('joining_date', '>=', now()->subMonths(3))->count();

        return view('admin.pages.employee.index', compact('all_employees', 'total_employee', 'active_employee', 'inActive_employee', 'new_employee'));
    }

    public function create()
    {        
        if (!$this->user || !$this->user->can('create.employee')) {
            throw UnauthorizedException::forPermissions(['create.employee']);
        }

        $departments  = Department::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();
        $countries    = Country::where('status', 1)->get();
        $cities       = City::where('status', 1)->get();
        $states       = State::where('status', 1)->get();
        return view('admin.pages.employee.create',compact('countries','cities','states','departments','designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        if (!$this->user || !$this->user->can('create.employee')) {
            throw UnauthorizedException::forPermissions(['create.employee']);
        }

        // dd($request->all());
        DB::beginTransaction();
        try {
            $lastId = Employee::max('id') ?? 1; 

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
            // dd($employee);
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            // dd($ex->getMessage());
            Toastr::error('There is something wrong', 'Success', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Employee Created Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.hrm.employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        if (!$this->user || !$this->user->can('update.employee')) {
            throw UnauthorizedException::forPermissions(['update.employee']);
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
        if (!$this->user || !$this->user->can('update.employee')) {
            throw UnauthorizedException::forPermissions(['update.employee']);
        }

        $employee  = Employee::find($id);

        DB::beginTransaction();
        try {
            $employee->first_name             = $request->first_name;
            $employee->last_name              = $request->last_name;
            $employee->email                  = $request->email;
            $employee->contact_number         = $request->contact_number;
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

            $uploadImages                     = $this->deleteImageAndUpload($request, 'image', 'employee', $employee->image );
            $employee->image                 =  $uploadImages;

            $employee->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            Toastr::error('There is something wrong', 'Success', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Employee Updated Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.hrm.employee.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if (!$this->user || !$this->user->can('delete.employee')) {
            throw UnauthorizedException::forPermissions(['delete.employee']);
        }

        if ($employee->image) {
            if (file_exists($employee->image)) {
                unlink($employee->image);
            }
        }

        $employee->delete();
        return response()->json(['message' => 'Employee has been deleted.'], 200);
    }


    public function allEmployeePdf()
    {
        if (!$this->user || !$this->user->can('pdf.employee')) {
            throw UnauthorizedException::forPermissions(['pdf.employee']);
        }
        
        $employees = Employee::leftJoin('departments', 'departments.id', 'employees.department_id')
                    ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                    ->leftJoin('cities', 'cities.id', 'employees.city_id')
                    ->leftJoin('states', 'states.id', 'employees.state_id')
                    ->leftJoin('countries', 'countries.id', 'employees.country_id')
                    ->select('employees.*', 'designations.designation', 'departments.department', 'cities.city_name', 'countries.country_name', 'states.state_name')
                    ->get();

        $pdf = Pdf::loadView('admin.pages.employee.pdf', compact('employees'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Employees.pdf');
        // return view('admin.pages.employee.pdf', compact('employees'));
    }


    public function employeeView($id)
    {
        // dd($id);
        $employee = Employee::leftJoin('departments', 'departments.id', 'employees.department_id')
                    ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                    ->leftJoin('cities', 'cities.id', 'employees.city_id')
                    ->leftJoin('states', 'states.id', 'employees.state_id')
                    ->leftJoin('countries', 'countries.id', 'employees.country_id')
                    ->select('employees.*', 'designations.designation', 'departments.department', 'cities.city_name', 'countries.country_name', 'states.state_name')
                    ->where('employees.id', $id)
                    ->first();

        return view('admin.pages.employee.view', compact('employee'));
    }
}
