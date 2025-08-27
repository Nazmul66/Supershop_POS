<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUnitRequest;
use App\Http\Requests\Admin\UpdateUnitRequest;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UnitController extends Controller
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
        return view('admin.pages.units.index');
    }

    public function getData()
    {
        // get all data
        $units= Unit::all();

        return DataTables::of($units)
            ->addIndexColumn()
            ->addColumn('status', function ($unit) {
                if(auth("admin")->user()->can("status.unit"))
                    if ($unit->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$unit->id.'" data-status="'.$unit->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$unit->id.'" data-status="'.$unit->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($unit) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$unit->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.unit"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$unit->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.unit"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$unit->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['unit' => $unit]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeUnitStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.unit')) {
            throw UnauthorizedException::forPermissions(['status.unit']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Unit::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUnitRequest $request)
    {
        if (!$this->user || !$this->user->can('create.unit')) {
            throw UnauthorizedException::forPermissions(['create.unit']);
        }

        DB::beginTransaction();
        try {
            $unit = new Unit();
            $unit->unit                   = Str::title($request->unit);
            $unit->short_name             = $request->short_name;
            $unit->status                 = $request->status;
            $unit->created_at             = now();
            $unit->updated_at             = now();

            // dd($unit);
            $unit->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Unit Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        if (!$this->user || !$this->user->can('update.unit')) {
            throw UnauthorizedException::forPermissions(['update.unit']);
        }

        // dd($unit);
        return response()->json(['success' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.unit')) {
            throw UnauthorizedException::forPermissions(['update.unit']);
        }

        $unit  = Unit::find($id);

        DB::beginTransaction();
        try {
            $unit->unit                   = Str::title($request->unit);
            $unit->short_name             = $request->short_name;
            $unit->status                 = $request->status;
            $unit->created_at             = now();
            $unit->updated_at             = now();

            $unit->save();
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
    public function destroy(Unit $unit)
    {
        if (!$this->user || !$this->user->can('delete.unit')) {
            throw UnauthorizedException::forPermissions(['delete.unit']);
        }

        $unit->delete();
        return response()->json(['message' => 'Unit has been deleted.'], 200);
    }


    public function unitView($id)
    {
        $unit  = Unit::find($id);
        // dd($unit);

        $statusHtml = '';
        if ($unit->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($unit->created_at));
        $updated_date = date('d F, Y', strtotime($unit->updated_at));

        return response()->json([
            'success'           => $unit,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }



    public function allUnitsPdf()
    {
        if (!$this->user || !$this->user->can('pdf.unit')) {
            throw UnauthorizedException::forPermissions(['pdf.unit']);
        }
        
        $units = Unit::get();

        $pdf = Pdf::loadView('admin.pages.units.pdf', compact('units'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Unit.pdf');
        // return view('admin.pages.brands.pdf', compact('categories'));
    }

}
