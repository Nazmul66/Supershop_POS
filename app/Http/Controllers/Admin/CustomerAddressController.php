<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // dd($request->all());
        $request->validate([
            'map_location'   => 'required|string|max:512',
            'address'        => 'required|string|max:512',
        ]);

        $customerAddress  = new CustomerAddress();

        DB::beginTransaction();
        try {
            $customerAddress->customer_id         = $request->customer_id;
            $customerAddress->address             = $request->address;
            $customerAddress->map_location        = $request->map_location;
            $customerAddress->save_as             = $request->save_as;
            $customerAddress->status              = $request->status ?? 1;
            $customerAddress->created_at          = now();
            $customerAddress->updated_at          = now();

            // dd($customerAddress);
            $customerAddress->save();

            // Customer Address Update
            $customer = Customer::findOrFail($customerAddress->customer_id);
            $customer->cus_address  = $customerAddress->address;
            $customer->save_as      = $customerAddress->save_as;
            $customer->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        $customer = Customer::find($customerAddress->customer_id);

        return response()->json([
            'message'=> "success",
            'status' => true,
            'data' => [
                'id' => $customer->id,
                'cus_id' => $customer->cus_id,
                'name' => $customer->cus_name,
                'phone' => $customer->cus_phone,
                'address' => $customer->cus_address,
                'tag' => $customer->cus_tag,
            ]
        ]
        ,200);
    }

    public function allCusAddressShow(Request $request)
    {
        // dd($request->all());
        $cus_address = CustomerAddress::where('customer_id', $request->id)->get();
    
        return response()->json([
            'message'=> "success",
            'status' => true,
            'data' => $cus_address,
        ]);
    }


    public function selectCusAddress(Request $request)
    {
        // dd($request->all());
        $cus_address = CustomerAddress::findOrFail($request->id);

        $customer = Customer::where('id', $cus_address->customer_id)->first();
        $customer->cus_address   = $cus_address->address;
        $customer->save_as       = $cus_address->save_as;
        $customer->save();

        return response()->json([
            'message'=> "success",
            'status' => true,
            'data' => $cus_address,
        ]);
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
    public function edit(CustomerAddress $customerAddress)
    {
        // dd($customerAddress);
        return response()->json([
            'status' => true,
            'success' => $customerAddress
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'map_location'   => 'required|string|max:512',
            'address'        => 'required|string|max:512',
        ]);

        $customerAddress  = CustomerAddress::findOrFail($id);
        // dd($customerAddress);

        DB::beginTransaction();
        try {
            $customerAddress->address             = $request->address;
            $customerAddress->map_location        = $request->map_location;
            $customerAddress->save_as             = $request->save_as;
            $customerAddress->status              = $request->has('status') ? $request->status 
                                                    : $customerAddress->status;
            $customerAddress->updated_at          = now();

            // dd($customerAddress);
            $customerAddress->save();

            // Customer Address Update
            $customer = Customer::findOrFail($customerAddress->customer_id);
            $customer->cus_address  = $customerAddress->address;
            $customer->save_as      = $customerAddress->save_as;
            $customer->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        $customer = Customer::find($customerAddress->customer_id);

        return response()->json([
            'message'=> "success",
            'status' => true,
            'data' => [
                'id' => $customer->id,
                'cus_id' => $customer->cus_id,
                'name' => $customer->cus_name,
                'phone' => $customer->cus_phone,
                'address' => $customer->cus_address,
                'tag' => $customer->cus_tag,
            ]
        ]
        ,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
