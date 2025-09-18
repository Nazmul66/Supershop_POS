<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DepartmentController extends Controller
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
        $departments = Department::get();
        return view('admin.pages.department.index', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.department')) {
            throw UnauthorizedException::forPermissions(['create.department']);
        }

        $request->validate([
            'department'    => 'required|string|unique:departments,department|max:150',
            'description'   => 'nullable|string|max:350',
        ]);

        DB::beginTransaction();
        try {
            $department = new Department();
            $department->department             = Str::title($request->department);
            $department->description            = $request->description;
            $department->status                 = $request->status;
            $department->created_at             = now();
            $department->updated_at             = now();

            // dd($department);
            $department->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Department Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        if (!$this->user || !$this->user->can('update.department')) {
            throw UnauthorizedException::forPermissions(['update.department']);
        }

        // dd($department);
        return response()->json(['success' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.department')) {
            throw UnauthorizedException::forPermissions(['update.department']);
        }

        $request->validate([
            'department'    => 'required|string|max:150|unique:departments,department,'.$id,
            'description'   => 'nullable|string|max:350',
        ]);

        $department  = Department::find($id);

        DB::beginTransaction();
        try {
            $department->department        = Str::title($request->department);
            $department->description       = $request->description;
            $department->status            = $request->status;
            $department->updated_at        = now();
            $department->save();
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
    public function destroy(Department $department)
    {
        if (!$this->user || !$this->user->can('delete.department')) {
            throw UnauthorizedException::forPermissions(['delete.department']);
        }
        $department->delete();
        return response()->json(['message' => 'Department has been deleted.'], 200);
    }



    public function allDepartmentPdf()
    {
        if (!$this->user || !$this->user->can('pdf.department')) {
            throw UnauthorizedException::forPermissions(['pdf.department']);
        }
        
        $departments = Department::get();

        $pdf = Pdf::loadView('admin.pages.department.pdf', compact('departments'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Department.pdf');
        // return view('admin.pages.department.pdf', compact('departments'));
    }

}
