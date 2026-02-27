<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Traits\ImageUploadTraits;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CustomerController extends Controller
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
        return view('admin.pages.customer.index');
    }

    public function getData()
    {
        // get all data
        $customers = Customer::all();

        return DataTables::of($customers)
            ->addIndexColumn()
            ->addColumn('cus_id', function ($customer) {
                if (!empty($customer->cus_id)) {
                    return '<strong><span class="">'. $customer->cus_id .'</span></strong>';
                }
            })
            ->addColumn('additional_note', function ($customer) {
                if (!empty($customer->additional_note)) {
                    return '<span class="">'. $customer->additional_note .'</span>';
                }
                else{
                    return '<div class="plus_icon"><i class="ti ti-plus"></i></div>';
                }
            })
            ->addColumn('internal_note', function ($customer) {
                if (!empty($customer->internal_note)) {
                    return '<span class="">'. $customer->internal_note .'</span>';
                }
                else{
                    return '<div class="plus_icon"><i class="ti ti-plus"></i></div>';
                }
            })
            ->addColumn('customer_details', function ($customer) {
                $icon = '';
                if( $customer->cus_source === 'website' ){
                    $icon = asset('public/admin/assets/images/world-wide-web.png');
                }
                else if( $customer->cus_source === 'phone_call' ){
                    $icon = asset('public/admin/assets/images/viber.png');
                }
                else if( $customer->cus_source === 'whatsapp' ){
                    $icon = asset('public/admin/assets/images/whatsapp.png');
                }
                else if( $customer->cus_source === 'facebook' ){
                    $icon = asset('public/admin/assets/images/facebook.png');
                }
                else{
                    $icon = asset('public/admin/assets/images/instagram.png');
                }

                return '<div class="copy-row">
                    <h6 style="color: #1e857a;" class="mb-1"><strong>'. $customer->cus_name .'</strong></h6>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="badge badge-sm bg-primary">'. $customer->cus_tag .'</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong><span class="">+88'. $customer->cus_phone .'</span></strong>

                        <a href="https://wa.me/'. $customer->cus_phone .'" target="_blank" style="width: 18px;">
                            <img src="' . $icon . '" alt="" width="18">
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <strong><span class="">'. $customer->cus_email .'</span></strong>
                    </div>
                </div>';  
            })
            ->addColumn('created_by', function ($customer) {
                $adminName = \App\Models\Admin::find($customer->created_by)?->name ?? 'Unknown';
                $adminEmail = \App\Models\Admin::find($customer->created_by)?->email ?? 'Unknown';
                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                $adminImage = \App\Models\Admin::find($customer->created_by)?->image ?? 'Unknown';
                return '<div class="d-flex align-items-center">
                      <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                      <div>
                        <p class="mb-0">'. $adminName .'</p> 
                        <p class="mb-0">'. $maskMail .'</p>
                      </div>
                </div>';
            })
            ->addColumn('status', function ($customer) {
                if(auth("admin")->user()->can("status.customer"))
                    if ($customer->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$customer->id.'" data-status="'.$customer->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$customer->id.'" data-status="'.$customer->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($customer) {
                $actionHtml = Blade::render('
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdownmenu-primary" style="">
                            <a class="dropdown-item text-info" id="viewButton" href="javascript:void(0)" data-id="'.$customer->id.'" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </a>

                            @if(auth("admin")->user()->can("update.customer"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$customer->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.customer"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$customer->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['customer' => $customer]);
                return $actionHtml;
            })
            ->rawColumns(['cus_id', 'internal_note', 'additional_note', 'created_by', 'customer_details', 'status', 'action'])
            ->make(true);
    }

    public function changeCustomerStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.customer')) {
            throw UnauthorizedException::forPermissions(['status.customer']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Customer::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('create.customer')) {
            throw UnauthorizedException::forPermissions(['create.customer']);
        }
        
        $request->validate([
            'cus_name'      => 'required|string|max:150|unique:customers,cus_name',
            'cus_phone'     => 'required|string|unique:customers,cus_phone|digits_between:10,11',
            'cus_source'    => 'required|string',
            'cus_address'   => 'required|string|max:512',
        ]);

        DB::beginTransaction();
        try {
            $lastCustomer = Customer::orderBy('cus_id', 'desc')->value('cus_id');
            $nextNumber = $lastCustomer ? ((int) str_replace('C-', '', $lastCustomer)) + 1
            : 123001;

            $customer  = new Customer();
            $customer->cus_id                 = 'C-' . $nextNumber;
            $customer->cus_type               = $request->cus_type;
            $customer->cus_name               = $request->cus_name;
            $customer->cus_phone              = $request->cus_phone;
            $customer->cus_email              = $request->cus_email;
            $customer->cus_tag                = $request->cus_tag;
            $customer->cus_source             = $request->cus_source;
            $customer->cus_address            = $request->cus_address;
            $customer->additional_note        = $request->additional_note;
            $customer->internal_note          = $request->internal_note;
            $customer->save_as                = $request->save_as;
            $customer->status                 = $request->status ?? 1;
            $customer->created_by             = Auth::guard('admin')->id();
            $customer->created_at             = now();
            $customer->updated_at             = now();

            // dd($customer);
            $customer->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Customer Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        if (!$this->user || !$this->user->can('update.customer')) {
            throw UnauthorizedException::forPermissions(['update.customer']);
        }

        // dd($city);
        return response()->json(['success' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.customer')) {
            throw UnauthorizedException::forPermissions(['update.customer']);
        }

        $request->validate([
            'cus_name'     => ['required', 'string', 'max:255','unique:customers,cus_name,' .$id],
            'cus_phone'    => ['required', 'string', 'digits_between:10,11', 'unique:customers,cus_phone,' .$id],
            'cus_source'   => 'required|string',
            'cus_address'  => 'required|string|max:512',
        ]);

        $customer  = Customer::find($id);

        DB::beginTransaction();
        try {
            $customer->cus_type               = $request->cus_type;
            $customer->cus_name               = $request->cus_name;
            $customer->cus_phone              = $request->cus_phone;
            $customer->cus_email              = $request->cus_email;
            $customer->cus_tag                = $request->cus_tag;
            $customer->cus_source             = $request->cus_source;
            $customer->cus_address            = $request->cus_address;
            $customer->additional_note        = $request->additional_note;
            $customer->internal_note          = $request->internal_note;
            $customer->save_as                = $request->save_as;
            $customer->status                 = $request->status ?? 1;
            $customer->updated_by             = Auth::guard('admin')->id();
            $customer->updated_at             = now();
            $customer->save();
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
    public function destroy(Customer $customer)
    {
        if (!$this->user || !$this->user->can('delete.customer')) {
            throw UnauthorizedException::forPermissions(['delete.customer']);
        }
        $customer->delete();
        return response()->json(['message' => 'Customer has been deleted.'], 200);
    }

    public function customerView($id)
    {
       $customer  =  Customer::findOrFail($id);
        // dd($customer);

        $statusHtml = '';
        if ($customer->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $createdName   = \App\Models\Admin::find($customer->created_by)?->name ?? 'Unknown';
        $createdImage  = \App\Models\Admin::find($customer->created_by)?->image ?? 'Unknown';
        $updatedName   = \App\Models\Admin::find($customer->created_by)?->name ?? 'Unknown';
        $updatedImage  = \App\Models\Admin::find($customer->created_by)?->image ?? 'Unknown';
        $createdBy     = '<div class="d-flex align-items-center">
                            <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($createdImage) .'" />
                            <div>
                                <p class="mb-0">'. $createdName .'</p> 
                            </div>
                        </div>';
        $updatedBy   = '<div class="d-flex align-items-center">
                            <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($updatedImage) .'" />
                            <div>
                                <p class="mb-0">'. $updatedName .'</p> 
                            </div>
                        </div>';

        $created_date = date('d F, Y', strtotime($customer->created_at));
        $updated_date = date('d F, Y', strtotime($customer->updated_at));

        return response()->json([
            'success'           => $customer,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
            'createdBy'         => $createdBy,
            'updatedBy'         => $updatedBy,
        ]);
    }

    
    public function allCustomerPdf()
    {
        if (!$this->user || !$this->user->can('pdf.category')) {
            throw UnauthorizedException::forPermissions(['pdf.category']);
        }
        
        $customers = Customer::get();

        $pdf = Pdf::loadView('admin.pages.customer.pdf', compact('customers'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('customer.pdf');
        // return view('admin.pages.customer.pdf', compact('customers'));
    }
}
