@extends('admin.layout.master')

@push('title')
    Create Product
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
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
                height: 250px;
            }
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('Product', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Product</h4>
                <h6>Manage your Products</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.faq.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel"><img src="{{ asset('public/admin/assets/img/icons/excel.svg') }}" alt="img"></a>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
        <div class="page-btn">
            @if(auth("admin")->user()->can("create.brand"))
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add FAQ</button>
             @endif
        </div>
    </div>

<form action="" method="POST" enctype="multipart/form-data">
    @csrf

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
                                    <input type="text" name="name" class="form-control" id="name" required=""  placeholder="Product Name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <span id="name_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="code">
                                    <b>Product Code
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="" class="fas fa-info-circle tp text-info" data-bs-original-title="Also known as SKU. If you leave this field empty, it will be generated automatically." aria-label="Also known as SKU. If you leave this field empty, it will be generated automatically."></i></b>
                                </label>
                                <div class="col-8">
                                    <input type="text" name="code" class="form-control" autocomplete="off" id="code" placeholder="Product Code" value="{{ old('code') }}">
                                </div>
                            </div>

                            <span id="code_validate" class="text-danger validation-error mt-1"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="unit_id"><b>Unit</b> <span class="text-danger">*</span></label>

                                <div class="col-8">
                                    <div class="d-flex">
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" id="unit_id" name="unit_id">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($units as $row)
                                                    <option value="{{ $row->id }}">{{ $row->unit }} ( {{ $row->short_name }} )</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#unitModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <span id="unit_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="barcode_type"><b>Barcode Type</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="barcode_type" name="barcode_type">
                                        <option value="" disabled selected>Select</option>
                                        <option value="c128">Code 128 (C128)</option>
                                    </select>
                                </div>
                            </div>

                            <span id="barcode_type_validate" class="text-danger validation-error mt-1"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="category_id"><b>Category</b> <span class="text-danger">*</span></label>
                                <div class="col-8">

                                    <div class="d-flex">
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" id="category_id" name="category_id">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($categories as $row)
                                                    <option value="{{ $row->id }}" 
                                                        data-image-url="{{ asset($row->category_img) }}"
                                                        {{ old('category_id') }}
                                                        >{{ $row->category_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>

                                </div>

                                <span id="category_id_validate" class="text-danger validation-error mt-1"></span>
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
                                                        {{ old('subCategory_id') }}
                                                        >{{ $row->subcategory_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#subCategoryModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>

                                </div>

                                <span id="subCategory_id_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="warranties_id"><b>Warranties</b></label>
                                <div class="col-8">

                                    <div class="d-flex">
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" id="warranties_id" name="warranties_id">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($warranties as $row)
                                                    <option value="{{ $row->id }}" 
                                                        >{{ $row->duration }}  {{ Str::ucfirst($row->period) }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#warrantyModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>

                                </div>

                                <span id="warranties_id_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>

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
                                                        data-image-url="{{ asset($row->img) }}"
                                                        >{{ $row->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#childCategoryModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>

                                </div>

                                <span id="childCategory_id_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                                                        {{ old('brand_id') }}
                                                        >{{ $row->brand_name  }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <button class="add_input" data-bs-toggle="modal" data-bs-target="#brandModal">
                                            <i class="fas fa-plus input_i"></i>
                                        </button>
                                    </div>

                                </div>

                                <span id="brand_id_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-1">
                                <label class="col-4" for="alert_qty"><b>Alert Quantity</b> <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="number" name="alert_qty" class="form-control" id="alert_qty" min="1" required="" value="{{ old('alert_qty') }}">
                                </div>

                                <span id="alert_qty_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-1">
                                <label class="col-4" for="condition"><b>Condition</b> <span class="text-danger">*</span></label>

                                <div class="col-8">
                                    <select class="form-select" id="condition" name="condition">
                                        <option value="new" selected>New</option>
                                        <option value="used">Used</option>
                                    </select>
                                </div>
                            </div>

                            <span id="condition_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-1">
                                <label class="col-4" for="stocks"><b>Stock</b> <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="number" name="stock" class="form-control" id="stocks" required="" min="1" value="{{ old('stock') }}">
                                </div>
                            </div>

                            <span id="stock_validate" class="text-danger validation-error mt-1"></span>
                        </div>
                    </div>


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


                    <!-- Create Warrenty Modal -->
                    <div id="warrantyModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
                    style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Create Warranty</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                                </div>

                                <div class="modal-body">
                                    <form id="warrantyForm" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="warranty" class="form-label">Warranty <span class="text-danger">*</span></label>
                                                    <input class="form-control" id="warranty" type="text" name="warranty">
                    
                                                    <span id="warranty_validate" class="text-danger validation-error mt-1"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="duration">Duration<span class="text-danger ms-1">*</span></label>
                                                    <input class="form-control" id="duration" type="number" name="duration">

                                                    <span id="duration_validate" class="text-danger validation-error mt-1"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" >
                                                <div class="mb-3">
                                                    <label class="form-label" for="period">Period<span class="text-danger ms-1">*</span></label>
                                                    <select class="select form-control" id="period" name="period">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="day">Day</option>
                                                        <option value="month">Month</option>
                                                        <option value="year">Year</option>
                                                    </select>

                                                    <span id="period_validate" class="text-danger validation-error mt-1"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="description">Description<span class="text-danger ms-1">*</span></label>
                                                    <textarea class="form-control" id="description" name="description"></textarea>

                                                    <span id="description_validate" class="text-danger validation-error mt-1"></span>
                                                </div>
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
                    <!-- /End Create Warrenty Modal  -->

                </div>
            </div>

            <!-- 3rd Row Content part Start -->
            <div class="card variants_body">
                <div class="card-body">
                    <div class="row">
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <p class="fw-bold" style="background: #7dd9f8; display: inline; padding: 2px 7px;">Create Variant</p>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="add_more_btn">
                                    <button id="add_more_variant_btn" class="btn btn-sm btn-dark float-end">Add More</button>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="table-responsive mt-1">
                                    <div class="data-table-wrapper">
                                        <table class="table modal-table table-sm">
                                            <thead>
                                                <tr class="text-center bg-primary variant_header">
                                                    <th class="text-white text-start">Select Variant</th>
                                                    <th class="text-white text-start">Variant Code <i data-bs-toggle="tooltip" data-bs-placement="top" title="" class="fas fa-info-circle tp" data-bs-original-title="Also known as SKU. Variant code(SKU) must be unique." aria-label="Also known as SKU. Variant code(SKU) must be unique."></i></th>
                                                    <th class="text-white text-start" id="variant_cost_label">Unit Cost (Exc. Tax)</th>
                                                    <th class="text-white text-start">Profit(%)</th>
                                                    <th class="text-white text-start" id="variant_price_label">Unit Price (Exc. Tax)</th>
                                                    <th class="text-white text-start">Variant Photo</th>
                                                    <th><i class="fas fa-trash-alt text-white"></i></th>
                                                </tr>
                                            </thead>
                            
                                            <tbody class="dynamic_variant_body">
                                                <tr id="variant_row" class="variant_row">
                                                    <td class="text-start">
                                                        <select class="form-control" name="" id="variants">
                                                            <option value="" disabled selected>Select</option>
                                                            <option value="1">Db</option>
                                                            <option value="2">size</option>
                                                            <option value="3">Pant Size</option>
                                                        </select>
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <input type="text" name="variant_codes[]" id="variant_code" class="form-control reqireable fw-bold" placeholder="Variant Code">
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <input type="number" name="variant_costs[]" step="any" class="form-control variant_cost requireable fw-bold" placeholder="0.00" id="variant_cost" required="">
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <input type="number" step="any" name="variant_profits[]" class="form-control requireable variant_profit fw-bold" placeholder="0.00" id="variant_profit">
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <input type="number" step="any" name="variant_prices[]" class="form-control requireable variant_price  fw-bold" placeholder="0.00" id="variant_price" required="">
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <input type="file" name="variant_image[]" class="form-control" id="variant_image">
                                                    </td>
                        
                                                    <td class="text-start">
                                                        <button class="btn btn-xs btn-sm btn-danger variant_remove_btn">X</button>
                                                    </td>
                                                </tr>
                        
                                                <tr id="set_variant_multiple_units" class="set_variant_multiple_units"></tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="long_description"><b>Long Description</b> <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="long_description" name="long_description" rows="8" placeholder="Long Description....">{{ old('long_description') }}</textarea>
                            </div>
            
                            <span id="long_validate" class="text-danger mt-1">
                                @error('long_description'){{ $message }}@enderror
                            </span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="video_link"><b>Video Link</b></label>
                            <textarea class="form-control" id="video_link" name="video_link"  rows="7" placeholder="Link Paste Here....">{{ old('video_link') }}</textarea>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="short"><b>Short Description</b> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="short" class="" name="short_description" rows="7" placeholder="Short Description....">{{ old('short_description') }}</textarea>
            
                            <span id="short_validate" class="text-danger mt-2">
                                @error('short_description'){{ $message }}@enderror
                            </span>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="form-label col-3" for="product_size"><strong>Multiple Products Tag</strong></label>
                                <div class="col-9">
                                    <input type="text" class="product-tags" value="{{ old('tags') }}" name="tags" />
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
                            <div class="mb-3">
                                <label class="form-label" for="thumb_image"><b>Thumbnail Photo</b> <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="thumb_image" id="thumb_image" data-allowed-file-extensions="png jpeg jpg gif webp" >
                            </div>
            
                            <span id="image_validate" class="text-danger mt-2">
                                @error('thumb_image'){{ $message }}@enderror
                            </span>
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
                                            <select class="form-select" id="" name="">
                                                <option value="none" selected>None</option>
                                                @foreach ($tax_rates as $row)
                                                    <option value="{{ $row->id }}" selected>{{ $row->tax_name }} ({{ $row->percentage }}%)</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="" style="width: 100%;">
                                            <select class="form-select" id="" name="">
                                                <option value="exclusive" selected>Exclusive</option>
                                                <option value="inclusive">Inclusive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="name"><b>Tax Applicable For</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="" name="">
                                        <option value="exclusive" selected>For Selling Price</option>
                                        <option value="inclusive">For Cost & Selling Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="variant"><b>Has Variant?</b></label>
                                <div class="col-8">
                                    <select class="form-select has_variant" id="variant" name="variant">
                                        <option value="no" selected>No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="unit_cost"><b>Unit Cost (Exc. Tax)</b> <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="number" name="unit_cost" class="form-control" id="unit_cost" required="" placeholder="0.00" min="1" value="{{ old('unit_cost') }}">
                                </div>
                            </div>

                            <span id="unit_cost_validate" class="text-danger validation-error mt-1"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="profit_margin"><b>Profit Margin(%)</b> <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="number" name="profit_margin" class="form-control" id="profit_margin" required="" placeholder="0.00" min="1" value="{{ old('profit_margin') }}">
                                </div>
                            </div>

                            <span id="profit_margin_validate" class="text-danger validation-error mt-1"></span>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="unit_price"><b>Unit Price (Exc. Tax)</b> <span class="text-danger">*</span></label>
                                <div class="col-8">
                                    <input type="number" name="unit_price" class="form-control" id="unit_price" required="" placeholder="0.00" min="1" value="{{ old('unit_price') }}">
                                </div>
                            </div>

                            <span id="unit_price_validate" class="text-danger validation-error mt-1"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4th Row Content part Start -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="discount_type"><b>Discount Type</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="discount_type" name="discount_type">
                                        <option value="none">Select Discount Type</option>
                                        <option value="amount">Amount ( TK )</option>
                                        <option value="percent">Percent ( % )</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="display_ecom"><b>Displayed In E-com</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="display_ecom" name="display_ecom">
                                        <option value="no" selected>No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2 discount_value d-none">
                            <div class="input-group mb-1">
                                <label class="col-4" for="discount_value"><b>Discount Value</b></label>
                                <div class="col-8">
                                    <input class="form-control" type="number" id="discount_value" name="discount_value" value="{{ old('discount_value') }}"  placeholder="Discount Value....">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2 offer_start_value d-none">
                            <div class="input-group mb-1">
                                <label class="col-4" for="offer_start_date"><b>Offer Start Date</b></label>
                                <div class="col-8">
                                    <input class="form-control offer_start_date" type="date" id="offer_start_date" name="offer_start_date" placeholder="Select a date...." value="{{ old('offer_start_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2 offer_end_value d-none">
                            <div class="input-group mb-1">
                                <label class="col-4" for="offer_end_date"><b>Offer End Date</b></label>
                                <div class="col-8">
                                    <input class="form-control offer_end_date" type="date" id="offer_end_date" name="offer_end_date" value="{{ old('offer_end_date') }}" placeholder="Select a date....">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="display_ecom"><b>Is Featured</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="is_featured" name="is_featured">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="input-group mb-1">
                                <label class="col-4" for="for_sale"><b>Is For Sale</b></label>
                                <div class="col-8">
                                    <select class="form-select" id="for_sale" name="for_sale">
                                        <option value="yes" selected>Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-5">
        <button type="button" class="btn btn-secondary waves-effect me-3">Save Changes </button>
    </div>

</form>

@endsection

@push('add-js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script src="{{ asset('public/admin/assets/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>    
        const body = document.querySelector(".dynamic_variant_body");
        document.getElementById("add_more_variant_btn").addEventListener("click", function (e) {
            e.preventDefault();
            let unitCost  = document.getElementById("unit_cost").value.trim();
            let unitPrice = document.getElementById("unit_price").value.trim();
            let profitMargin = document.getElementById("profit_margin").value.trim();

            // Create new row
            let newRow = document.createElement("tr");
            newRow.classList.add("variant_row");

            newRow.innerHTML = `
                <td>
                    <select class="form-control variants">
                        <option value="" disabled selected>Select</option>
                        <option value="1">Db</option>
                        <option value="2">Size</option>
                        <option value="3">Pant Size</option>
                    </select>
                </td>

                <td>
                    <input type="text" name="variant_codes[]" class="form-control variant_code fw-bold" value="" placeholder="Variant Code">
                </td>

                <td>
                    <input type="number" name="variant_costs[]" step="any" class="form-control variant_cost fw-bold" value="${unitCost}" placeholder="0.00">
                </td>

                <td>
                    <input type="number" name="variant_profits[]" step="any" class="form-control variant_profit fw-bold" value="${profitMargin}" placeholder="0.00">
                </td>

                <td>
                    <input type="number" name="variant_prices[]" step="any" class="form-control variant_price fw-bold" value="${unitPrice}" placeholder="0.00">
                </td>

                <td>
                    <input type="file" name="variant_image[]" class="form-control variant_image">
                </td>

                <td>
                    <button class="btn btn-xs btn-sm btn-danger variant_remove_btn">X</button>
                </td>
            `;

            // PREPEND new row at the top
            body.prepend(newRow);
        });

        // Remove row
        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("variant_remove_btn")) {
                e.preventDefault();
                e.target.closest(".variant_row").remove();
            }
        });


        function calculateRow(row, changed) {
            let costInput   = row.querySelector(".variant_cost");
            let profitInput = row.querySelector(".variant_profit");
            let priceInput  = row.querySelector(".variant_price");

            let cost   = parseFloat(costInput.value) || 0;
            let profit = parseFloat(profitInput.value) || 0;
            let price  = parseFloat(priceInput.value) || 0;

            if (changed === "cost" || changed === "price") {
                if (cost <= 0 || price <= 0) {
                    profitInput.value = "";
                    return;
                }
                // Profit Margin = ((Price - Cost) / Cost) * 100
                let profitMargin = ((price - cost) / cost) * 100;
                profitInput.value = profitMargin.toFixed(2);
            }

            if (changed === "profit") {
                if (cost <= 0) {
                    priceInput.value = "";
                    return;
                }
                // Price = Cost + (Cost * Profit% / 100)
                let newPrice = cost + (cost * profit / 100);
                priceInput.value = newPrice.toFixed(2);
            }
        }

        // Listen on ALL dynamic rows
        document.addEventListener("input", function(e) {
            if (
                e.target.classList.contains("variant_cost") ||
                e.target.classList.contains("variant_profit") ||
                e.target.classList.contains("variant_price")
            ) {
                let row = e.target.closest(".variant_row");

                if (e.target.classList.contains("variant_cost")) calculateRow(row, "cost");
                if (e.target.classList.contains("variant_price")) calculateRow(row, "price");
                if (e.target.classList.contains("variant_profit")) calculateRow(row, "profit");
            }
        });
    </script>

    <script>
        function showImagePreview(event, previewId) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(previewId).innerHTML = `
                <img src="${e.target.result}" width="100" height="100">`;
                reader.readAsDataURL(file);
            }
        }


        // Select Variant Options
        document.getElementById("variant").addEventListener("change", function () {
            let unitCost  = document.getElementById("unit_cost").value.trim();
            let unitPrice = document.getElementById("unit_price").value.trim();
            let profitMargin = document.getElementById("profit_margin").value.trim();
            // console.log(this.value, unitCost, unitPrice);

            if (this.value === "yes") {

                if ( unitCost === "" || unitCost === "0" || 
                    unitPrice === "" || unitPrice === "0" ){

                    alert("Before creating the variant, product cost and product price field must not be empty.");

                    // reset dropdown back to "No"
                    this.value = "no";
                }
                else {
                    let costInput   = document.querySelector(".variant_cost").value = parseFloat(unitCost);
                    let profitInput = document.querySelector(".variant_profit").value = parseFloat(profitMargin);
                    let priceInput  = document.querySelector(".variant_price").value = parseFloat(unitPrice);
                    document.querySelector(".variants_body").classList.add('actives');
                }
            }
            else{
                document.querySelector(".variants_body").classList.remove('actives');
            }
        });

        // for unit Price
        const unitPriceInput = document.getElementById("unit_price");
        const unitCostInput  = document.getElementById("unit_cost");
        const profitMarginInput = document.getElementById("profit_margin");
        const variantInput = document.getElementById("variant"); 

        // Calculate and update fields
        function updateValues(changed) {
            let price = parseFloat(unitPriceInput.value) || 0;
            let cost  = parseFloat(unitCostInput.value) || 0;
            let margin = parseFloat(profitMarginInput.value) || 0;

            // If either price or cost is empty, set variant to "no"
            if (!unitPriceInput.value || !unitCostInput.value) {
                variantInput.value = "no";
                document.querySelector(".variants_body").classList.remove('actives');
            }

            if (changed === "price" || changed === "cost") {
                if (cost <= 0 || price <= 0) {
                    profitMarginInput.value = "";
                    return;
                }
                // Profit Margin (%) = ((Price - Cost) / Cost) * 100
                profitMarginInput.value = ((price - cost) / cost * 100).toFixed(2);
            } 
            else if (changed === "margin") {
                if (cost <= 0) {
                    unitPriceInput.value = "";
                    return;
                }
                let price = ( cost * margin ) / 100;
                unitPriceInput.value = (cost + price).toFixed(2);
            }
        }

        // Event listeners
        unitPriceInput.addEventListener("input", () => updateValues("price"));
        unitCostInput.addEventListener("input", () => updateValues("cost"));
        profitMarginInput.addEventListener("input", () => updateValues("margin"));
    </script>

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

            function toggleDiscountDivs() {
                const selectedValue = $('#discount_type').val();

                if (selectedValue === 'amount' || selectedValue === 'percent') {
                    // Show all related divs
                    $('.discount_value').removeClass('d-none'); // Show discount value div (if it exists)
                    $('.offer_start_value').removeClass('d-none'); // Show offer start date div
                    $('.offer_end_value').removeClass('d-none'); // Show offer end date div
                } else {
                    // Hide all related divs
                    $('.discount_value').addClass('d-none');
                    $('.offer_start_value').addClass('d-none');
                    $('.offer_end_value').addClass('d-none');
                }
            }

            // Initial check on page load
            toggleDiscountDivs();

            // Event listener for changes to #discount_type
            $('#discount_type').on('change', function () {
                toggleDiscountDivs();
            });

            // Ckeditor 5 plugin
            let jReq;
            ClassicEditor
                .create(document.querySelector('#long_description'))
                .then(newEditor => {
                    jReq = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });

            // Choice.js plugin
            const product_tags = new Choices('.product-tags',{
                removeItems: true,
                duplicateItemsAllowed: false,
                removeItemButton: true,
                delimiter: ',',
            });

            // Flatpicker Plugin
            $(".offer_start_date").flatpickr({
                minDate: "today"
            });

            $(".offer_end_date").flatpickr({
                minDate: "today"
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

            //____ warranties_id Select2 ____//
            $('#warranties_id ').select2({
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

@endpush

