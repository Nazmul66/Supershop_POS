@extends('admin.layout.master')

@push('title')
    Create Product
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        label{
            font-size: 13px;
            color: #1d1c1c;
            font-weight: 600;
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
                            <input type="number" name="alert_qty" class="form-control" id="alert_qty" min="1" required="" value="{{ old('alert_qty', 1) }}">
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
                            <input type="number" name="stock" class="form-control" id="stocks" required="" min="1" value="{{ old('stock', 1) }}">
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


    <!-- 2nd Row Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
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

                <div class="col-md-6 mb-2">
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
                <div class="col-md-6 mb-2">
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
                <div class="col-md-6 mb-2">
                    <div class="input-group mb-1">
                         <label class="col-4" for="profit_margin"><b>Profit Margin(%)</b> <span class="text-danger">*</span></label>
                        <div class="col-8">
                            <input type="number" name="profit_margin" class="form-control" id="profit_margin" required="" placeholder="0.00" min="1" value="{{ old('profit_margin') }}">
                        </div>
                    </div>

                    <span id="profit_margin_validate" class="text-danger validation-error mt-1"></span>
                </div>

                <div class="col-md-6 mb-2">
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
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
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


    <!-- 3rd Row Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
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

                <div class="col-md-6 mb-2">
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

@endsection

@push('add-js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
            console.log(this.value, unitCost, unitPrice);

            if (this.value === "yes") {

                if (unitCost === "" || unitCost === "0" || 
                    unitPrice === "" || unitPrice === "0") {

                    alert("Before creating the variant, product cost and product price field must not be empty.");

                    // reset dropdown back to "No"
                    this.value = "no";
                }
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
            // Choice.js plugin
            // const product_tags = new Choices('.product-tags',{
            //     removeItems: true,
            //     duplicateItemsAllowed: false,
            //     removeItemButton: true,
            //     delimiter: ',',
            // });

            // Flatpicker Plugin
            $(".offer_start_date").flatpickr({
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

