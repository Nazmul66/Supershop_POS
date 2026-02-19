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
        $warranties           = Warranty::get_data();
        $tax_rates            = TaxRate::get_data();
        $variant_values       = VariantValue::where('status', 1)->get();
        return view('admin.pages.product.create', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'warranties', 'units', 'variant_values'));
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



        $agent = new Agent();
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
            $productUpdate = new ProductUpdate();

            $productUpdate->product_id   = $page->id;
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
            $product->stock_type                = $request->stock_type ?? "in_stock";
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
                foreach ($request->variant_value as $index => $variant_value) {
                    if (!empty($variant_value)) {
                        ProductVariant::create([
                            'product_id'        => $product->id,
                            'variant_id'        => $request->variant_id[$index],
                            'variant_name'      => $request->variant_name[$index],
                            'variant_value'     => $variant_value,
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
        $variant_values       = VariantValue::where('status', 1)->get();
        $variants             = ProductVariant::where('product_id', $product->id)->get();

        return view('admin.pages.product.edit', compact('categories', 'subCategories', 'childCategories', 'brands', 'tax_rates', 'warranties', 'units', 'product', 'variants', 'variant_values'));
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
            $product->stock_type                = $request->stock_type ?? "in_stock";
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
            $uploadImages                     = $this->deleteImageAndUpload($request, 'thumb_image', 'product', $product->thumb_image );
            $product->thumb_image           =  $uploadImages;
        
            // dd($product);
            $product->save();

            $hasVariants = $request->has('variant_name') && $request->has('variant_id') &&
               count(array_filter($request->variant_name)) > 0;

            if ($product->has_variant === 'yes' && $hasVariants) {
                $variantIds = [];
                foreach ($request->variant_value as $index => $variant_value) {
                    if (!empty($variant_value)) {
                        $variant = ProductVariant::updateOrCreate(
                            // Condition (find by ID if exists)
                            ['id' => $request->variant_row_id[$index] ?? null],
                            // Data to update or insert
                            [
                                'product_id'        => $product->id,
                                'variant_id'        => $request->variant_id[$index],
                                'variant_name'      => $request->variant_name[$index],
                                'variant_value'     => $variant_value,
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
                            ]
                        );
                        $variantIds[] = $variant->id;
                    }
                }

                // 🔥 Delete removed variants
                ProductVariant::where('product_id', $product->id)
                    ->whereNotIn('id', $variantIds)
                    ->delete();
            }
            else {
                // No variants → remove all
                ProductVariant::where('product_id', $product->id)->delete();
                $product->has_variant = 'no';
                $product->save();
            }

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
                $productUpdate = new ProductUpdate();

                $productUpdate->product_id   = $product->id;
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
        $productUpdates = ProductUpdate::where('product_id', $id)->get();

        return view('admin.pages.product.view', compact('product', 'variants', 'productUpdates'));
    }

}
