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


    <!-- Content part Start -->
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
                        <label class="col-4" for="units"><b>Unit</b> <span class="text-danger">*</span></label>

                        <div class="col-8">
                            <div class="d-flex">
                                <div class="" style="width: 100%;">
                                    <select class="form-select" id="units" name="unit">
                                        <option value="" disabled selected>Select</option>
                                        {{-- @foreach ($subCategories as $row)
                                            <option value="{{ $row->id }}" 
                                                data-image-url="{{ asset($row->subcategory_img) }}"
                                                {{ old('subCategory_id', $product->subCategory_id ?? '') == $row->id ? 'selected' : '' }}
                                                >{{ $row->subcategory_name }}</option>
                                        @endforeach --}}
                                        <option value="pcs">Pcs</option>
                                        <option value="box">Box</option>
                                    </select>

                                </div>
                                <div class="add_input">
                                    <i class="fas fa-plus input_i"></i>
                                </div>
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
                                <div class="add_input">
                                    <i class="fas fa-plus input_i"></i>
                                </div>
                            </div>

                        </div>

                        <span id="brand_id_validate" class="text-danger validation-error mt-1"></span>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group mb-1">
                        <label class="col-4" for="alert_qty"><b>Alert Quantity</b> <span class="text-danger">*</span></label>
                        <div class="col-8">
                            <input type="number" name="alert_qty" class="form-control" id="alert_qty" required="" value="{{ old('alert_qty', 0) }}">
                        </div>

                        <span id="alert_qty_validate" class="text-danger validation-error mt-1"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
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

                <div class="col-md-6 mb-3">
                    <div class="input-group mb-1">
                         <label class="col-4" for="stocks"><b>Stock</b> <span class="text-danger">*</span></label>
                        <div class="col-8">
                            <input type="number" name="stock" class="form-control" id="stocks" required="" value="{{ old('stock', 0) }}">
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

        </div>
    </div>

    <div class="card">
        <div class="card-body">

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
                            // Add new category to dropdown
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

            //____ subCategory_id Select2 ____//
            $('#subCategory_id').select2({
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

@endpush

