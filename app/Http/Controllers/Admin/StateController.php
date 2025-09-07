<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $states = State::leftJoin('countries', 'countries.id', 'states.country_id')
                ->select('states.*', 'countries.country_name')
                ->get();

        return DataTables::of($states)
            ->addIndexColumn()
            ->addColumn('status', function ($state) {
                if(auth("admin")->user()->can("status.brand"))
                    if ($state->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$state->id.'" data-status="'.$state->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$state->id.'" data-status="'.$state->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($state) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$state->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.brand"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$state->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.brand"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$state->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['state' => $state]);
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

        $page = State::findOrFail($id);
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
            'country_id' => 'required|integer',
            'state_name'  => 'required|string|max:150|unique:states,state_name',
        ]);

        DB::beginTransaction();
        try {
            $state  = new State();
            $state->country_id           = $request->country_id;
            $state->state_name             = Str::title($request->state_name);
            $state->status                 = $request->status;
            $state->created_at             = now();
            $state->updated_at             = now();

            // dd($state);
            $state->save();
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
    public function edit(State $state)
    {
        if (!$this->user || !$this->user->can('update.brand')) {
            throw UnauthorizedException::forPermissions(['update.brand']);
        }

        // dd($state);
        return response()->json(['success' => $state]);
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
            'country_id' => 'required|integer',
            'state_name'  => 'required|string|max:150|unique:states,state_name,' .$id,
        ]);

        $state  = State::find($id);

        DB::beginTransaction();
        try {
            $state->country_id             = $request->country_id;
            $state->state_name             = Str::title($request->state_name);
            $state->status                 = $request->status;
            $state->updated_at             = now();
            $state->save();
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
    public function destroy(State $state)
    {
        if (!$this->user || !$this->user->can('delete.brand')) {
            throw UnauthorizedException::forPermissions(['delete.brand']);
        }
        $state->delete();
        return response()->json(['message' => 'State has been deleted.'], 200);
    }


    public function stateView($id)
    {
        $state = State::leftJoin('countries', 'countries.id', 'states.country_id')
                ->where('states.id', $id)
                ->select('states.*', 'countries.country_name')
                ->first();
        // dd($state);

        $statusHtml = '';
        if ($state->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($state->created_at));
        $updated_date = date('d F, Y', strtotime($state->updated_at));

        return response()->json([
            'success'           => $state,
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
        
        $states = State::leftJoin('countries', 'countries.id', 'states.country_id')
                ->select('states.*', 'countries.country_name')
                ->get();

        $pdf = Pdf::loadView('admin.pages.state.pdf', compact('states'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('State.pdf');
        // return view('admin.pages.brands.pdf', compact('categories'));
    }

}
