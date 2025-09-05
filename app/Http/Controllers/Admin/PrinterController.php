<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Signature;
use App\Traits\ImageUploadTraits;
use App\Models\Brand;
use App\Models\Printer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PrinterController extends Controller
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
        return view('admin.pages.app_settings.printer');
    }

    public function getData()
    {
        // get all data
        $printers = Printer::all();

        return DataTables::of($printers)
            ->addIndexColumn()
            ->addColumn('status', function ($printer) {
                if(auth("admin")->user()->can("status.banip"))
                    if ($printer->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$printer->id.'" data-status="'.$printer->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$printer->id.'" data-status="'.$printer->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($printer) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            @if(auth("admin")->user()->can("update.banip"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$printer->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.banip"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$printer->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['printer' => $printer]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changePrinterStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.printer')) {
            throw UnauthorizedException::forPermissions(['status.printer']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        $all = Printer::where('id', '!=', $id)->get();

        if ($Current_status == 1) {
            $status = 1;

            foreach( $all as $row ){
                $row->status = 0;
                $row->save();
            }
        } else {
            $status = 1;
            
            foreach( $all as $row ){
                $row->status = 0;
                $row->save();
            }
        }

        $page = Printer::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!$this->user || !$this->user->can('create.printer')) {
            throw UnauthorizedException::forPermissions(['create.printer']);
        }

        $request->validate([
            'name'      => ['required', 'unique:printers,name', 'max:255'],
            'connection' => ['required', 'string', 'max:30'],
            'ip_address' => ['required', 'string'],
            'port'       => ['required', 'integer'],
        ]);

        DB::beginTransaction();
        try {
            $printer = new Printer();
            $printer->name                   = $request->name;
            $printer->connection             = $request->connection;
            $printer->ip_address             = $request->ip_address;
            $printer->port                   = $request->port;
            $printer->status                 = 1;
            $printer->created_at             = now();
            $printer->updated_at             = now();

            // dd($printer);
            $printer->save();

            $all = Printer::where('id', '!=', $printer->id)->get();
            foreach( $all as $row ){
                $row->status = 0;
                $row->save();
            }
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Printer Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Printer $printer)
    {
        if (!$this->user || !$this->user->can('update.printer')) {
            throw UnauthorizedException::forPermissions(['update.printer']);
        }

        // dd($category);
        return response()->json(['success' => $printer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.printer')) {
            throw UnauthorizedException::forPermissions(['update.printer']);
        }

        $request->validate([
            'name'       => ['required', 'unique:printers,name,'. $id, 'max:255'],
            'connection' => ['required', 'string', 'max:30'],
            'ip_address' => ['required', 'string'],
            'port'       => ['required', 'integer'],
        ]);

        $printer  = Printer::find($id);

        DB::beginTransaction();
        try {
            $printer->name                   = $request->name;
            $printer->connection             = $request->connection;
            $printer->ip_address             = $request->ip_address;
            $printer->port                   = $request->port;
            $printer->updated_at             = now(); 

            $printer->save();
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
    public function destroy(Printer $printer)
    {
        if (!$this->user || !$this->user->can('delete.printer')) {
            throw UnauthorizedException::forPermissions(['delete.printer']);
        }

        $printer->delete();
        return response()->json(['message' => 'Printer has been deleted.'], 200);
    }

}
