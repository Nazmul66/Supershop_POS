<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class FinancialSettingController extends Controller
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
    return view('admin.pages.financial_settings.tax_rate_setting');
  }

  public function getData()
  {
      // get all data
      $taxRates = TaxRate::all();

      return DataTables::of($taxRates)
          ->addIndexColumn()
          ->addColumn('created_by', function ($taxRate) {
              $adminName = \App\Models\Admin::find($taxRate->created_by)?->name ?? 'Unknown';
              $adminEmail = \App\Models\Admin::find($taxRate->created_by)?->email ?? 'Unknown';
              $adminImage = \App\Models\Admin::find($taxRate->created_by)?->image ?? 'Unknown';
              return '<div class="d-flex align-items-center">
                    <img  class="rounded-circle me-2" width="40"  height="40" src="'.asset($adminImage) .'" />
                    <div>
                      <p class="mb-0">'. $adminName .'</p> 
                      <p class="mb-0">'. $adminEmail .'</p>
                    </div>
              </div>';
          })
          ->addColumn('status', function ($taxRate) {
              if(auth("admin")->user()->can("status.tax"))
                  if ($taxRate->status == 1) {
                      return ' <a class="status" id="status" href="javascript:void(0)"
                          data-id="'.$taxRate->id.'" data-status="'.$taxRate->status.'"> <i
                              class="fa-solid fa-toggle-on fa-2x text-success"></i>
                      </a>';
                  } else {
                      return '<a class="status" id="status" href="javascript:void(0)"
                          data-id="'.$taxRate->id.'" data-status="'.$taxRate->status.'"> <i
                              class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                      </a>';
                  }
              else{
                  return '<span class="badge bg-info">N/A</span>'; 
              }
          })
          ->addColumn('action', function ($taxRate) {
              $actionHtml = Blade::render('
                  <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions <i class="mdi mdi-chevron-down"></i>
                      </button>

                      <div class="dropdown-menu dropdownmenu-primary" style="">
                          @if(auth("admin")->user()->can("update.tax"))
                              <a class="dropdown-item text-success" id="editButton" href="javascript:void(0)" data-id="'.$taxRate->id.'" data-bs-toggle="modal" data-bs-target="#editModal">
                                  <i class="fas fa-edit"></i> Edit
                              </a>
                          @endif

                          @if(auth("admin")->user()->can("delete.tax"))
                              <a class="dropdown-item text-danger" href="javascript:void(0)" data-id="'.$taxRate->id.'" id="deleteBtn">
                                  <i class="fas fa-trash"></i> Delete
                              </a>
                          @endif
                      </div>
                  </div>
              ', ['taxRate' => $taxRate]);
              return $actionHtml;
          })
          ->rawColumns(['created_by', 'status', 'action'])
          ->make(true);
  }

  public function changeTaxRateStatus(Request $request)
  {
      if (!$this->user || !$this->user->can('status.tax')) {
          throw UnauthorizedException::forPermissions(['status.tax']);
      }

      $id = $request->id;
      $Current_status = $request->status;

      if ($Current_status == 1) {
          $status = 0;
      } else {
          $status = 1;
      }

      $page = TaxRate::findOrFail($id);
      $page->status = $status;
      $page->save();

      return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      if (!$this->user || !$this->user->can('create.tax')) {
          throw UnauthorizedException::forPermissions(['create.tax']);
      }

      $request->validate(
        [
          'tax_name' => ['required', 'unique:tax_rates,tax_name', 'max:255'],
          'percentage' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'between:0,100'],
        ]
      );

      DB::beginTransaction();
      try {
          $taxRate = new TaxRate();
          $taxRate->tax_name               = Str::title($request->tax_name);
          $taxRate->percentage             = $request->percentage;
          $taxRate->status                 = $request->status;
          $taxRate->created_by             = Auth::guard('admin')->id();
          $taxRate->created_at             = now();
          $taxRate->updated_at             = now();

          // dd($taxRate);
          $taxRate->save();
      }
      catch(\Exception $ex){
          DB::rollBack();
          throw $ex;
          // dd($ex->getMessage());
      }

      DB::commit();
      return response()->json([
          'status' => true,
          'message' => 'Successfully TaxRate Created!',
          'taxRate' => [
              'id' => $taxRate->id,
              'tax_name' => $taxRate->tax_name,
              'percentage' => $taxRate->percentage,
          ]
      ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(TaxRate $taxRate)
  {
      if (!$this->user || !$this->user->can('update.tax')) {
          throw UnauthorizedException::forPermissions(['update.tax']);
      }

      // dd($taxRate);
      return response()->json(['success' => $taxRate]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
      if (!$this->user || !$this->user->can('update.tax')) {
          throw UnauthorizedException::forPermissions(['update.tax']);
      }

      $request->validate(
        [
          'tax_name' => ['required', 'unique:tax_rates,tax_name,' . $id, 'max:255'],
          'percentage' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'between:0,100'],
        ]
      );

      $taxRate  = TaxRate::find($id);

      DB::beginTransaction();
      try {
        $taxRate->tax_name               = Str::title($request->tax_name);
        $taxRate->percentage             = $request->percentage;
        $taxRate->status                 = $request->status;
        $taxRate->created_by             = Auth::guard('admin')->id();
        $taxRate->updated_at             = now();

        $taxRate->save();
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
  public function destroy(TaxRate $taxRate)
  {
      if (!$this->user || !$this->user->can('delete.tax')) {
          throw UnauthorizedException::forPermissions(['delete.tax']);
      }

      $taxRate->delete();
      return response()->json(['message' => 'Tax Rate has been deleted.'], 200);
  }


  public function allTaxRatePdf()
  {
      if (!$this->user || !$this->user->can('pdf.tax')) {
          throw UnauthorizedException::forPermissions(['pdf.tax']);
      }
      
      $taxRate = TaxRate::get();

      $pdf = Pdf::loadView('admin.pages.brands.pdf', compact('taxRate'))
          ->setPaper('a4', 'portrait');

      return $pdf->download('taxRate.pdf');
      // return view('admin.pages.brands.pdf', compact('categories'));
  }

}
