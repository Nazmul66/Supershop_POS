<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ImageUploadTraits;
use App\Models\Country;
use App\Models\State;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CityController extends Controller
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
        $countries = Country::where('status', 1)->get();
        $states    = State::where('status', 1)->get();
        return view('admin.pages.city.index', compact('countries', 'states'));
    }

    public function getData()
    {
        // get all data
        $cities = City::leftJoin('countries', 'countries.id', 'cities.country_id')
                ->leftJoin('states', 'states.id', 'cities.state_id')
                ->select('cities.*', 'countries.country_name', 'states.state_name')
                ->get();

        return DataTables::of($cities)
            ->addIndexColumn()
            ->addColumn('status', function ($city) {
                if(auth("admin")->user()->can("status.brand"))
                    if ($city->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$city->id.'" data-status="'.$city->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$city->id.'" data-status="'.$city->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($city) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$city->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.brand"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$city->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.brand"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$city->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['city' => $city]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeCityStatus(Request $request)
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

        $page = City::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.brand')) {
            throw UnauthorizedException::forPermissions(['create.brand']);
        }
        
        $request->validate([
            'country_id'  => 'required|integer',
            'state_id'    => 'required|integer',
            'city_name'   => 'required|string|max:150|unique:cities,city_name',
        ]);

        DB::beginTransaction();
        try {
            $city  = new City();
            $city->country_id             = $request->country_id;
            $city->state_id               = $request->state_id;
            $city->city_name              = Str::title($request->city_name);
            $city->status                 = $request->status;
            $city->created_at             = now();
            $city->updated_at             = now();

            // dd($city);
            $city->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully City Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        // dd($city);
        return response()->json(['success' => $city]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        $request->validate([
            'country_id'  => 'required|integer',
            'state_id'    => 'required|integer',
            'city_name'   => 'required|string|max:150|unique:cities,city_name,' .$id,
        ]);

        $city  = City::find($id);

        DB::beginTransaction();
        try {
            $city->country_id              = $request->country_id;
            $city->state_id                = $request->state_id;
            $city->city_name               = Str::title($request->city_name);
            $city->status                  = $request->status;
            $city->updated_at              = now();
            $city->save();
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
    public function destroy(City $city)
    {
        if (!$this->user || !$this->user->can('delete.brand')) {
            throw UnauthorizedException::forPermissions(['delete.brand']);
        }
        $city->delete();
        return response()->json(['message' => 'City has been deleted.'], 200);
    }


    public function cityView($id)
    {
       $cities   =  City::leftJoin('countries', 'countries.id', 'cities.country_id')
                ->leftJoin('states', 'states.id', 'cities.state_id')
                ->where('cities.id', $id)
                ->select('cities.*', 'countries.country_name', 'states.state_name')
                ->first();
        // dd($cities);

        $statusHtml = '';
        if ($cities->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($cities->created_at));
        $updated_date = date('d F, Y', strtotime($cities->updated_at));

        return response()->json([
            'success'           => $cities,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }



    public function allCityPdf()
    {
        if (!$this->user || !$this->user->can('pdf.brand')) {
            throw UnauthorizedException::forPermissions(['pdf.brand']);
        }
        
        $cities = City::leftJoin('countries', 'countries.id', 'cities.country_id')
                ->leftJoin('states', 'states.id', 'cities.state_id')
                ->select('cities.*', 'countries.country_name', 'states.state_name')
                ->get();

        $pdf = Pdf::loadView('admin.pages.city.pdf', compact('cities'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('City.pdf');
        // return view('admin.pages.brands.pdf', compact('categories'));
    }

}
