<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
// use App\Http\Requests\Admin\CreateDeviceRequest;
// use App\Http\Requests\Admin\UpdateDeviceRequest;
use App\Models\Branch;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class TerminalController extends Controller
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
        $branches = Branch::where('status', 1)->get();
        return view('admin.pages.terminal.index', compact('branches'));
    }

    public function getData()
    {
        // get all data
        $terminals = Terminal::join('branches', 'branches.id', 'terminals.branch_id')
            ->select('branches.name as branch_name', 'terminals.*')
            ->get();

        return DataTables::of($terminals)
            ->addIndexColumn()
            ->addColumn('created_by', function ($terminal) {
                $adminName = \App\Models\Admin::find($terminal->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($terminal->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($terminal->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                        <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                        <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                        </div>
                </div>';
            })
            ->addColumn('branch_name', function ($terminal) {
                return '<p class="status">'.$terminal->branch_name.'</p>';
            })
            ->addColumn('status', function ($terminal) {
                if(auth("admin")->user()->can("status.terminal"))
                    if ($terminal->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$terminal->id.'" data-status="'.$terminal->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$terminal->id.'" data-status="'.$terminal->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($terminal) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$terminal->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.terminal"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$terminal->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.terminal"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$terminal->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['terminal' => $terminal]);
                return $actionHtml;
            })
            ->rawColumns(['created_by', 'branch_name', 'status', 'action'])
            ->make(true);
    }

    public function changeTerminalStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.terminal')) {
            throw UnauthorizedException::forPermissions(['status.terminal']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Terminal::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.terminal')) {
            throw UnauthorizedException::forPermissions(['create.terminal']);
        }

        DB::beginTransaction();
        try {
            $terminal = new Terminal();
            $terminal->branch_id              = $request->branch_id;
            $terminal->device_code            = Str::upper(Str::slug($request->device_code));
            $terminal->device_name            = Str::title($request->device_name);
            $terminal->ip_address             = $request->ip_address;
            $terminal->last_active_at         = $request->last_active_at;
            $terminal->is_online              = $request->is_online ?? "Online";
            $terminal->status                 = $request->status ?? 1;
            $terminal->created_by             = Auth::guard('admin')->id();
            $terminal->created_at             = now();
            $terminal->updated_at             = now();
            $terminal->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Successfully Terminal Created!',
            'device' => [
                'id' => $terminal->id,
                'name' => $terminal->name,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terminal $terminal)
    {
        if (!$this->user || !$this->user->can('update.terminal')) {
            throw UnauthorizedException::forPermissions(['update.terminal']);
        }

        // dd($terminal);
        return response()->json(['success' => $terminal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!$this->user || !$this->user->can('update.terminal')) {
            throw UnauthorizedException::forPermissions(['update.terminal']);
        }

        $terminal  = Terminal::find($id);
        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $terminal->branch_id              = $request->branch_id;
            $terminal->device_code            = Str::upper(Str::slug($request->device_code));
            $terminal->device_name            = Str::title($request->device_name);
            $terminal->ip_address             = $request->ip_address;
            $terminal->last_active_at         = $request->last_active_at;
            $terminal->is_online              = $request->is_online ?? "Online";
            $terminal->status                 = $request->status ?? 1;
            $terminal->updated_by             = Auth::guard('admin')->id();
            $terminal->updated_at             = now();
            $terminal->save();
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
    public function destroy(Terminal $terminal)
    {
        if (!$this->user || !$this->user->can('delete.terminal')) {
            throw UnauthorizedException::forPermissions(['delete.terminal']);
        }

        $terminal->delete();
        return response()->json(['message' => 'Terminal has been deleted.'], 200);
    }

    public function terminalView($id)
    {
        $terminal = Terminal::join('branches', 'branches.id', 'terminals.branch_id')
                ->select('branches.name as branch_name', 'terminals.*')
                ->where('terminals.id', $id)
                ->firstOrFail();
        // dd($device);

        $statusHtml = '';
        if ($terminal->status === 1) {
            $statusHtml = '<button type="button" class="btn btn-info btn-sm">Active</button>';
        } else {
            $statusHtml = '<button type="button" class="btn btn-danger btn-sm">Deactive</button>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($terminal->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($terminal->updated_at));

        return response()->json([
            'success'           => $terminal,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allTerminalPdf()
    {
        if (!$this->user || !$this->user->can('pdf.terminal')) {
            throw UnauthorizedException::forPermissions(['pdf.terminal']);
        }
        
        $terminals = Terminal::get();

        $pdf = Pdf::loadView('admin.pages.terminal.pdf', compact('terminals'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Terminal.pdf');
        // return view('admin.pages.terminal.pdf', compact('terminals'));
    }
}
