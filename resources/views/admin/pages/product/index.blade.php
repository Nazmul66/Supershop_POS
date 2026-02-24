@extends('admin.layout.master')

@push('title')
    Manage Product List
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
        }
        /* h1, h2, h3, h4, h5, h6, p, label, div, span, li {
            font-family: "Arimo", sans-serif !important;
        } */
        .page-wrapper .nav-pills .nav-link {
            background-color: transparent;
            font-size: 12px;
            font-weight: 700;
            color: #4f8290;
        }
        .nav.nav-style-1 .nav-link.active:hover {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .nav.nav-style-1 .nav-link:hover {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .page-wrapper .nav-pills .nav-link.active {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .search_box{
            position: relative;
            width: 260px;
            padding: 0;
            border-radius: 2px;
        }
        .search_box .search_filter{
            border: 1px solid #ebebeb;
            width: 100%;
            height: 40px;
            padding-left: 15px;
            color: #212B36;
            padding-right: 60px;
        }
        .search_box .search_filter::-webkit-input-placeholder,
        .search_box .search_filter::-moz-placeholder,
        .search_box .search_filter::-ms-input-placeholder{
            color: #CACACA;
        }
        .search_box #clear_search_filter{
            position: absolute;
            top: 50%;
            right: 42px;
            transform: translate(0, -50%);
            font-size: 22px;
            cursor: pointer;
        }

        .search_sub_container{
            position: relative;
        }
        .search_sub_container .cus_history_box{
            position: absolute;
            top: 40px;
            left: 0px;
            padding: 20px 12px 12px;
            border-radius: 6px;
            background: #FFF;
            z-index: 50;
            width: 100%;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        }
        .search_sub_container .cus_history_box.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .search_box .ti-search{
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background: #092C4C;
            color: #FFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
        }
        .filter_name{
            font-size: 16px;
        }
        .all_icons{
            display: flex;
            align-items: center;
            gap: 4px;
        }
         .all_icons a,
         .all_icons i{
            font-size: 20px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .ti-copy,
        .ti-eye,
        .ti-printer{
            color: #1e857a;
        }
        .ti-edit{
            color: #17a2b8;
        }
        .ti-trash{
            color: #FF0000;
        }
        .ti-plus{
            font-size: 20px;
            cursor: pointer;
        }
        .user_icon{
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            background: #e0eef9;
            margin: 0 auto 12px;
        }
        .user_icon .ti-user{
            font-size: 30px;
            color: #212B36;
        }
        th .checkboxs .checkmarks, td .checkboxs .checkmarks {
            width: 18px;
            height: 18px;
            border: 1px solid #8c8686 !important;
        }
        .form-check-input {
            border: 1px solid #000;
        }
        .form-check-input[type=checkbox] {
            border-radius: 0px;
        }
        .form-check-input:focus {
            border: 1px solid #000;
            border: 1px solid #FE9F43;
        }
        .calender_icon{
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            font-size: 24px;
            color: #9292a9;
            cursor: pointer;
            background: #F7F7F7;
        }
        .form_labels{
            color: #BEC1C4;
        }
        a:hover{
            color: #000 !important;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid transparent !important;
            background-color: transparent !important;
        }

        .table thead tr th{
            font-size: 13px !important;
        }
        .table tbody tr td{
            font-size: 12px !important;
        }
        .table thead tr th{
            font-weight: 700;
        }
        .popup_table thead tr th,
        .popup_table tbody tr td{
            font-size: 10px !important;
            font-weight: 600;
            padding: .5rem .5rem;
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
        @media (min-width: 1561px) and (max-width: 1920px) {
            .table-responsive {
                overflow-x: auto !important;
            }
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
            <button type="button" class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#filterDrawer" aria-controls="offcanvasExample"><i class="ti ti-filter me-1"></i>Filter</button>

            
           <div class="btn-group d-none" id="bulk-action-box">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Bulk Action
                </button>
                <ul class="dropdown-menu dropdown-menu-secondary" style="">
                    <li><a class="dropdown-item bulk-delete" href="#">Bulk Delete</a></li>
                    <li><a class="dropdown-item bulk-active" href="#">Mark as Active</a></li>
                    <li><a class="dropdown-item bulk-inactive" href="#">Mark as Inactive</a></li>
                </ul>
            </div> 

            @if(auth("admin")->user()->can("create.brand"))
                <a href="{{ route('admin.product.create') }}" class="btn btn-teal"><i class="ti ti-circle-plus me-1"></i>Add Product</a>
             @endif
        </div>
    </div>
    

    {{-- Table Responsive --}}
    <div class="mb-0 border-1">
        <div class="row">
            <div class="mt-0">
                <div class="table-responsive pb-3">
                    <table class="table table-hover table-nowrap mb-0 datatables">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Action</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Product Details</th>
                                <th>Quantity</th>
                                <th>Date Info</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>

                                <td>
                                    <div class="copy-row">
                                        <div class="all_icons mb-2">
                                            <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>

                                            <i data-tooltip="tip1" class="ti ti-eye cursor-pointer tooltip-trigger"
                                            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="View"></i>

                                            <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-info" data-bs-placement="top" data-bs-original-title="Edit"></i>

                                            <i class="ti ti-trash cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-danger" data-bs-placement="top" data-bs-original-title="Delete"></i>
                                        </div>

                                        <a href="#" class="mb-2 d-block">
                                            <p class="text-teal font-bold copy_element">GB-9632541</p>
                                        </a>

                                        <div class="">
                                            <span class="badge bg-success">Whatsapp</span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <img src="{{ asset('public/admin/images/employee/20250921_221542_68d024ae052c3.jpg') }}" alt="">
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                    </div>
                                </td>

                                <td>
                                    <div class="copy-row">
                                        <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <span class="badge badge-sm bg-primary">New</span>
                                            <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <strong><span class="copyNumber">+8801833220886</span></strong>
                                            <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                            <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                            </a>
                                        </div>

                                        <div style="text-wrap: auto;">
                                            <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="">
                                        <span class="badge bg-soft-secondary">Warehouse</span>
                                        <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                    </div>
                                </td>

                                <td>
                                    <div class="">
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                        <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                    </div>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-1"> 
                                        <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                        <p class="mb-0">Steadfast</p> 
                                    </div>
                                </td>

                                <td>
                                    <p>BDT 130.00</p>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="ti ti-plus"></i> 
                                    </div>
                                </td>
                            </tr> --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    {{-- Filter Drawer Option --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterDrawer" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasExampleLabel">Product Filter</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> <!-- end offcanvas-header-->

        <div class="offcanvas-body">
            <form method="GET" action="{{ route('admin.product.index') }}" id="filterForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Category</h4>

                    <div class="bg-input-field ">
                        <select name="category_id" id="category_id" class="form-select">
                            <option value=" " selected  data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">Select Category</option>
                                                        
                            @foreach ($categories as $index => $row)
                                <option value="{{ $row->id }}" data-image-url="{{ asset($row->category_img) }}" {{ request('category_id') == $row->id ? 'selected' : '' }}><strong>{{ $row->category_name }}</strong></option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">SubCategory</h4>

                    <div class="bg-input-field ">
                        <select name="subCategory_id" id="subCategory_id" class="form-select">
                            <option value=" " selected data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">Select SubCategory</option>

                            @foreach ($subCategories as $index => $row)
                                <option value="{{ $row->id }}" data-image-url="{{ asset($row->subcategory_img) }}" {{ request('subCategory_id') == $row->id ? 'selected' : '' }}>{{ $row->subcategory_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Brand</h4>

                    <div class="bg-input-field ">
                        <select name="brand_id" id="brand_id" class="form-select">
                            <option value=" " selected data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">Select Brand</option>

                            @foreach ($brands as $index => $row)
                                <option value="{{ $row->id }}" data-image-url="{{ asset($row->image) }}"  {{ request('brand_id') == $row->id ? 'selected' : '' }}>{{ $row->brand_name  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Quantity</h4>

                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-input-field ">
                            <label for="" class="form_labels">Min</label>
                            <input type="number" id="min_qty" min="1" name="min_qty" class="form-control form_inputs" value="{{ request('min_qty') }}" placeholder="" />
                        </div>

                        <div class="bg-input-field ">
                            <label for="" class="form_labels">Max</label>
                            <input type="number" id="max_qty" min="1" name="max_qty" class="form-control form_inputs" value="{{ request('max_qty') }}" placeholder="" />
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Creation Date Range</h4>

                    <div class="bg-input-field">
                        <div class="position-relative">
                            <input type="text" id="creation_date" name="creation_date" class="form-control form_inputs" value="{{ request('creation_date') }}" placeholder="Select date range" />
                            <label for="creation_date" class="calender_icon">
                                <i class="ti ti-calendar-event"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Admin User</h4>

                    <div class="bg-input-field ">
                        <select name="admin_user[]" id="admin_user" class="form-select" multiple>
                            @foreach ($admins as $index => $row)
                                <option value="{{ $row->id }}" {{ in_array($row->id, request('admin_user', [])) ? 'selected' : '' }}>{{ $row->name  }}</option>
                            @endforeach
                        </select>
                    </div>

                    @php
                        $selectedAdmins = request('admin_user', []);
                        $allAdminIds = $admins->pluck('id')->toArray();
                        $isAllSelected = count($selectedAdmins) === count($allAdminIds) && count($allAdminIds) > 0;
                    @endphp

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="admin_status" id="admin_status" {{ $isAllSelected ? 'checked' : '' }}>
                        <label class="form-check-label" for="admin_status">
                            Select All
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Product Has Variant</h4>

                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check">
                            <input class="form-check-input" name="product_variant[]" type="checkbox" value="yes" id="product_variant_yes" {{ in_array('yes', request('product_variant', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_variant_yes">
                                Yes
                            </label>
                        </div>
        
                        <div class="form-check">
                            <input class="form-check-input" name="product_variant[]" type="checkbox" value="no" id="product_variant_no" {{ in_array('no', request('product_variant', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_variant_no">
                                No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Display Ecommerce</h4>

                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="display_ecom[]" value="1" id="dcom-yes" {{ in_array('1', request('display_ecom', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dcom-yes">
                                Yes
                            </label>
                        </div>
        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="display_ecom[]" value="0" id="dcom-no" {{ in_array('0', request('display_ecom', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dcom-no">
                                No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="text-dark mb-2" style="font-weight: 700;">Product Status</h4>

                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status[]" value="1" id="status_active" {{ in_array('1', request('status', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">
                                Active
                            </label>
                        </div>
        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status[]" value="0" id="status_deactive" {{ in_array('0', request('status', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_deactive">
                                Deactive
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <button type="button" id="resetFilter" class="btn btn-danger">Reset Filter</button>
                        <button type="submit" class="btn btn-secondary">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div> <!-- end offcanvas-body-->
    </div>

    {{-- Product Variant Modal --}}
    <div id="variant_history" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal_loader">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Product Variants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive pb-3">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>#Sl No.</th>
                                    <th>Variant Name</th>
                                    <th>Variant Weight</th>
                                    <th>Variant Code</th>
                                    <th>Qty</th>
                                    <th>Alert Qty</th>
                                    <th>Cost Price</th>
                                    <th>Profit Margin</th>
                                    <th>Selling Price</th>
                                    <th>Discount Type</th>
                                    <th>Discount Value</th>
                                    <th>Discount Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
    
                            <tbody id="t_product_variants">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

    <script>
        // Multiple Date Range
        $(function() {
            function initDateRangePicker(selector, position){
                var start = moment().subtract(29, 'days');
                var end = moment();
            
                function cb(start, end) {
                    $(selector).find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            
                $(selector).daterangepicker({
                    timePicker: true,
                    drops: position,
                    autoUpdateInput: false,
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'MMMM D/YYYY hh:mm A'
                    },
                    ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                $(selector).on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MMMM D, YYYY hh:mm A') + ' - ' + picker.endDate.format('MMMM D, YYYY hh:mm A'));
                });

                $(selector).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            
                cb(start, end);
            }
            // Initialize both inputs
            initDateRangePicker('#discount_date', "down");
            initDateRangePicker('#creation_date', "auto");
            initDateRangePicker('#shipping_date', "auto");
            initDateRangePicker('#transition_date', "auto");
        });
    </script>

    <script>
        $('#product_name').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });

        $('#category_id').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });

        $('#subCategory_id').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });

        $('#brand_id').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });
        
        $('#admin_user').select2({
            placeholder: "Select users",
            closeOnSelect: false,
        });

        $('#cus_tag').select2({
            placeholder: "Select Customer Tag",
            closeOnSelect: false,
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
                '<span><img src="' + imageUrl + '" style="width: 30px; height: 30px; border-radius: 6px; margin-right: 8px;" /> ' + state.text + '</span>'
            );
            return $state;
        };


        /* -------- SELECT ALL -------- */
        $('#admin_status').on('change', function () {
            if ($(this).is(':checked')) {
                let allValues = [];

                $('#admin_user option').each(function () {
                    allValues.push($(this).val());
                });

                $('#admin_user').val(allValues).trigger('change');
            } else {
                $('#admin_user').val(null).trigger('change');
            }
        });

        /* -------- ON SELECT / UNSELECT -------- */
        $('#admin_user').on('change', function () {
            let total = $('#admin_user option').length;
            let selected = $('#admin_user option:selected').length;

            $('#admin_status').prop('checked', total === selected);
        });
    </script>

    <script>
        $(document).ready(function () {
            // If tooltip is inside DataTable
            $('.datatables').on('draw.dt', function () {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(el => {
                    new bootstrap.Tooltip(el);
                });
            });

            // Show Data through Datatable
            let datatables = $('.datatables').DataTable({
                "order": [
                    [0, 'desc']
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url" : "{{ route('admin.product-data') }}",
                    "data": function(e){
                        function getCheckedValues(name) {
                            return $(`input[name="${name}[]"]:checked`).map(function () {
                                    return this.value;
                                }).get();
                        }

                        let displayValues         = getCheckedValues('display_ecom');
                        let productVariantValues = getCheckedValues('product_variant');
                        let statusValues          = getCheckedValues('status');
            
                        e.product_name     = $('#product_name').val();
                        e.category_id      = $('#category_id').val();
                        e.subCategory_id   = $('#subCategory_id').val();
                        e.brand_id         = $('#brand_id').val();
                        e.min_qty          = $('#min_qty').val();
                        e.max_qty          = $('#max_qty').val();
                        e.creation_date    = $('#creation_date').val();
                        e.admin_user       = $('#admin_user').val(); // array (select2 multiple)
                        e.product_variant  = productVariantValues;
                        e.display_ecom     = displayValues;
                        e.status           = statusValues;
                    }
                },
                pageLength: 10,
                columns: [
                    { 
                        data: 'checkbox', 
                        name: 'checkbox', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product_img',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'product_name',
                    },
                    {
                        data: 'product_details',
                    },
                    {
                        data: 'quantity',
                    },
                    {
                        data: 'date_info',
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                    },
                ],
                layout: {
                    topStart: {
                        buttons: [
                            {
                                text: `<i class="ti ti-refresh"></i>`,
                                className: 'btn btn-outline-secondary refresh_btn',
                            },
                            {
                                text: '<i class="ti ti-adjustments"></i> Filter Column',
                                className: 'btn btn-secondary filter-column-btn',
                                action: function () {
                                    // Bootstrap dropdown will handle it
                                }
                            },
                        ],
                        pageLength: {
                            menu: [10, 25, 50, 100, 250, -1]
                        },
                    },
                    topEnd: {
                        paging: true,
                    }
                },
                language: {
                    lengthMenu: "Show _MENU_"
                },
                initComplete: function () {
                    let table = this.api(); // Safe reference to DataTable

                    // Inject dropdown HTML AFTER table initialization
                    $('.filter-column-btn').replaceWith(`
                        <div class="dropdown">
                            <button class="btn btn-secondary border dropdown-toggle filter-column-btn"
                                    data-bs-toggle="dropdown">
                                <i class="ti ti-adjustments"></i> Filter Column
                            </button>
                            <div class="dropdown-menu filter-column-menu p-2"></div>
                        </div>
                    `);

                    let columnMenu = $('.filter-column-menu');

                    // Build checkboxes for all columns
                    table.columns().every(function (index) {
                        let column = this;
                        let title = $(column.header()).text().trim();
                        if (!title) return;

                        columnMenu.append(`
                            <div class="form-check mb-1">
                                <input class="form-check-input toggle-column"
                                    type="checkbox"
                                    data-column="${index}"
                                    checked>
                                <label class="form-check-label">${title}</label>
                            </div>
                        `);
                    });

                    // Bind toggle event
                    $(document).on('change', '.toggle-column', function () {
                        let columnIndex = $(this).data('column');
                        let visible = $(this).is(':checked');
                        table.column(columnIndex).visible(visible);
                    });
                }
            });

            $('#filterForm').on('submit', function (e) {
                e.preventDefault(); // 🔥 stop page reload

                let params = new URLSearchParams();

                // Dropdowns
                if ($('#category_id').val())
                    params.append('category_id', $('#category_id').val());

                if ($('#subCategory_id').val())
                    params.append('subCategory_id', $('#subCategory_id').val());

                if ($('#brand_id').val())
                    params.append('brand_id', $('#brand_id').val());

                if ($('#min_qty').val())
                    params.append('min_qty', $('#min_qty').val());

                if ($('#max_qty').val())
                    params.append('max_qty', $('#max_qty').val());

                if ($('#creation_date').val())
                    params.append('creation_date', $('#creation_date').val());

                // Select2 multiple
                let adminUsers = $('#admin_user').val();
                if (adminUsers)
                    adminUsers.forEach(val => params.append('admin_user[]', val));

                // Checkboxes
                $('input[name="product_variant[]"]:checked').each(function () {
                    params.append('product_variant[]', $(this).val());
                });

                $('input[name="display_ecom[]"]:checked').each(function () {
                    params.append('display_ecom[]', $(this).val());
                });

                $('input[name="status[]"]:checked').each(function () {
                    params.append('status[]', $(this).val());
                });

                // Update URL
                let newUrl = window.location.pathname + '?' + params.toString();
                window.history.pushState({}, '', newUrl);

                datatables.ajax.reload();
            });

            // refresh the datatables data
            $(document).on('click', '.refresh_btn', function (e) {
                e.preventDefault();
                datatables.ajax.reload(null, false); // 🔥 correct
            });

            // Reset Filter
            $('#resetFilter').on('click', function () {
                $('.form-check-input').prop('checked', false);
                $('.form_inputs').val('');
                $('.select_form').val('');

                /* ---DATE RANGE PICKER  --- */
                if ($('.daterange').length) {
                    $('.daterange').val('');
                }

                /* -----SELECT2 RESET ---- */
                $('.select2-hidden-accessible').each(function () {
                    $(this).val(' ').trigger('change');
                });

                /* ----- MULTI SELECT / SELECT2 ----- */
                $('select[multiple]').val(null).trigger('change');

                // --- REMOVE URL PARAMETERS AND RELOAD PAGE ---
                const cleanUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);

                // Reload Datatables
                datatables.ajax.reload();
            });

            // Product Variant Show
            $(document).on("click", '.variant_icon', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                // Show the modal first
                $('#variant_history').modal('show');

                // Save original modal content to restore later
                let originalContent = $('.modal_loader').html();

                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.product-variant') }}",
                    data: { id: id }, // send product id
                    beforeSend: function() {
                        // show loader
                        $('#variant_history .modal-dialog')
                            .removeClass('modal-lg') // remove large
                            .addClass('modal-sm'); 

                        $('.modal_loader').html(`
                            <div class="loader_measurement">
                                <div class="spinning_loader"</div>    
                            </div>
                        `);
                    },
                    success: function (res) {
                        let data = res.success;
                        let product = res.product;

                        $('#variant_history .modal-dialog')
                            .removeClass('modal-sm') // remove small
                            .addClass('modal-lg'); 

                        let html = '';

                        if (data.length > 0) {
                            data.forEach((v, index) => {
                                html += `<tr>
                                    <td>${index + 1}</td>
                                    <td>${v.variant_name}</td>
                                    <td>${v.variant_value} ${product.short_name ? product.short_name.charAt(0).toUpperCase() + product.short_name.slice(1): ''}</td>
                                    <td>${v.variant_code}</td>
                                    <td>${v.qty} ${product.short_name ? product.short_name.charAt(0).toUpperCase() + product.short_name.slice(1): ''}</td>
                                    <td>${v.alert_qty} ${product.short_name ? product.short_name.charAt(0).toUpperCase() + product.short_name.slice(1): ''}</td>
                                    <td>{{ getSetting()->currency_name }} ${v.purchase_price}</td>
                                    <td>${v.profit_margin}%</td>
                                    <td>{{ getSetting()->currency_name }} ${v.selling_price}</td>
                                    <td>${v.variant_dis_type}</td>
                                    <td>
                                        ${v.variant_dis_type === "amount" 
                                            ? `{{ getSetting()->currency_name }} ${v.variant_dis_value}` 
                                            : v.variant_dis_type === "percent" 
                                                ? `${v.variant_dis_value}%` 
                                                : 'N/A'}
                                        </td>
                                    <td>${v.variant_dis_date}</td>
                                    <td>${v.status == 1 ? '<button class="btn btn-success btn-sm">Active</button>' : '<button class="btn btn-success btn-sm">Deactive</button>'}</td>
                                </tr>`;
                            });
                        } else {
                            html = '<tr><td colspan="9" class="text-center">No variants found</td></tr>';
                        }

                        // Restore original modal content
                        $('.modal_loader').html(originalContent);

                        // Inject table rows
                        $('#t_product_variants').html(html);
                    },
                    error: function (error) {
                        console.log('error');
                    }
                    /* HTML: <div class="loader"></div> */
                });
            })

            // status updates
            $(document).on('click', '#status', function () {
                var id = $(this).data('id');
                var status = $(this).data('status');

                // console.log(id, status);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.product.status') }}",
                    data: {
                        // '_token': token,
                        id: id,
                        status: status
                    },
                    success: function (res) {
                        datatables.ajax.reload();

                        if (res.status == 1) {
                            swal.fire(
                                {
                                    title: 'Status Changed to Active',
                                    icon: 'success'
                                })
                        } else {
                            swal.fire(
                                {
                                    title: 'Status Changed to Inactive',
                                    icon: 'success'
                                })
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }

                })
            })

            // Delete
            $(document).on("click", "#deleteBtn", function () {
                let id = $(this).data('id')

                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',

                            url: "{{ url('admin/product') }}/" + id,
                            data: {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            success: function (res) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: `${res.message}`,
                                    icon: "success"
                                });

                                datatables.ajax.reload();
                            },
                            error: function (err) {
                                console.log('error')
                            }
                        })

                    } else {
                        swal.fire('Your Data is Safe');
                    }
                })
            })

            // Select All
            $('#select-all').on('change', function () {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkBox();
            });

            // Individual checkbox
            $(document).on('change', '.row-checkbox', function () {
                $('#select-all').prop(
                    'checked',
                    $('.row-checkbox').length === $('.row-checkbox:checked').length
                );
                toggleBulkBox();
            });

            // Show / Hide bulk action
            function toggleBulkBox() {
                if ($('.row-checkbox:checked').length > 0) {
                    $('#bulk-action-box').removeClass('d-none');
                } else {
                    $('#bulk-action-box').addClass('d-none');
                }
            }

            $('.bulk-delete, .bulk-active, .bulk-inactive').on('click', function (e) {
                e.preventDefault();

                let action = '';

                if ($(this).hasClass('bulk-delete')) action = 'delete';
                if ($(this).hasClass('bulk-active')) action = 'active';
                if ($(this).hasClass('bulk-inactive')) action = 'inactive';

                bulkAction(action);
            });

            function bulkAction(action) {
                let ids = [];

                $('.row-checkbox:checked').each(function () {
                    ids.push($(this).val());
                });

                if (!ids.length) return;

                Swal.fire({
                    title: "Are you sure?",
                    text: `You are about to ${action} ${ids.length} product(s).`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#218838",
                    cancelButtonColor: "#d33",
                    confirmButtonText: `Yes, ${action}`,
                    cancelButtonText: "Cancel"
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.product-bulk-action') }}",
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                ids: ids,
                                action: action
                            },
                            success: function (res) {
                                $('#select-all').prop('checked', false);
                                datatables.ajax.reload();

                                if (res.success === true) {
                                    Swal.fire({
                                        position: "center-center",
                                        icon: "success",
                                        title: `${res.message}`,
                                        timer: 4500,
                                        draggable: true
                                    });
                                } 
                            }
                        });
                    }
                });
            }
        })
    </script>

@endpush

