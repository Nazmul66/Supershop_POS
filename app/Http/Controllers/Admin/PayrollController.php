<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePayrollRequest;
use App\Http\Requests\Admin\UpdatePayrollRequest;
use App\Traits\ImageUploadTraits;
use App\Models\Employee;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PayrollController extends Controller
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
        $employees = Employee::where('status', 1)->get();
        return view('admin.pages.payroll.index', compact('employees'));
    }

    public function getData()
    {
        // get all data
        $payrolls = Payroll::leftJoin('employees', 'employees.id', 'payrolls.employee_id')
                ->leftJoin('countries', 'countries.id', 'employees.country_id')
                ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                ->select('payrolls.*', 'employees.first_name', 'employees.last_name', 'employees.email', 'employees.employee_code', 'employees.image', 'designations.designation', 'countries.country_name')
                ->get();

        return DataTables::of($payrolls)
            ->addIndexColumn()
            ->addColumn('employee', function ($payroll) {
                return '<div class="d-flex align-items-center">
                    <a href="employee-details.html" class="avatar avatar-md"><img src="'. asset($payroll->image) .'" class="img-fluid" alt="img"></a>
                    <div class="ms-2">
                        <p class="text-dark mb-0"><a href="employee-details.html">'. $payroll->first_name . ' ' . $payroll->last_name .'</a></p>
                        <p><a>'. $payroll->designation .'</a></p>
                    </div>
                </div>';
            })
            ->addColumn('salary', function ($payroll) {
                $total_earnings = $payroll->basic_salary + $payroll->hra_allow + $payroll->conveyance + $payroll->medical_allow + $payroll->bonus;

                $total_deductions = $payroll->provident_fund + $payroll->professional_tax + $payroll->tds + $payroll->loan_others;

                $net_salary = $total_earnings - $total_deductions;
                return '$' . $net_salary;
            })
            ->addColumn('status', function ($payroll) {
                if(auth("admin")->user()->can("status.brand"))
                    if ($payroll->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$payroll->id.'" data-status="'.$payroll->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$payroll->id.'" data-status="'.$payroll->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($payroll) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="'. route('admin.hrm.payroll.payslip', $payroll->id) .'">
                                <i class="fas fa-eye"></i> View
                            </a> 

                            @if(auth("admin")->user()->can("update.brand"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$payroll->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.brand"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$payroll->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['payroll' => $payroll]);
                return $actionHtml;
            })
            ->rawColumns(['employee', 'salary', 'status', 'action'])
            ->make(true);
    }

    public function changePayrollStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.brand')) {
            throw UnauthorizedException::forPermissions(['status.brand']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Payroll::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePayrollRequest $request)
    {
        // dd($request->all());
        if (!$this->user || !$this->user->can('create.brand')) {
            throw UnauthorizedException::forPermissions(['create.brand']);
        }

        // DB::beginTransaction();
        try {
            $payroll = new Payroll();
            $payroll->employee_id            = $request->employee_id;
            $payroll->basic_salary           = $request->basic_salary;
            $payroll->hra_allow              = $request->hra_allow;
            $payroll->conveyance             = $request->conveyance;
            $payroll->medical_allow          = $request->medical_allow;
            $payroll->bonus                  = $request->bonus;
            $payroll->provident_fund         = $request->provident_fund;
            $payroll->professional_tax       = $request->professional_tax;
            $payroll->tds                    = $request->tds;
            $payroll->loan_others            = $request->loan_others;
            $payroll->status                 = $request->status;
            $payroll->created_at             = now();
            $payroll->updated_at             = now();

            // dd($payroll);
            $payroll->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Payroll Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        // dd($payroll);
        return response()->json(['success' => $payroll]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        $payroll  = Payroll::find($id);

        DB::beginTransaction();
        try {
            $payroll->employee_id            = $request->employee_id;
            $payroll->basic_salary           = $request->basic_salary;
            $payroll->hra_allow              = $request->hra_allow;
            $payroll->conveyance             = $request->conveyance;
            $payroll->medical_allow          = $request->medical_allow;
            $payroll->bonus                  = $request->bonus;
            $payroll->provident_fund         = $request->provident_fund;
            $payroll->professional_tax       = $request->professional_tax;
            $payroll->tds                    = $request->tds;
            $payroll->loan_others            = $request->loan_others;
            
            $payroll->save();
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
    public function destroy(Payroll $payroll)
    {
        if (!$this->user || !$this->user->can('delete.brand')) {
            throw UnauthorizedException::forPermissions(['delete.brand']);
        }

        $payroll->delete();
        return response()->json(['message' => 'Payroll has been deleted.'], 200);
    }


    // public function payrollView($id)
    // {
    //     // $payroll  = Payroll::find($id);
    //     $payroll = Payroll::leftJoin('employees', 'employees.id', 'payrolls.employee_id')
    //             ->leftJoin('countries', 'countries.id', 'employees.country_id')
    //             ->leftJoin('designations', 'designations.id', 'employees.designation_id')
    //             ->select('payrolls.*', 'employees.first_name', 'employees.last_name', 'employees.email', 'employees.employee_code', 'employees.image', 'designations.designation', 'countries.country_name')
    //             ->where('payrolls.id', $id)
    //             ->first();
    //     // dd($payroll);

    //     $statusHtml = '';
    //     if ($payroll->status == 1) {
    //         $statusHtml = '<span class="text-success">Active</span>';
    //     } else {
    //         $statusHtml = '<span class="text-danger">Inactive</span>';
    //     }

    //     $employee = '<div class="d-flex align-items-center">
    //         <a href="employee-details.html" class="avatar avatar-md"><img src="'. asset($payroll->image) .'" class="img-fluid" alt="img"></a>
    //         <div class="ms-2">
    //             <p class="text-dark mb-0"><a href="employee-details.html">'. $payroll->first_name . ' ' . $payroll->last_name .'</a></p>
    //             <p><a>'. $payroll->designation .'</a></p>
    //         </div>
    //     </div>';


    //     $total_earnings = $payroll->basic_salary + $payroll->hra_allow + $payroll->conveyance + $payroll->medical_allow + $payroll->bonus;

    //     $total_deductions = $payroll->provident_fund + $payroll->professional_tax + $payroll->tds + $payroll->loan_others;

    //     $net_salary = $total_earnings - $total_deductions;



    //     $created_date = date('d F, Y', strtotime($payroll->created_at));
    //     $updated_date = date('d F, Y', strtotime($payroll->updated_at));

    //     return response()->json([
    //         'success'           => $payroll,
    //         'statusHtml'        => $statusHtml,
    //         'net_salary'        => $net_salary,
    //         'employee'          => $employee,
    //         'created_date'      => $created_date,
    //         'updated_date'      => $updated_date,
    //     ]);
    // }



    public function allPayrollPdf()
    {
        if (!$this->user || !$this->user->can('pdf.brand')) {
            throw UnauthorizedException::forPermissions(['pdf.brand']);
        }
        
        $payrolls = Payroll::leftJoin('employees', 'employees.id', 'payrolls.employee_id')
                ->leftJoin('countries', 'countries.id', 'employees.country_id')
                ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                ->select('payrolls.*', 'employees.first_name', 'employees.last_name', 'employees.email', 'employees.employee_code', 'employees.image', 'designations.designation', 'countries.country_name')
                ->get();

        $pdf = Pdf::loadView('admin.pages.payroll.pdf', compact('payrolls'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Payroll.pdf');
        // return view('admin.pages.payroll.pdf', compact('payrolls'));
    }
    
    public function payrollPayslip($id)
    {
        $payroll = Payroll::leftJoin('employees', 'employees.id', 'payrolls.employee_id')
            ->leftJoin('countries', 'countries.id', 'employees.country_id')
            ->leftJoin('designations', 'designations.id', 'employees.designation_id')
            ->select('payrolls.*', 'employees.first_name', 'employees.last_name', 'employees.email', 'employees.employee_code', 'employees.image', 'designations.designation', 'countries.country_name')
            ->where('payrolls.id', $id)
            ->first();

        $total_earnings = $payroll->basic_salary + $payroll->hra_allow + $payroll->conveyance + $payroll->medical_allow + $payroll->bonus;

        $total_deductions = $payroll->provident_fund + $payroll->professional_tax + $payroll->tds + $payroll->loan_others;

        $net_salary = $total_earnings - $total_deductions;
        return view('admin.pages.payroll.payslip', compact('payroll', 'total_earnings', 'total_deductions', 'net_salary'));
    }

}
