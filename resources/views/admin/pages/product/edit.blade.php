@extends('admin.layout.master')

@push('title')
    Update Product
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/dropify.min.css') }}">

    <style>
        label{
            font-size: 13px;
            color: #1d1c1c;
            font-weight: 600;
        }
        .table thead tr th {
            background-color: #092C4C !important;
        }
        .variants_body{
            height: 0;
            opacity: 0;
            transform: translateX(-125%);
            pointer-events: none;
            transition: all 0.5s ease-in-out; 
        }
        .variants_body.actives{
            height: 310px;
            opacity: 1;
            transform: translateX(0%);
            pointer-events: auto;
        }
        .form-control {
            padding: 0.45rem 0.45rem !important;
        }
        .table td {
            padding: 10px 4px !important;
        }
        .dropify-message .file-icon p{
            line-height: 40px !important;
            font-size: 37px !important;
        }
        .dropify-message .file-icon::before{
            display: none !important;
        }
        input.form-control, input.form-select {
            border-color: #E6EAEd;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid #E6EAED !important;
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: inherit;
                overflow-y: auto;
                height: 220px;
            }
        }
        .add_more_btn{
            width: 170px;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #e9e9ef;
            opacity: 1;
        }
        .table thead tr th {
            font-size: 12px; !important
        }
        .select2-invalid .select2-selection--single {
            border: 1px solid #dc3545 !important;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('product', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Product</h4>
                <h6>Update your Products</h6>
            </div>
        </div>
        
        <ul class="table-top-head">
            <li>
                <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
            </li>
        </ul>

        <div class="page-btn">
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Back to Product</a>
        </div>
    </div>
    

    <form id="updateForm" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" id="prdt_id" value="{{ $product->id }}">

        <div class="row">
            <div class="col-lg-8">
                <!-- 1st Row Content part Start -->
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="name"><b>Product Name</b> <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input type="text" name="name" class="form-control name_validate" id="name"  placeholder="Product Name" value="{{ old('name', $product->name) }}">

                                        <span id="name_validate" class="invalid-feedback mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="code">
                                        <b>Product Code
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="" class="fas fa-info-circle tp text-info" data-bs-original-title="Also known as SKU. If you leave this field empty, it will be generated automatically." aria-label="Also known as SKU. If you leave this field empty, it will be generated automatically."></i></b>
                                    </label>
                                    <div class="col-8">
                                        <input type="text" name="sku" class="form-control sku_validate" autocomplete="off" id="code" placeholder="Product Code" value="{{ old('sku', $product->sku) }}">

                                        <span id="sku_validate" class="invalid-feedback mt-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="unit_id"><b>Unit</b> <span class="text-danger">*</span></label>

                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select unit_id_validate" id="unit_id" name="unit_id">
                                                    <option value="" disabled selected>Select</option>
                                                    @foreach ($units as $row)
                                                        <option value="{{ $row->id }}" {{ $product->unit_id == $row->id ? 'selected' : '' }}>{{ $row->unit }} ( {{ $row->short_name }} )</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="add_input" data-bs-toggle="modal" data-bs-target="#unitModal">
                                                <i class="fas fa-plus input_i"></i>
                                            </button>
                                        </div>

                                        <span id="unit_id_validate" class="invalid-feedback mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="barcode"><b>Barcode</b></label>
                                    <div class="col-8">
                                        <input type="text" name="barcode" class="form-control barcode_validate" id="barcode"  placeholder="Product Barcode Set" value="{{ old('barcode', $product->barcode) }}">

                                        <span id="barcode_validate" class="validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="category_id"><b>Category</b> <span class="text-danger">*</span></label>
                                    <div class="col-8">

                                        <div class="d-flex">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select category_id_validate" id="category_id" name="category_id">
                                                    <option value="" disabled selected>Select</option>
                                                    @foreach ($categories as $row)
                                                        <option value="{{ $row->id }}" 
                                                            data-image-url="{{ asset($row->category_img) }}"
                                                            {{ $product->category_id == $row->id ? 'selected' : '' }}
                                                            >{{ $row->category_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <button type="button" class="add_input" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                                <i class="fas fa-plus input_i"></i>
                                            </button>
                                        </div>

                                        <span id="category_id_validate" class="validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="subCategory_id"><b>SubCategory</b> <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" id="subCategory_id" name="subCategory_id">
                                                    <option value="" disabled selected>Select</option>
                                                    @foreach ($subCategories as $row)
                                                        <option value="{{ $row->id }}" 
                                                            data-image-url="{{ asset($row->subcategory_img) }}"
                                                            {{ $product->subCategory_id == $row->id ? 'selected' : '' }}
                                                            >{{ $row->subcategory_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <button type="button" class="add_input" data-bs-toggle="modal" data-bs-target="#subCategoryModal">
                                                <i class="fas fa-plus input_i"></i>
                                            </button>
                                        </div>

                                        <span id="subCategory_id_validate" class="validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="childCategory_id"><b>ChildCategory</b></label>
                                    <div class="col-8">

                                        <div class="d-flex">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" id="childCategory_id" name="childCategory_id">
                                                    <option value="" disabled selected>Select</option>
                                                    @foreach ($childCategories as $row)
                                                        <option value="{{ $row->id }}" 
                                                            data-image-url="{{ asset($row->img) }}" {{ $product->childCategory_id == $row->id ? 'selected' : '' }}
                                                            >{{ $row->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <button type="button" class="add_input" data-bs-toggle="modal" data-bs-target="#childCategoryModal">
                                                <i class="fas fa-plus input_i"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <span id="childCategory_id_validate" class="validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="brand_id"><b>Brand</b> <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" id="brand_id" name="brand_id">
                                                    <option value="" disabled selected>Select</option>
                                                    @foreach ($brands as $row)
                                                        <option value="{{ $row->id }}" 
                                                            data-image-url="{{ asset($row->image) }}"
                                                            {{ $product->brand_id == $row->id ? 'selected' : '' }}
                                                            >{{ $row->brand_name  }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <button type="button" class="add_input" data-bs-toggle="modal" data-bs-target="#brandModal">
                                                <i class="fas fa-plus input_i"></i>
                                            </button>
                                        </div>

                                        <span id="brand_id_validate" class="validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="is_sale"><b>Is For Sale</b></label>
                                    <div class="col-8">
                                        <select class="form-select" id="is_sale" name="is_sale">
                                            <option value="1" @if( $product->is_sale == 1 ) selected @endif>Yes</option>
                                            <option value="0" @if( $product->is_sale == 0 ) selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6th Row Content part Start -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="input-group mb-1">
                                    <label class="form-label col-3" for="product_size"><strong>Multiple Products Tag</strong></label>
                                    <div class="col-9">
                                        <input type="text" class="product-tags" value="{{ old('tags', $product->tags) }}" name="tags" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- 5th Row Content part Start -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label class="form-label" for="thumb_image"><b>Thumbnail Photo</b> <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="thumb_image" id="thumb_image" 
                                    data-allowed-file-extensions="png jpeg jpg gif webp"
                                    @if(isset($product) && $product->thumb_image)
                                        data-default-file="{{ asset($product->thumb_image) }}"
                                    @endif
                                    >
                                </div>
                
                                <span id="thumb_image_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2nd Row Content part Start -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="name"><b>Applicable Tax</b></label>
                                    <div class="col-8">
                                        <div class="d-flex gap-2">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" id="" name="apply_tax_percentage">
                                                    <option value="0" {{ ($product->apply_tax_percentage ?? 0) == 0 ? 'selected' : '' }}>None</option>

                                                    @foreach ($tax_rates as $row)
                                                        <option value="{{ $row->id }}" {{ ($product->apply_tax_percentage ?? '') == $row->id ? 'selected' : '' }}>{{ $row->tax_name }} ({{ $row->percentage }}%)</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="" style="width: 100%;">
                                                <select class="form-select" id="" name="apply_tax_type">
                                                    <option value="exclusive" @if( $product->apply_tax_type === 'exclusive' ) selected @endif>Exclusive</option>
                                                    <option value="inclusive" @if( $product->apply_tax_type === 'inclusive' ) selected @endif>Inclusive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <div class="input-group mb-1">
                                    <label class="col-4" for="apply_tax_for"><b>Tax Applicable For</b></label>
                                    <div class="col-8">
                                        <select class="form-select" id="apply_tax_for" name="apply_tax_for">
                                            <option value="selling_price" @if( $product->apply_tax_for === 'selling_price' ) selected @endif>For Selling Price</option>
                                            <option value="cost_price" @if( $product->apply_tax_for === 'cost_price' ) selected @endif>For Cost Price</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mb-5">
                <button type="submit" id="submitBtn" class="btn btn-secondary waves-effect me-3">Update Changes </button>
            </div>
        </div>
    </form>



    <!-- Category Create Modal -->
    <div id="categoryModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Category</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="categoryForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="category_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="category_name" type="text" name="category_name" placeholder="Category Name">

                            <span id="cat_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="category_img" class="form-label">Image <sup class="text-danger" style="font-size: 12px;">* resolution(160px x 160px)</sup></label>
                            <input type="file" class="form-control" name="category_img" id="category_img" accept=".png, .jpeg, .jpg, .webp" onchange="showImagePreview(event, 'cat_image_preview')">

                            <span id="cat_image_validate" class="text-danger validation-error mt-1"></span>

                            <div id="cat_image_preview" class="mt-3">
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <span id="status_validate" class="text-danger mt-1"></span>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                    data-bs-dismiss="modal">Close
                            </button>

                            <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /End Category Create Modal  -->
   
   
    <!-- SubCategory Create Modal -->
    <div id="subCategoryModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create SubCategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    {{-- method="POST" action="{{ route('admin.category.store') }}" --}}
                    <form id="subcategoryForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="category_id" id="second_category_id">
                                <option value="" disabled selected>Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-image-url="{{ asset($category->category_img) }}">{{ $category->category_name }}</option>
                                    @endforeach
                            </select>

                            <span id="cats_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="subcategory_name" class="form-label">SubCategory Name <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" id="subcategory_name" type="text" name="subcategory_name" placeholder="SubCategory Name">

                            <span id="subCats_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="subcategory_img" class="form-label">Image <sup class="text-danger" style="font-size: 12px;">* resolution(160px x 160px)</sup></label>
                            <input type="file" class="form-control" name="subcategory_img" id="subcategory_img" accept=".png, .jpeg, .jpg, .webp" onchange="showImagePreview(event, 'sub_image_preview')">

                            <span id="subCats_image_validate" class="text-danger validation-error mt-1"></span>

                                <div id="sub_image_preview" class="mt-3">
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <span id="status_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                data-bs-dismiss="modal">Close </button>

                            <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light"> Save Changes </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /End SubCategory Create Modal  -->
   
   
    <!-- ChildCategory Create Modal -->
    <div id="childCategoryModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Child-Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="childCategoryForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <select class="form-select category_id" name="category_id" id="third_category_id">
                                <option value="" disabled selected>Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-image-url="{{ asset($category->category_img) }}">{{ $category->category_name }}</option>
                                    @endforeach
                            </select>

                            <span id="catName3_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SubCategory Name <span class="text-danger">*</span></label>
                            <select class="form-select subCategory_id" name="subCategory_id" id="second_subCategory_id">
                                <option value="" disabled selected>Select </option>
                                    @foreach ($subCategories as $subCat)
                                        <option value="{{ $subCat->id }}" data-image-url="{{ asset($subCat->subcategory_img) }}">{{ $subCat->subcategory_name }}</option>
                                    @endforeach
                            </select>

                            <span id="subCatName3_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="childCategory_name" class="form-label">ChildCategory Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="childCategory_name" type="text" name="name" placeholder="ChildCategory Name">

                            <span id="childCat_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="childCategory_img" class="form-label">Image <sup class="text-danger" style="font-size: 12px;">* resolution(100 x 100)</sup></label>
                            <input type="file" class="form-control" name="img" id="childCategory_img" accept=".png, .jpeg, .jpg, .webp" onchange="showImagePreview(event, 'child_image_preview')">

                            <span id="child_image_validate" class="text-danger validation-error mt-1"></span>

                            <div id="child_image_preview" class="mt-3">
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="modal">Close
                            </button>

                            <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /End ChildCategory Create Modal  -->
   
   
    <!-- Brand Create Modal  -->
    <div id="brandModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="brandForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Brand name">

                            <span id="brand_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Brand Image <sup class="text-danger" style="font-size: 12px;">* resolution(100 x 100)</sup></label>
                            <input type="file" class="form-control" name="image" id="image"  accept=".png, .jpeg, .jpg, .webp" onchange="showImagePreview(event, 'brand_image_preview')">

                            <span id="brand_image_validate" class="text-danger validation-error mt-1"></span>

                            <div id="brand_image_preview" class="mt-3">
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Deactive</option>
                            </select>

                            <span id="featured_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                data-bs-dismiss="modal">Close </button>

                            <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light"> Save changes</button>
                        </div>
                    </form>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /End Brand Create Modal  -->
   
   
    <!-- Unit Create Modal  -->
    <div id="unitModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="unitForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit">

                            <span id="units_validate" class="text-danger validation-error mt-1"></span>
                        </div>


                        <div class="mb-3">
                            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Short Name">

                            <span id="short_name_validate" class="text-danger validation-error mt-1"></span>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Deactive</option>
                            </select>

                            <span id="featured_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                data-bs-dismiss="modal">Close </button>

                            <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light"> Save changes</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /End Unit Create Modal  -->
   

@endsection

@push('add-js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function () {
            // Create Category Data
            $('#categoryForm').submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.category.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            // Add new category to dropdown
                            $('#category_id').append(
                                `<option value="${res.category.id}" data-image-url="${res.category.image}">
                                    ${res.category.name}
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#category_id').val(res.category.id).trigger('change');

                            $('#cat_image_preview').html(`
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            `);

                            $('#categoryModal').modal('hide');
                            $('#categoryForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        let error = err.responseJSON.errors;

                        $('#cat_name_validate').empty().html(error.category_name);
                        $('#cat_image_validate').empty().html(error.category_img);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Create SubCategory Data
            $('#subcategoryForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.subcategory.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            // Add new subCategory to dropdown
                            $('#subCategory_id').append(
                                `<option value="${res.subCategory.id}" data-image-url="${res.subCategory.image}">
                                    ${res.subCategory.name}
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#subCategory_id').val(res.subCategory.id).trigger('change');
                            $('#second_category_id').val('').trigger('change');

                            $('#sub_image_preview').html(`
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            `);

                            $('#subCategoryModal').modal('hide');
                            $('#subcategoryForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#cats_name_validate').empty().html(error.category_id);
                        $('#subCats_name_validate').empty().html(error.subcategory_name);
                        $('#subCats_image_validate').empty().html(error.subcategory_img);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Create Data
            $('#childCategoryForm').submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.childCategory.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            // Add new subCategory to dropdown
                            $('#childCategory_id').append(
                                `<option value="${res.childCategory.id}" data-image-url="${res.childCategory.image}">
                                    ${res.childCategory.name}
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#third_category_id').val('').trigger('change');
                            $('#second_subCategory_id ').val('').trigger('change');
                            $('#childCategory_id').val(res.childCategory.id).trigger('change');

                            $('#child_image_preview').html(`
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            `);

                            $('#childCategoryModal').modal('hide');
                            $('#childCategoryForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#catName3_validate').empty().html(error.category_id);
                        $('#subCatName3_validate').empty().html(error.subCategory_id);
                        $('#childCat_name_validate').empty().html(error.name);
                        $('#child_image_validate').empty().html(error.img);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Create Brand Data
            $('#brandForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.brand.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                             // Add new subCategory to dropdown
                             $('#brand_id').append(
                                `<option value="${res.brand.id}" data-image-url="${res.brand.image}">
                                    ${res.brand.name}
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#brand_id').val(res.brand.id).trigger('change');

                            $('#brand_image_preview').html(`
                                <img src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            `);

                            $('#brandModal').modal('hide');
                            $('#brandForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#brand_name_validate').empty().html(error.brand_name);
                        $('#brand_image_validate').empty().html(error.image);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Create Unit Data
            $('#unitForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.unit.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            // Add new brand to dropdown
                            $('#unit_id').append(
                                `<option value="${res.units.id}">
                                    ${res.units.unit} (${res.units.short_name})
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#unit_id').val(res.units.id).trigger('change');

                            $('#unitModal').modal('hide');
                            $('#unitForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;
                        console.log(error);

                        $('#units_validate').empty().html(error.unit);
                        $('#short_name_validate').empty().html(error.short_name);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Create Warrenty Data
            $('#warrantyForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.warranties.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        // console.log(res);
                        if (res.status === true) {
                            // Add new brand to dropdown
                            $('#warranties_id ').append(
                                `<option value="${res.warranties.id}">
                                    ${res.warranties.duration} ${res.warranties.period}
                                </option>`
                            );

                            // Optional: auto-select the newly added option
                            $('#warranties_id').val(res.warranties.id).trigger('change');

                            $('#warrantyModal').modal('hide');
                            $('#warrantyForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#warranty_validate').empty().html(error.warranty);
                        $('#duration_validate').empty().html(error.duration);
                        $('#period_validate').empty().html(error.period);
                        $('#description_validate').empty().html(error.description);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#thumb_image').dropify({
                messages: {
                    'default': "Drag and drop a file here or click",
                    'replace': "Drag and drop or click to replace",
                    'remove': "Remove",
                    'error': "Oops, something wrong happened."
                }
            });

            // Choice.js plugin
            const product_tags = new Choices('.product-tags',{
                removeItems: true,
                duplicateItemsAllowed: false,
                removeItemButton: true,
                delimiter: ',',
            });

            //____ category_id Select2 ____//
            $('#units').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ category_id Select2 ____//
            $('#category_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ second_category_id Select2 ____//
            $('#second_category_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ third_category_id Select2 ____//
            $('#third_category_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ subCategory_id Select2 ____//
            $('#subCategory_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ second_subCategory_id Select2 ____//
            $('#second_subCategory_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ childCategory_id Select2 ____//
            $('#childCategory_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ brand_id Select2 ____//
            $('#brand_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            function formatState (state) {
                if (!state.id) {
                    return state.text; // Return text for disabled option
                }

                var imageUrl = $(state.element).data('image-url'); // Access image URL from data attribute

                if (!imageUrl) {
                    return state.text; // Return text if no image URL is available
                }

                var $state = $(
                    '<span><img src="' + imageUrl + '" style="width: 35px; height: 30px; margin-right: 8px;" /> ' + state.text + '</span>'
                );
                return $state;
            };
        });
    </script>

    <script>
        $(document).ready(function(){
            // Create
            $('#updateForm').submit(function (e) {
                e.preventDefault();

                let id = $('#prdt_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT'); // 🔥 important

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/product') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    beforeSend: function () {
                        $('#submitBtn').prop('disabled', true);
                        $('#submitBtn').html(`
                            <i class="fas fa-spinner fa-spin me-2"></i> Loading...
                        `);
                    },
                    success: function (res) {
                        // console.log(res);
                        if (res.status === true) {
                            $('#updateForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the current page
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (err) {
                        let errors = err.responseJSON?.errors || {};

                        // clear all previous validation messages
                        $('[id$="_validate"]').html('');
                        $('[id$="_error"]').html('');
                        $('input, select, textarea').removeClass('is-invalid');

                        // show validation errors dynamically
                        $.each(errors, function (key, value) {
                            let $field = $('.' + key + '_validate');
                            $('#' + key + '_validate').html(value[0]);
                            $field.addClass('is-invalid');

                            // 🔥 handle array errors (variant_codes.0 etc)
                            if (key.includes('.')) {
                                let parts = key.split('.');
                                let fields = parts[0]; // variant_codes
                                let index = parts[1]; // 0

                                let row = $('.variant_row').eq(index);
                                row.find(`.${fields}_error`).html(value[0]);
                                row.find(`[name="${fields}[]"]`).addClass('is-invalid');
                            } else {
                                $(`[name="${key}"]`).addClass('is-invalid');
                                $(`#${key}_validate`).text(value[0]);
                            }
                        });

                        $('#submitBtn').prop('disabled', false);
                        $('#submitBtn').html(`Save Changes`);

                        swal.fire({
                            title: "Validation Error",
                            text: "Please correct the highlighted fields and try again.",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    },
                    // 🔹 Always runs (success or error)
                    complete: function () {
                        $('#submitBtn').prop('disabled', false);
                        $('#submitBtn').html(`Update Changes`);
                    }
                });
            })
        })
    </script>

@endpush

