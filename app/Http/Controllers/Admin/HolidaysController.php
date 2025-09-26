<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class HolidaysController extends Controller
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
        return view('admin.pages.holidays.index');
    }

    public function getData()
    {
        // get all data
        $holidays = Holiday::all();

        return DataTables::of($holidays)
            ->addIndexColumn()
            ->addColumn('date', function ($holiday) {
                if( !empty($holiday->date_from) && !empty($holiday->date_to) ){
                    return '<span class="">'. date('d-m-Y', strtotime($holiday->date_from)) .' -- '. date('d-m-Y', strtotime($holiday->date_to)).'</span>';
                }
                else{
                    return '<span class="">'. date('d-m-Y', strtotime($holiday->date_from)) .'</span>';
                }
            })
            ->addColumn('status', function ($holiday) {
                if(auth("admin")->user()->can("status.holiday"))
                    if ($holiday->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$holiday->id.'" data-status="'.$holiday->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$holiday->id.'" data-status="'.$holiday->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($holiday) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$holiday->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.holiday"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$holiday->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.holiday"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$holiday->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['holiday' => $holiday]);
                return $actionHtml;
            })
            ->rawColumns(['date', 'status', 'action'])
            ->make(true);
    }

    public function changeHolidayStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.holiday')) {
            throw UnauthorizedException::forPermissions(['status.holiday']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Holiday::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.holiday')) {
            throw UnauthorizedException::forPermissions(['create.holiday']);
        }

        $request->validate([
            'holiday_name' => 'required|string|max:150|unique:holidays,holiday_name',
            'date_from'    => ['required','date',],
            'date_to'      => ['nullable','date',],
            'description'  => 'nullable|string|max:250',
        ]);

        DB::beginTransaction();
        try {
            $holiday = new Holiday();
            $holiday->holiday_name           = Str::title($request->holiday_name);
            $holiday->date_from              = $request->date_from;
            $holiday->date_to                = $request->date_to;
            $holiday->description            = $request->description;
            $holiday->status                 = $request->status;
            $holiday->created_at             = now();
            $holiday->updated_at             = now();

            // dd($holiday);
            $holiday->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Holiday Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        if (!$this->user || !$this->user->can('update.holiday')) {
            throw UnauthorizedException::forPermissions(['update.holiday']);
        }

        // dd($category);
        return response()->json(['success' => $holiday]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.holiday')) {
            throw UnauthorizedException::forPermissions(['update.holiday']);
        }

        $request->validate([
            'holiday_name' => 'required|string|max:150|unique:holidays,holiday_name,' .$id,
            'date_from'    => ['required','date',],
            'date_to'      => [ 'nullable', 'date',],
            'description'  => 'nullable|string|max:250',
        ]);

        $holiday  = Holiday::find($id);

        DB::beginTransaction();
        try {
            $holiday->holiday_name           = Str::title($request->holiday_name);
            $holiday->date_from              = $request->date_from;
            $holiday->date_to                = $request->date_to;
            $holiday->description            = $request->description;
            $holiday->status                 = $request->status;
            $holiday->updated_at             = now();

            $holiday->save();
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
    public function destroy(Holiday $holiday)
    {
        if (!$this->user || !$this->user->can('delete.holiday')) {
            throw UnauthorizedException::forPermissions(['delete.holiday']);
        }
        $holiday->delete();
        return response()->json(['message' => 'Holiday has been deleted.'], 200);
    }


    public function holidayView($id)
    {
        $holiday  = Holiday::find($id);
        // dd($brand);

        $statusHtml = '';
        if ($holiday->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }


        $date = '';
        if( !empty($holiday->date_from) && !empty($holiday->date_to) ){
            $date = '<span class="">'. date('d-m-Y', strtotime($holiday->date_from)) .'--'. date('d-m-Y', strtotime($holiday->date_to)).'</span>';
        }
        else{
            $date = '<span class="">'. date('d-m-Y', strtotime($holiday->date_from)) .'</span>';
        }

        $created_date = date('d F, Y', strtotime($holiday->created_at));
        $updated_date = date('d F, Y', strtotime($holiday->updated_at));

        return response()->json([
            'success'           => $holiday,
            'date'              => $date,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allHolidayPdf()
    {
        if (!$this->user || !$this->user->can('pdf.holiday')) {
            throw UnauthorizedException::forPermissions(['pdf.holiday']);
        }
        
        $holidays = Holiday::get();

        $pdf = Pdf::loadView('admin.pages.holidays.pdf', compact('holidays'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Holidays.pdf');
        // return view('admin.pages.holidays.pdf', compact('holidays'));
    }

}
