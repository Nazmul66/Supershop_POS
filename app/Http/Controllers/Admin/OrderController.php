<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.order.create');
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

    public function customerSearch(Request $request)
    {
        // dd($request->all());
        $customers = Customer::
        where('cus_phone', 'LIKE', "%{$request->phone}%")
        ->where('status', 1)
        ->limit(3)
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $customers
        ]);
    }
    
    public function customerSelect(Request $request)
    {
        // dd($request->all());
        $customer = Customer::findOrFail($request->id);

        // dd($customer);
        return response()->json([
            'status' => true,
            'data' => [
                'id' => $customer->id,
                'cus_id' => $customer->cus_id,
                'name' => $customer->cus_name,
                'phone' => $customer->cus_phone,
                'address' => $customer->cus_address,
                'tag' => $customer->cus_tag,
            ]
        ]);
    }

}
