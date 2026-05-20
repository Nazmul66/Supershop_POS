<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTraits;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\ProductUpdate;
use App\Models\Unit;
use App\Models\TaxRate;
use App\Models\Warranty;
use App\Models\VariantValue;
use App\Models\ProductVariant;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ProductController extends Controller
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
        $admins               = Admin::where('status', 1)->get();
        $products             = Product::where('status', 1)->get();
        $categories           = Category::get_data();
        $subCategories        = Subcategory::get_data();
        $childCategories      = ChildCategory::get_data();
        $brands               = Brand::get_data();
        $units                = Unit::get_data();
        $warranties           = Warranty::get_data();
        $tax_rates            = TaxRate::get_data();

        return view('admin.pages.product.index', compact('categories', 'subCategories', 'childCategories', 'brands', 'units', 'warranties', 'tax_rates', 'products', 'admins'));
    }

    public function create()
    {
        if (!$this->user || !$this->user->can('create.product')) {
            throw UnauthorizedException::forPermissions(['create.product']);
        }

        $categories           = Category::get_data();
        $subCategories        = Subcategory::get_data();
        $childCategories      = ChildCategory::get_data();
        $brands               = Brand::get_data();
        $units                = Unit::get_data();
        $tax_rates            = TaxRate::get_data();
        return view('admin.pages.product.create', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'units'));
    }

    public function getData(Request $request)
    {
        // dd($request->all());
        // get all data
        $products = "";
           $query = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                    ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                    ->leftJoin('child_categories', 'child_categories.id', 'products.childCategory_id')
                    ->leftJoin('brands', 'brands.id', 'products.brand_id')
                    ->leftJoin('units', 'units.id', 'products.unit_id');
                   
                    // Category
                    if( !empty($request->category_id) ){
                        $query->where('products.category_id', $request->category_id);
                    }

                    // Subcategory
                    if( !empty($request->subCategory_id) ){
                        $query->where('products.subCategory_id', $request->subCategory_id);
                    }

                    // Brand
                    if( !empty($request->brand_id) ){
                        $query->where('products.brand_id', $request->brand_id);
                    }

                    // Date Range created_at
                    if (!empty($request->creation_date)) {

                        $dates = explode(' - ', $request->creation_date);
                    
                        if (count($dates) === 2) {
                            $start = Carbon::parse($dates[0])->startOfDay();
                            $end   = Carbon::parse($dates[1])->endOfDay();
                    
                            $query->whereBetween('products.created_at', [$start, $end]);
                        }
                    }

                    // Admin User
                    if (!empty($request->admin_user)) {
                        $query->whereIn('products.created_by', $request->admin_user);
                    }

                    // Status
                    if (!empty($request->status)) {
                        $query->whereIn('products.status', $request->status);
                    }

            $products = $query->select('products.*', 
                    'categories.category_name as cat_name', 
                    'subcategories.subcategory_name as subCat_name', 
                    'child_categories.name as childCat_name', 
                    'brands.brand_name', 'units.short_name')
                    ->orderBy('products.id', "DESC")
                    ->get();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($product) {
                return ' <label class="checkboxs">
                        <input type="checkbox" class="row-checkbox" value="'.$product->id.'">
                        <span class="checkmarks"></span>
                    </label>';
            })
            ->addColumn('product_name', function ($product) {
                return '<div class="copy-row">
                    <h6 style="color: #1e857a;" class="mb-1"><strong>'. $product->name .'</strong></h6>

                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="badge badge-sm bg-primary">New</span>
                    </div>
                </div>';
            })
            ->addColumn('product_img', function ($product) {
                return ' <a href="'.asset( $product->thumb_image ).'" target="__blank">
                      <img src="'.asset( $product->thumb_image ).'" width="45px" height="45px">
                </a>';
            })
            ->addColumn('product_details', function ($product) {
                $subCat = $product->subCat_name ?? 'N/A';
                return '<div class="">
                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Category Name:</span> '. $product->cat_name .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">SubCategory Name:</span> '. $subCat .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">ChildCategory Name:</span> '. ($product->childCat_name ?: 'N/A') .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Brand Name:</span> '. $product->brand_name .'</p>
                </div>';
            })
            ->addColumn('date_info', function ($product) {
                $created_by = \App\Models\Admin::find($product->created_by)?->name ?? 'Unknown';
                $updated_by = \App\Models\Admin::find($product->updated_by)?->name ?? 'Unknown';

                return '<div class="">
                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Created at:</span> '. $product->created_at->format('M j, Y h:i A') .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Updated at:</span> '. $product->updated_at->format('M j, Y h:i A') .'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Created by:</span> '. $created_by.'</p>

                    <p class="mb-1"><span class="text-dark" style="font-weight: 600;">Updated by:</span> '. $updated_by .'</p>
                </div>';
            })
            ->addColumn('status', function ($product) {
                if(auth("admin")->user()->can("status.product"))
                    if ($product->status == 1) {
                        return ' <a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$product->id.'" data-status="'.$product->status.'"> <i
                                class="fa-solid fa-toggle-on fa-2x text-success"></i>
                        </a>';
                    } else {
                        return '<a class="status" id="status" href="javascript:void(0)"
                            data-id="'.$product->id.'" data-status="'.$product->status.'"> <i
                                class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                        </a>';
                    }
                else{
                    return '<span class="badge bg-info">N/A</span>'; 
                }
            })
            ->addColumn('action', function ($product) {
                $actionHtml = Blade::render('<div class="copy-row">
                    <div class="all_icons mb-2">
                        <a href="'. route('admin.product.show', $product->id) .'">
                            <i data-tooltip="tip1" class="ti ti-eye cursor-pointer tooltip-trigger"
                            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="View"></i>
                        </a>

                        @if(auth("admin")->user()->can("update.product"))
                            <a href="'. route('admin.product.edit', $product->id) .'">
                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-info" data-bs-placement="top" data-bs-original-title="Edit"></i>
                            </a>
                        @endif

                        @if(auth("admin")->user()->can("delete.product"))
                            <a href="javascript:void(0)" data-id="'.$product->id.'" id="deleteBtn">
                                <i class="ti ti-trash cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-danger" data-bs-placement="top" title="Delete"></i>
                            </a>
                        @endif
                    </div>
                </div>', ['product' => $product]);
                return $actionHtml;
            })
            ->rawColumns(['checkbox', 'product_name', 'date_info', 'product_details', 'product_img', 'status', 'action'])
            ->make(true);
    }

    public function changeProductStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('status.product')) {
            throw UnauthorizedException::forPermissions(['status.product']);
        }

        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Product::findOrFail($id);
        $page->status = $status;
        $page->save();

        // Get changed fields
        $changes = $page->getChanges(); // only changed fields

        if (!empty($changes)) {
            $changes = Arr::except($changes, ['created_at', 'updated_at']);
            $fields = array_keys($changes);
        
            // Convert snake_case to normal words
            $formattedFields = array_map(function ($field) {
                return ucwords(str_replace('_', ' ', $field));
            }, $fields);
        
            // Make sentence
            $message = 'Product information has been updated. Modified fields:' . implode(', ', $formattedFields) . '.';

            // dd($changes);
            // Product Log Update
            $this->logProductUpdate($page->id, $message, $request);
        }

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        if (!$this->user || !$this->user->can('create.product')) {
            throw UnauthorizedException::forPermissions(['create.product']);
        }

        // dd($request->all());
        DB::beginTransaction();
        try {
            $product = new Product();

            $product->name                      = $request->name;
            $product->slug                      = Str::slug($request->name);
            $product->sku                       = $request->sku;
            $product->barcode                   = $request->barcode;
            $product->unit_id                   = $request->unit_id;
            $product->vender_id                 = 1;  
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->childCategory_id          = $request->childCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->apply_tax_percentage      = $request->apply_tax_percentage;
            $product->apply_tax_type            = $request->apply_tax_type;
            $product->apply_tax_for             = $request->apply_tax_for;
            $product->tags                      = $request->tags;
            $product->is_sale                   = $request->is_sale;
            $product->is_approved               = 0;  // Note 0=Not Approve, 1=Approve
            $product->status                    = 1;  
            $product->created_by                = Auth::guard('admin')->id();  
            $product->created_at                = now();   
            $product->updated_at                = now();   
    
            // Handle image with ImageUploadTraits function
            $uploadImage                        = $this->imageUpload($request, 'thumb_image', 'product');
            $product->thumb_image               =  $uploadImage;
    
            // dd($product);
            $product->save();
        }

        catch(Exception $ex){
            DB::rollBack();
            throw $ex;
            Toastr::error('Product create error', 'Error', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Product Create Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully Product Created!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!$this->user || !$this->user->can('update.product')) {
            throw UnauthorizedException::forPermissions(['update.product']);
        }

        // dd($product);
        $product              = Product::findOrFail($id);
        $categories           = Category::get_data();
        $subCategories        = Subcategory::get_data();
        $childCategories      = ChildCategory::get_data();
        $brands               = Brand::get_data();
        $units                = Unit::get_data();
        $tax_rates            = TaxRate::get_data();

        return view('admin.pages.product.edit', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'units', 'product',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.product')) {
            throw UnauthorizedException::forPermissions(['update.product']);
        }

        // dd('kaj kore');
        $product  = Product::find($id);
        // dd($product);

        DB::beginTransaction();
        try {
            $product->name                      = $request->name;
            $product->slug                      = Str::slug($request->name);
            $product->sku                       = $request->sku;
            $product->barcode                   = $request->barcode;
            $product->unit_id                   = $request->unit_id;
            $product->vender_id                 = 1;  
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->childCategory_id          = $request->childCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->apply_tax_percentage      = $request->apply_tax_percentage;
            $product->apply_tax_type            = $request->apply_tax_type;
            $product->apply_tax_for             = $request->apply_tax_for;
            $product->tags                      = $request->tags;
            $product->is_sale                   = $request->is_sale;
            $product->is_approved               = $request->is_approved ?? 0;  // Note 0=Not Approve, 1=Approve
            $product->status                    = 1;  
            $product->updated_by                = Auth::guard('admin')->id();  
            $product->updated_at                = now();   
            $product->seo_title                 = $request->seo_title ?? '';
            $product->seo_description           = $request->seo_description ?? '';
    
            // Handle image with ImageUploadTraits function
            $uploadImages                     = $this->deleteImageAndUpload($request, 'thumb_image', 'product', $product->thumb_image );
            $product->thumb_image           =  $uploadImages;
        
            // dd($product);
            $product->save();
        
            $agent = new Agent();
            // Get changed fields
            $changes = $product->getChanges(); // only changed fields

            if (!empty($changes)) {
                $changes = Arr::except($changes, ['created_at', 'updated_at']);
                $fields = array_keys($changes);
            
                // Convert snake_case to normal words
                $formattedFields = array_map(function ($field) {
                    return ucwords(str_replace('_', ' ', $field));
                }, $fields);
            
                // Make sentence
                $message = 'Product information has been updated. Modified fields:' . implode(', ', $formattedFields) . '.';

                // dd($changes);
                // Product Log Update
                $this->logProductUpdate($product->id, $message, $request);
            }

        }
        catch(Exception $ex){
            DB::rollBack();
            // dd($ex);
            // throw $ex;
            Toastr::error('Product updated error', 'Error', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Product Update Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully Product Updated!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$this->user || !$this->user->can('delete.product')) {
            throw UnauthorizedException::forPermissions(['delete.product']);
        }

        if ($product->thumb_image) {
            if (file_exists($product->thumb_image)) {
                unlink($product->thumb_image);
            }
        }

        ProductUpdate::where('product_id', $product->id)->delete();

        $product->delete();
        return response()->json(['message' => 'Product has been deleted.'], 200);
    }


    public function product_bulk_action(Request $request)
    {
        $ids = $request->ids;
        $count = count($ids);
        $action = $request->action;
        $message = '';

        if ($action == 'delete') {
            DB::transaction(function () use ($ids) {

                // 1️⃣ Delete all variants
                ProductUpdate::whereIn('product_id', $ids)->delete();
            
                // 2️⃣ Fetch products to delete their images
                $products = Product::whereIn('id', $ids)->get();
            
                foreach ($products as $row) {
                    if ($row->thumb_image) {
                        $fullPath = public_path($row->thumb_image);
                        if (file_exists($fullPath)) {
                            @unlink($fullPath);
                        }
                    }
                }
            
                // 3️⃣ Delete products
                Product::whereIn('id', $ids)->delete();
            });

            $message= "$count product(s) have been deleted successfully.";
        }

        if ($action == 'active') {
            Product::whereIn('id', $ids)->update(['status' => 1]);
            $message = "$count product(s) marked as Active successfully.";
        }

        if ($action == 'inactive') {
            Product::whereIn('id', $ids)->update(['status' => 0]);
            $message = "$count product(s) marked as Inactive successfully.";
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function show($id)
    {
        // dd($id);
        $product = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                ->leftJoin('child_categories', 'child_categories.id', 'products.childCategory_id')
                ->leftJoin('brands', 'brands.id', 'products.brand_id')
                ->leftJoin('units', 'units.id', 'products.unit_id')
                ->select('products.*', 
                    'categories.category_name as cat_name', 
                    'subcategories.subcategory_name as subCat_name', 
                    'child_categories.name as childCat_name', 
                    'brands.brand_name', 'units.short_name')
                ->where('products.id', $id)
                ->first();

        $productUpdates = ProductUpdate::where('product_id', $id)->get();
        return view('admin.pages.product.view', compact('product', 'productUpdates'));
    }


    private function logProductUpdate($productId, $message, $request)
    {
        $agent = new Agent();

        $productUpdate = new ProductUpdate();

        $productUpdate->product_id   = $productId;
        $productUpdate->admin_id     = Auth::guard('admin')->id();
        $productUpdate->ip_address   = $request->ip();
        $productUpdate->device       = $agent->browser();
        $productUpdate->user_agent   = $request->userAgent();
        $productUpdate->country      = Location::get($request->ip())->countryName ?? null;
        $productUpdate->changes      = $message;
        $productUpdate->updated_at   = now();

        // dd($productUpdate);
        $productUpdate->save();
    }

}
