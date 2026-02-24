<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class CustomerController extends Controller
{
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
            ->addColumn('customer_details', function ($customer) {
                $icon = asset('public/admin/assets/images/whatsapp.png');
                return '<div class="copy-row">
                    <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="badge badge-sm bg-primary">New</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong><span class="copyNumber">+8801833220886</span></strong>

                        <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                            <img src="' . $icon . '" alt="" width="18">
                        </a>
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
                if(auth("admin")->user()->can("status.category"))
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

                            @if(auth("admin")->user()->can("update.category"))
                                <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$customer->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif

                            @if(auth("admin")->user()->can("delete.category"))
                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$customer->id.'" id="deleteBtn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @endif
                        </div>
                    </div>
                ', ['customer' => $customer]);
                return $actionHtml;
            })
            ->rawColumns(['created_by', 'customer_details', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
