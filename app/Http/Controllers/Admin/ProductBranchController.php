<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Admin\CreateProductBranchRequest;
use App\Http\Requests\Admin\UpdateProductBranchRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ProductBranchController extends Controller
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
        $products = Product::where('status', 1)->get();
        return view('admin.pages.product_branch.index', compact('branches', 'products'));
    }

    public function getData()
    {
        // get all data
        $ProductBranches = ProductBranch::leftJoin('branches', 'branches.id', 'product_branches.branch_id')
            ->leftJoin('products', 'products.id', 'product_branches.product_id')
            ->select('branches.name as branch_name', 'products.*', 'product_branches.*')
            ->get();

        return DataTables::of($ProductBranches)
            ->addIndexColumn()
            ->addColumn('created_by', function ($productBranch) {
                $adminName = \App\Models\Admin::find($productBranch->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($productBranch->created_by)?->email ?? 'Unknown';
                $adminImage = \App\Models\Admin::find($productBranch->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center" style="white-space: normal; width: 150px;">
                        <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                        <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        </div>
                </div>';
            })
            ->addColumn('product_name', function ($productBranch) {
                return '<div class="d-flex align-items-center gap-1">
                    <img src="'.asset( $productBranch->thumb_image ).'" alt="" style="width: 45px;">
                    <p class="text-dark fw-bold" style="white-space: normal; width: 200px;">'.$productBranch->name.'</p>
                </div>';
            })
            ->addColumn('branch_name', function ($productBranch) {
                return '<p class="text-dark fw-bold ">'.$productBranch->branch_name.'</p>';
            })
            ->addColumn('product_bio', function ($productBranch) {
                return '<div class="">
                    <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">Quantity: </span>'.$productBranch->qty.' Pcs</p>
                    <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">Alert Qty: </span>'.$productBranch->alert_qty. ' Pcs</p>
                    <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">MRP:</span> '. $productBranch->selling_price .'/- BDT</p>
                </div>';
            })
            ->addColumn('discount_bio', function ($productBranch) {
                $symbol = match ($productBranch->discount_type) {
                    'fixed' => 'BDT',
                    'percent' => '%',
                    default => '',
                };
                return '<div class="">
                    <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">Type: </span>'.Str::title($productBranch->discount_type).'</p>
                    <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">Value: </span>'.$productBranch->discount_value.' '. $symbol.'</p>
                </div>';
            })
            ->addColumn('discount_date', function ($device) {
                $dates = explode(' - ', $device->discount_date);
                return '<div class="d-flex flex-column align-items-center">
                        <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">Start:</span> '. trim($dates[0] ?? null) .'</p>
                        <p class="mb-1 fw-semibold"><span class="text-dark fw-bold">End: </span> '. trim($dates[1] ?? null) .'</p>
                            </div>
                    </div>';
            })
            ->addColumn('status', function ($productBranch) {
                if(auth("admin")->user()->can("status.device"))
                    if ($productBranch->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$productBranch->id.'" data-status="'.$productBranch->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$productBranch->id.'" data-status="'.$productBranch->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($productBranch) {
                $actionHtml = Blade::render('<div class="copy-row">
                    <div class="all_icons">
                        <a href="javascript:void(0)" id="viewButton" data-bs-toggle="modal" data-bs-target="#viewModal">
                            <i  class="ti ti-eye cursor-pointer text-success" style="font-size: 20px;"
                            ></i>
                        </a>

                        @if(auth("admin")->user()->can("update.product"))
                            <a href="javascript:void(0)" data-id="'.$productBranch->id.'" data-bs-toggle="modal" id="editButton" data-bs-target="#editModal">
                                <i style="font-size: 20px;" class="ti ti-edit cursor-pointer text-info"></i>
                            </a>
                        @endif

                        @if(auth("admin")->user()->can("delete.product"))
                            <a href="javascript:void(0)" data-id="'.$productBranch->id.'" id="deleteBtn">
                                <i style="font-size: 20px;" class="ti ti-trash text-danger" title="Delete"></i>
                            </a>
                        @endif
                    </div>
                </div>', ['productBranch' => $productBranch]);
                return $actionHtml;
            })
            ->rawColumns(['created_by', 'product_name', 'product_bio', 'discount_bio', 'discount_date', 'branch_name', 'status', 'action'])
            ->make(true);
    }

    public function changeProductBranchStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.device')) {
            throw UnauthorizedException::forPermissions(['status.device']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = ProductBranch::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductBranchRequest $request)
    {
        if (!$this->user || !$this->user->can('create.device')) {
            throw UnauthorizedException::forPermissions(['create.device']);
        }

        // dd('has work');

        DB::beginTransaction();
        try {
            $productBranch = new ProductBranch();
            $productBranch->product_id             = $request->product_id ;
            $productBranch->branch_id              = $request->branch_id;
            $productBranch->qty                    = $request->qty;
            $productBranch->alert_qty              = $request->alert_qty;
            $productBranch->purchase_price         = $request->purchase_price;
            $productBranch->selling_price          = $request->selling_price;
            $productBranch->profit_margin          = $request->profit_margin;
            $productBranch->discount_type          = $request->discount_type;
            $productBranch->discount_value         = $request->discount_value ?? '';
            $productBranch->discount_date          = $request->discount_date ?? '';
            $productBranch->status                 = $request->status ?? 1;
            $productBranch->created_by             = Auth::guard('admin')->id();
            $productBranch->created_at             = now();
            $productBranch->updated_at             = now();
            $productBranch->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Successfully Branch Product Created!',
            'device' => [
                'id' => $productBranch->id,
                'name' => $productBranch->name,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductBranch $productBranch)
    {
        if (!$this->user || !$this->user->can('update.device')) {
            throw UnauthorizedException::forPermissions(['update.device']);
        }

        // dd($productBranch);
        return response()->json(['success' => $productBranch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductBranchRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.device')) {
            throw UnauthorizedException::forPermissions(['update.device']);
        }

        $productBranch  = ProductBranch::find($id);
        DB::beginTransaction();
        try {
            $productBranch->product_id             = $request->product_id ;
            $productBranch->branch_id              = $request->branch_id;
            $productBranch->qty                    = $request->qty;
            $productBranch->alert_qty              = $request->alert_qty;
            $productBranch->purchase_price         = $request->purchase_price;
            $productBranch->selling_price          = $request->selling_price;
            $productBranch->profit_margin          = $request->profit_margin;
            $productBranch->discount_type          = $request->discount_type;
            $productBranch->discount_value         = $request->discount_value ?? '';
            $productBranch->discount_date          = $request->discount_date ?? '';
            $productBranch->status                 = $request->status ?? 1;
            $productBranch->updated_by             = Auth::guard('admin')->id();
            $productBranch->updated_at             = now();
            $productBranch->save();
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
    public function destroy(ProductBranch $productBranch)
    {
        if (!$this->user || !$this->user->can('delete.device')) {
            throw UnauthorizedException::forPermissions(['delete.device']);
        }

        $productBranch->delete();
        return response()->json(['message' => 'Branch Wise Product has been deleted.'], 200);
    }

    public function deviceView($id)
    {
        $device = Device::join('branches', 'branches.id', 'devices.branch_id')
                ->select('branches.name as branch_name', 'devices.*')
                ->where('devices.id', $id)
                ->firstOrFail();
        // dd($device);

        $statusHtml = '';
        if ($device->status === 1) {
            $statusHtml = '<button type="button" class="btn btn-info btn-sm">Active</button>';
        } else {
            $statusHtml = '<button type="button" class="btn btn-danger btn-sm">Deactive</button>';
        }

        $is_online = '';
        if ($device->is_online === 'online') {
            $is_online = '<button type="button" class="btn btn-info btn-sm">Online</button>';
        } elseif ($device->is_online === 'offline') {
            $is_online = '<button type="button" class="btn btn-danger btn-sm">Offline</button>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($device->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($device->updated_at));

        return response()->json([
            'success'           => $device,
            'statusHtml'        => $statusHtml,
            'is_online'         => $is_online,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }


    public function allDevicePdf()
    {
        if (!$this->user || !$this->user->can('pdf.device')) {
            throw UnauthorizedException::forPermissions(['pdf.device']);
        }
        
        $devices = Device::get();

        $pdf = Pdf::loadView('admin.pages.product_branch.pdf', compact('devices'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Device.pdf');
        // return view('admin.pages.product_branch.pdf', compact('devices'));
    }
}
