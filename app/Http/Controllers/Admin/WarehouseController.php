<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateWarehouseRequest;
use App\Http\Requests\Admin\UpdateWarehouseRequest;
use App\Models\City;
use App\Traits\ImageUploadTraits;
use App\Models\Country;
use App\Models\State;
use App\Models\Warehouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class WarehouseController extends Controller
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
        $countries  = Country::where('status', 1)->get();
        $cities     = City::where('status', 1)->get();
        $states     = State::where('status', 1)->get();
        return view('admin.pages.warehouse.index',[
            'countries' => $countries,
            'cities'    => $cities,
            'states'    => $states,
        ]);
    }

    public function getData()
    {
        // get all data
        $warehouses = Warehouse::leftJoin('countries', 'countries.id', 'warehouses.country_id')
                ->leftJoin('states', 'states.id', 'warehouses.state_id')
                ->leftJoin('cities', 'cities.id', 'warehouses.city_id')
                ->select('warehouses.*', 'countries.country_name', 'states.state_name', 'cities.city_name')
                ->get();

        return DataTables::of($warehouses)
            ->addIndexColumn()
            ->addColumn('status', function ($warehouse) {
                if(auth("admin")->user()->can("status.warehouse"))
                    if ($warehouse->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$warehouse->id.'" data-status="'.$warehouse->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$warehouse->id.'" data-status="'.$warehouse->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($warehouse) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$warehouse->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.warehouse"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$warehouse->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.warehouse"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$warehouse->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['warehouse' => $warehouse]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeWarehouseStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.warehouse')) {
            throw UnauthorizedException::forPermissions(['status.warehouse']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Warehouse::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWarehouseRequest $request)
    {
        if (!$this->user || !$this->user->can('create.warehouse')) {
            throw UnauthorizedException::forPermissions(['create.warehouse']);
        }

        DB::beginTransaction();
        try {
            $warehouse  = new Warehouse();
            $warehouse->warehouse              = $request->warehouse;
            $warehouse->employee_id            = $request->employee_id;
            $warehouse->email                  = $request->email;
            $warehouse->phone                  = $request->phone;
            $warehouse->phone_work             = $request->phone_work;
            $warehouse->address                = $request->address;
            $warehouse->city_id                = $request->city_id;
            $warehouse->state_id               = $request->state_id;
            $warehouse->country_id             = $request->country_id;
            $warehouse->postal_code            = $request->postal_code;
            $warehouse->status                 = $request->status;
            $warehouse->created_at             = now();
            $warehouse->updated_at             = now();

            // dd($warehouse);
            $warehouse->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully State Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        if (!$this->user || !$this->user->can('update.warehouse')) {
            throw UnauthorizedException::forPermissions(['update.warehouse']);
        }

        // dd($warehouse);
        return response()->json(['success' => $warehouse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.warehouse')) {
            throw UnauthorizedException::forPermissions(['update.warehouse']);
        }

        $warehouse  = Warehouse::find($id);

        DB::beginTransaction();
        try {
            $warehouse->warehouse              = $request->warehouse;
            $warehouse->employee_id            = $request->employee_id;
            $warehouse->email                  = $request->email;
            $warehouse->phone                  = $request->phone;
            $warehouse->phone_work             = $request->phone_work;
            $warehouse->address                = $request->address;
            $warehouse->city_id                = $request->city_id;
            $warehouse->state_id               = $request->state_id;
            $warehouse->country_id             = $request->country_id;
            $warehouse->postal_code            = $request->postal_code;
            $warehouse->status                 = $request->status;
            $warehouse->updated_at             = now();
            $warehouse->save();
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
    public function destroy(Warehouse $warehouse)
    {
        if (!$this->user || !$this->user->can('delete.warehouse')) {
            throw UnauthorizedException::forPermissions(['delete.warehouse']);
        }
        $warehouse->delete();
        return response()->json(['message' => 'Warehouse has been deleted.'], 200);
    }


    public function warehouseView($id)
    {
        $warehouse = Warehouse::leftJoin('countries', 'countries.id', 'warehouses.country_id')
                ->leftJoin('states', 'states.id', 'warehouses.state_id')
                ->leftJoin('cities', 'cities.id', 'warehouses.city_id')
                ->where('warehouses.id', $id)
                ->select('warehouses.*', 'countries.country_name', 'states.state_name', 'cities.city_name')
                ->first();
        // dd($state);

        $statusHtml = '';
        if ($warehouse->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($warehouse->created_at));
        $updated_date = date('d F, Y', strtotime($warehouse->updated_at));

        return response()->json([
            'success'           => $warehouse,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }



    public function allWarehousePdf()
    {
        if (!$this->user || !$this->user->can('pdf.warehouse')) {
            throw UnauthorizedException::forPermissions(['pdf.warehouse']);
        }
        
        $warehouses = Warehouse::leftJoin('countries', 'countries.id', 'warehouses.country_id')
                ->leftJoin('states', 'states.id', 'warehouses.state_id')
                ->leftJoin('cities', 'cities.id', 'warehouses.city_id')
                ->select('warehouses.*', 'countries.country_name', 'states.state_name', 'cities.city_name')
                ->get();
                

        $pdf = Pdf::loadView('admin.pages.warehouse.pdf', compact('warehouses'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Warehouse.pdf');
        // return view('admin.pages.warehouse.pdf', compact('warehouses'));
    }

}
