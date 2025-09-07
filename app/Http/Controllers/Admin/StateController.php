<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Traits\ImageUploadTraits;
use App\Models\Country;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class StateController extends Controller
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
        return view('admin.pages.state.index', compact('countries'));
    }

    public function getData()
    {
        // get all data
        $countries = Country::all();

        return DataTables::of($countries)
            ->addIndexColumn()
            ->addColumn('status', function ($country) {
                if(auth("admin")->user()->can("status.brand"))
                    if ($country->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$country->id.'" data-status="'.$country->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$country->id.'" data-status="'.$country->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($country) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$country->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.brand"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$country->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.brand"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$country->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['country' => $country]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeStateStatus(Request $request)
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

        $page = Country::findOrFail($id);
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
            'country_name' => 'required|string|unique:countries,country_name|max:150',
            'country_code' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            $country = new Country();
            $country->country_name           = Str::title($request->country_name);
            $country->country_code           = Str::upper($request->country_code);
            $country->status                 = $request->status;
            $country->created_at             = now();
            $country->updated_at             = now();

            // dd($country);
            $country->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Country Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        // dd($country);
        return response()->json(['success' => $brand]);
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
            'country_name' => 'required|string|max:150|unique:countries,country_name,' .$id,
            'country_code' => 'required|string|max:150',
        ]);

        $country  = Country::find($id);

        DB::beginTransaction();
        try {
            $country = new Country();
            $country->country_name           = Str::title($request->country_name);
            $country->country_code           = Str::upper($request->country_code);
            $country->status                 = $request->status;
            $country->updated_at             = now();

            $country->save();
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
    public function destroy(Country $country)
    {
        if (!$this->user || !$this->user->can('delete.brand')) {
            throw UnauthorizedException::forPermissions(['delete.brand']);
        }
        $country->delete();
        return response()->json(['message' => 'Country has been deleted.'], 200);
    }


    public function stateView($id)
    {
        $country  = Country::find($id);
        // dd($country);

        $statusHtml = '';
        if ($country->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($country->created_at));
        $updated_date = date('d F, Y', strtotime($country->updated_at));

        return response()->json([
            'success'           => $country,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }



    public function allStatePdf()
    {
        if (!$this->user || !$this->user->can('pdf.brand')) {
            throw UnauthorizedException::forPermissions(['pdf.brand']);
        }
        
        $country = State::get();

        $pdf = Pdf::loadView('admin.pages.country.pdf', compact('country'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('State.pdf');
        // return view('admin.pages.brands.pdf', compact('categories'));
    }

}
