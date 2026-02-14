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
use App\Models\Unit;
use App\Models\TaxRate;
use App\Models\Warranty;
use App\Models\ProductVariant;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $warranties           = Warranty::get_data();
        $tax_rates            = TaxRate::get_data();
        return view('admin.pages.product.create', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'warranties', 'units'));
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
                    ->leftJoin('units', 'units.id', 'products.unit_id')
                    ->leftJoin(
                        DB::raw('(SELECT product_id, SUM(qty) as variant_total_qty 
                                  FROM product_variants 
                                  GROUP BY product_id) as pv'),
                        'pv.product_id','=','products.id'
                    );
                   
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

                    if( $request->filled(['min_qty', 'max_qty']) ) {
                        $query->whereBetween(
                            DB::raw('COALESCE(pv.variant_total_qty, products.qty)'),
                            [$request->min_qty, $request->max_qty]);
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

                    // Product Variant
                    if (!empty($request->product_variant)) {
                        $query->whereIn('products.has_variant', $request->product_variant);
                    }

                    // Display Ecommerce
                    if (!empty($request->display_ecom)) {
                        $query->whereIn('products.display_ecommerce', $request->display_ecom);
                    }

                    // Status
                    if (!empty($request->status)) {
                        $query->whereIn('products.status', $request->status);
                    }

            $products = $query->select('products.*', 
                    'categories.category_name as cat_name', 
                    'subcategories.subcategory_name as subCat_name', 
                    'child_categories.name as childCat_name', 
                    'brands.brand_name', 'units.short_name',
                    DB::raw('pv.variant_total_qty as variant_qty'),
                    DB::raw('COALESCE(pv.variant_total_qty, products.qty) as final_qty'))
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
            ->addColumn('quantity', function ($product) {
                return '<div class="">
                       <h6><span class="text-dark">'. $product->final_qty .' '. Str::title($product->short_name) .' </span></h6>
                </div>';
            })
            ->addColumn('product_name', function ($product) {
                $icon = '';

                if (!is_null($product->variant_qty)) {
                    $icon = '<i data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-original-title="Product Variants"
                        class="ti ti-info-circle cursor-pointer"
                        style="font-size: 18px;"></i>';
                }

                return '<div class="copy-row">
                    <h6 style="color: #1e857a;" class="mb-1"><strong>'. $product->name .'</strong></h6>

                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="badge badge-sm bg-primary">New</span>
                        <span class="variant_icon" data-id='. $product->id .'>'.$icon.'</span>
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
                        <i class="ti ti-settings cursor-pointer text-secondary" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Multi Product Image"></i>

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
            ->rawColumns(['checkbox', 'product_name', 'quantity', 'date_info', 'product_details', 'product_img', 'status', 'action'])
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
            $product->barcode                   = 730 . rand(100000000, 999999999);
            $product->unit_id                   = $request->unit_id;
            // $product->vender_id                 = 1;  
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->childCategory_id          = $request->childCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->warranties_id             = $request->warranties_id;
            $product->qty                       = $request->qty;
            $product->alert_qty                 = $request->alert_qty;
            $product->apply_tax_percentage      = $request->apply_tax_percentage;
            $product->apply_tax_type            = $request->apply_tax_type;
            $product->apply_tax_for             = $request->apply_tax_for;

            $product->video_link                = $request->video_link;
            $product->tags                      = $request->tags;
            $product->purchase_price            = $request->purchase_price;
            $product->profit_margin             = $request->profit_margin;
            $product->selling_price             = $request->selling_price;
            $product->discount_type             = $request->discount_type;

            if( $request->discount_type === "none" ){
                $product->discount_value        = null;
            }

            $product->has_variant               = $request->has_variant;
            $product->discount_value            = $request->discount_value;
            $product->discount_date             = $request->discount_date;
            $product->short_description         = $request->short_description;
            $product->long_description          = $request->long_description;
            $product->display_ecommerce         = $request->display_ecommerce;
            $product->return_policy             = $request->return_policy;
            $product->shipping_return           = $request->shipping_return;   
            $product->is_sale                   = $request->is_sale;
            $product->is_top                    = $request->is_top ?? 0;
            $product->is_best                   = $request->is_best ?? 0;
            $product->is_featured               = $request->is_featured;
            $product->is_approved               = 0;  // Note 0=Not Approve, 1=Approve
            $product->status                    = 1;  
            $product->created_by                = Auth::guard('admin')->id();  
            $product->created_at                = now();   
            $product->updated_at                = now();   
            $product->seo_title                 = $request->seo_title ?? '';
            $product->seo_description           = $request->seo_description ?? '';
    
            // Handle image with ImageUploadTraits function
            $uploadImage                        = $this->imageUpload($request, 'thumb_image', 'product');
            $product->thumb_image               =  $uploadImage;
    
            // dd($product);
            $product->save();

            // Check if product has variants and request has variant data
            $hasVariants = $request->has('variant_name') && $request->has('variant_id') 
               && count(array_filter($request->variant_name)) > 0;

            // Product Variants add
            if( $product->has_variant === 'yes' && $hasVariants ){
                foreach ($request->variant_name as $index => $variantName) {
                    if (!empty($variantName)) {
                        ProductVariant::create([
                            'product_id'        => $product->id,
                            'variant_id'        => $request->variant_id[$index],
                            'variant_name'      => $variantName,
                            'variant_code'      => $request->variant_codes[$index],
                            'qty'               => $request->variant_qty[$index],
                            'alert_qty'         => $request->variant_alert_qty[$index],
                            'purchase_price'    => $request->variant_costs[$index],
                            'profit_margin'     => $request->variant_profits[$index],
                            'selling_price'     => $request->variant_prices[$index],
                            'variant_dis_type'  => $request->variant_dis_type[$index],
                            'variant_dis_value' => $request->variant_dis_value[$index],
                            'variant_dis_date'  => $request->variant_dis_date[$index],
                            'status'            => 1,
                        ]);
                    }
                }
            }
            else {
                // No valid variants were provided, update product's has_variant to 'no'
                $product->has_variant = 'no';
                $product->save();
            }
        }

        catch(Exception $ex){
            DB::rollBack();
            throw $ex;
            Toastr::error('Product create error', 'Error', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Product Create Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        // return redirect()->route('admin.product.index');
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
        $warranties           = Warranty::get_data();
        $tax_rates            = TaxRate::get_data();

        return view('admin.pages.product.edit', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'warranties', 'units', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        if (!$this->user || !$this->user->can('update.product')) {
            throw UnauthorizedException::forPermissions(['update.product']);
        }

        $product  = Product::find($id);

        DB::beginTransaction();
        try {

            $product->name                      = $request->name;
            $product->slug                      = Str::slug($request->name);
            $product->sku                       = $request->sku;
            // $product->barcode                   = 730 . rand(100000000, 999999999);
            // $product->vender_id                 = 1;  // Note 1=admin, 2=vendor
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->childCategory_id          = $request->childCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->qty                       = $request->qty;
            $product->units                     = $request->units;
            $product->video_link                = $request->video_link;
            $product->tags                      = $request->tags;
            $product->purchase_price            = $request->purchase_price;
            $product->selling_price             = $request->selling_price;
            $product->discount_type             = $request->discount_type;
            if( $request->discount_type === "none" ){
                $product->discount_value        = null;
            }
            else{
                $product->discount_value        = $request->discount_value;
            }
            $product->offer_start_date          = $request->offer_start_date;
            $product->offer_end_date            = $request->offer_end_date;
            $product->short_description         = $request->short_description;
            $product->long_description          = $request->long_description;
            $product->return_policy             = $request->return_policy;
            $product->shipping_return           = $request->shipping_return;
            // $product->type                      = $request->type ?? 1;
            $product->is_top                    = $request->is_top;
            $product->is_best                   = $request->is_best;
            $product->is_featured               = $request->is_featured;
            $product->is_approved               = 1;  // Note 0=Not Approve, 1=Approve
            $product->seo_title                 = $request->seo_title;
            $product->seo_description           = $request->seo_description;
            $product->status                    = 1;
    
            // Handle image with ImageUploadTraits function
            $uploadImages                     = $this->deleteImageAndUpload($request, 'thumb_image', 'product', $product->thumb_image );
            $product->thumb_image           =  $uploadImages;
        
            $product->update();
        }
        catch(Exception $ex){
            DB::rollBack();
            // throw $ex;
            Toastr::error('Product updated error', 'Error', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Product updated successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.product.index');
        // return response()->json(['message'=> "Successfully Product Updated!", 'status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$this->user || !$this->user->can('delete.product')) {
            throw UnauthorizedException::forPermissions(['delete.product']);
        }

        // 1️⃣ Delete all variants
        ProductVariant::where('product_id', $product->id)->delete();

        if ($product->thumb_image) {
            if (file_exists($product->thumb_image)) {
                unlink($product->thumb_image);
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product has been deleted.'], 200);
    }


    public function product_variant_show(Request $request)
    {
        // dd($request->id);
        $product = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                ->leftJoin('child_categories', 'child_categories.id', 'products.childCategory_id')
                ->leftJoin('brands', 'brands.id', 'products.brand_id')
                ->leftJoin('units', 'units.id', 'products.unit_id')
                ->select('products.*', 'categories.category_name as cat_name', 'subcategories.subcategory_name as subCat_name', 'child_categories.name as childCat_name', 'brands.brand_name', 'units.short_name')
                ->where('products.id', $request->id)
                ->first();

        $variants = ProductVariant::where('product_id', $request->id)->get();
        return response()->json([
            'success' => $variants,
            'product' => $product,
        ]);
    }

    public function product_bulk_action(Request $request)
    {
        $ids = $request->ids;
        $count = count($ids);
        $action = $request->action;
        $message = '';

        $products = Product::whereIn('id', $ids)->get();
            
        foreach ($products as $row) {
            if ($row->thumb_image) {
                $imagePath = public_path(str_replace('public/', '', $row->thumb_image));
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        if ($action == 'delete') {
            DB::transaction(function () use ($ids) {

                // 1️⃣ Delete all variants
                ProductVariant::whereIn('product_id', $ids)->delete();
            
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

    // public function getSubCategories(Request $request, Category $category)
    // {
    //     $subcats= SubCategory::where('category_id', $category->id)->get();
    //     return response()->json(['message' => 'success', 'data' => $subcats], 200);
    // }


    // public function get_product_subCategory_data(Request $request)
    // {
    //     // dd($request->all());
    //     $subCategories = Subcategory::where('category_id', $request->id)->where('status', 1)->get();

    //     // 'subcategory_img' is the column name where image filename is stored
    //     foreach ($subCategories as $subCategory) {
    //         $subCategory->image_url = asset($subCategory->subcategory_img); 
    //     }

    //     return response()->json(['status' => true, 'data' => $subCategories]);
    // }

    // public function get_product_childCategory_data(Request $request)
    // {
    //     // dd($request->all());
    //     $childCategories = ChildCategory::where('subCategory_id', $request->id)->where('status', 1)->get();

    //     // 'subcategory_img' is the column name where image filename is stored
    //     foreach ($childCategories as $childCategory) {
    //         $childCategory->image_url = asset($childCategory->img); 
    //     }

    //     return response()->json(['status' => true, 'data' => $childCategories]);
    // }


    public function show($id)
    {
        // dd($id);
        $product = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                ->leftJoin('child_categories', 'child_categories.id', 'products.childCategory_id')
                ->leftJoin('brands', 'brands.id', 'products.brand_id')
                ->leftJoin('units', 'units.id', 'products.unit_id')
                ->leftJoin('warranties', 'warranties.id', 'products.warranties_id')
                ->leftJoin(
                    DB::raw('(SELECT product_id, SUM(qty) as variant_total_qty 
                            FROM product_variants 
                            GROUP BY product_id) as pv'),
                    'pv.product_id','=','products.id'
                )
                ->select('products.*', 
                    'categories.category_name as cat_name', 
                    'subcategories.subcategory_name as subCat_name', 
                    'child_categories.name as childCat_name', 
                    'brands.brand_name', 'units.short_name',
                    'warranties.duration', 'warranties.period',
                    DB::raw('pv.variant_total_qty as variant_qty'),
                    DB::raw('COALESCE(pv.variant_total_qty, products.qty) as final_qty'))
                ->where('products.id', $id)
                ->first();

        $variants = ProductVariant::where('product_id', $id)->get();

        return view('admin.pages.product.view', compact('product', 'variants'));
    }


    // public function product_variant($product_id)
    // {
    //     if (!$this->user || !$this->user->can('variant.product')) {
    //         throw UnauthorizedException::forPermissions(['variant.product']);
    //     }

    //     // Product Color
    //     $data['product_id']       = $product_id;
    //     $data['size_value']       = AttributeValue::where('attribute', "size")->where('status', 1)->get();
    //     $data['color_value']      = AttributeValue::where('attribute', "color")->where('status', 1)->get();
    //     $data['productImages']    = ProductImage::where('product_id', $product_id)->orderBy('order_id', 'asc')->get();
    //     $data['productSizes']     = ProductSize::where('product_id', $product_id)->get();
    //     $data['productColors']    = ProductColor::where('product_id', $product_id)->get();

    //     return view('backend.pages.products.product_variant', $data);
    // }
    
    
    // public function update_product_variant(Request $request, $id)
    // {
    //     // Handle Product sizes
    //     if ($request->has('size_name') && $request->has('size_price')) {
    //         foreach ($request->size_name as $index => $sizeName) {
    //             if (!empty($sizeName)) {
    //                 // Find existing ProductSize by size_id, or create a new one
    //                 ProductSize::updateOrCreate(
    //                     [
    //                         'product_id' => $id, 
    //                         'size_id' => $request->size_id[$index] // Match on product_id and size_id
    //                     ],
    //                     [
    //                         'size_name' => $sizeName, // Update or set size_name
    //                         'size_price' => $request->size_price[$index], // Update or set size_price
    //                         'stock' => $request->stock[$index] // Update or set stock
    //                     ]
    //                 );
    //             }
    //         }
    //     }


    //     // Handle Product Colors
    //     if ($request->has('color_name')) {
    //         foreach ($request->color_name as $row => $colorName) {
    //             if (!empty($colorName)) {
    //                 // Find existing ProductColor by color_id, or create a new one
    //                 $productColor = ProductColor::updateOrCreate(
    //                     [
    //                         'product_id' => $id, 
    //                         'color_id' => $request->color_id[$row] // Match on product_id and color_id
    //                     ],
    //                     [
    //                         'color_name' => $colorName, // Update or set color_name
    //                         'color_price' => $request->color_price[$row], // Update or set color_price
    //                         'color_code' => $request->color_code[$row] // Update or set color_code
    //                     ]
    //                 );
    //             }
    //         }
    //     }


    //     Toastr::success('Product variation successfully updated', 'Success', ["positionClass" => "toast-top-right"]);
    //    return redirect()->back();
    // }

    // public function product_images_store(Request $request, $id)
    // {
    //     // Multiple images store
    //     if($request->hasFile('images')) {
    //         foreach($request->file('images') as $image) {

    //             $productImages = new ProductImage();
    //             $productImages->product_id = $id;
    
    //             // Generate unique image name
    //             $imageName = $request->slug . rand(1, 99999999) . '.' . $image->getClientOriginalExtension();
    //             $imagePath = 'public/backend/images/multiple-image/';
    //             $image->move($imagePath, $imageName);
    //             $productImages->images   =  $imagePath . $imageName;

    //             $productImages->save();
    //         }
    //     }

    //     Toastr::success('Product image successfully updated', 'Success', ["positionClass" => "toast-top-right"]);
    //     return redirect()->back();
    // }

    // public function product_images_sortable(Request $request)
    // {
    //     //  dd($request->photo_id);
    //     if( !empty($request->photo_id) ){
    //         $i = 1;
    //         foreach( $request->photo_id as $image_id ){
    //             $productImage = ProductImage::findOrFail($image_id);

    //             $productImage->order_id = $i;
    //             $productImage->save();

    //             $i++;
    //         }
    //     }
    //     return response()->json(['status' => 'success']);
    // }

    // // Delete Multiple Product images variants
    // public function delete_multiple_image($id)
    // {
    //     try {
    //         $productImg = ProductImage::findOrFail($id);
    //         if( !is_null( $productImg ) ){
    //             if( file_exists( $productImg->images )){
    //                 unlink($productImg->images);
    //             }
    //             $productImg->delete();
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Image deleted successfully.',
    //         ]);
    //     } 
    //     catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to delete the image.',
    //         ]);
    //     }
    // }

    // // Delete Multiple Product size variants
    // public function delete_size_variants(Request $request)
    // {
    //     // dd($request->all());
    //     $productSize = ProductSize::findOrFail($request->id);
    //     if( !is_null( $productSize ) ){
    //         $productSize->delete();
    //     }

    //    return response()->json([
    //         'status' => true,
    //         'message' => "Product Variant remove",
    //    ]);
    // }


    // // Delete Multiple Product color variants
    // public function delete_color_variants(Request $request)
    // {
    //     $productColor = ProductColor::findOrFail($request->id);
    //     if( !is_null( $productColor ) ){
    //         $productColor->delete();
    //     }

    //    return response()->json([
    //         'status' => true,
    //         'message' => "Product Variant remove",
    //    ]);
    // }
}
