@extends('admin.layout.master')

@push('add-title')
    Branch Wise Product Template
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
        .table tbody tr td {
            font-size: 13px !important;
        }
        .form-select {
            border-color: #aaa;
            height: 35px;
        }
        .select2-container--default .select2-results__option--disabled {
            background: #853d43 !important;
            color: #e9e8e8 !important;
            cursor: not-allowed;
        }
        .calender_icon {
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            font-size: 24px;
            color: #9292a9;
            cursor: pointer;
            background: #F7F7F7;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('product_branch', 'active')


@section('body-content')

    {{-- Breadcrumb --}}
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Product Branch</h4>
                <h6>Manage your Branch Wise Product</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.product-branch"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.product.branch.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.product-branch"))
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

            @if(auth("admin")->user()->can("create.product-branch"))
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Branch Product</button>
             @endif
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="">
                <table class="table table-bordered mb-0" id="productBranchTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#SL.</th>
                            <th>Action</th>
                            <th>Product Name</th>
                            <th>Branch Name</th>
                            <th>Product Bio</th>
                            <th>Discount Bio</th>
                            <th>Discount Date</th>
                            <th>Status</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Create Branch Wise Product</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="product_id">Product Name <span class="text-danger">*</span></label>
                                    <select class="form-select product_id" name="product_id" id="product_id">
                                        <option value=" " selected data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">-- Selected --</option>
                                        @foreach ($products as $row)
                                            @php
                                                $assigned = $assignedCounts[$row->id] ?? 0;                                 
                                                $disabled = $assigned >= $totalBranches;
                                            @endphp

                                            <option value="{{ $row->id }}" data-image-url="{{ asset($row->thumb_image) }}" {{ $disabled ? 'disabled' : '' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="product_id_validate" class="text-danger mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="branch_id">Branch Name <span class="text-danger">*</span></label>
                                    <select class="form-select branch_id" name="branch_id" id="branch_id">
                                        @foreach ($branches as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="branch_id_validate" class="text-danger mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" id="qty" type="text" name="qty" placeholder="Product Quantity">
    
                                    <span id="qty_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="alert_qty" class="form-label">Alert Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" id="alert_qty" type="text" name="alert_qty" placeholder="Alert Quantity">
    
                                    <span id="alert_qty_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="purchase_price" class="form-label">Purchase Price <span class="text-danger">*</span></label>
                                    <input class="form-control" id="purchase_price" type="number" name="purchase_price" placeholder="Purchase Price">
    
                                    <span id="purchase_price_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="profit_margin" class="form-label">Profit Margin (%) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="profit_margin" type="number" name="profit_margin" placeholder="Profit Margin" step="0.01">
    
                                    <span id="profit_margin_validate" class="text-danger validation-error mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label for="selling_price" class="form-label">Selling Price <span class="text-danger">*</span></label>
                                    <input class="form-control" id="selling_price" type="number" name="selling_price" placeholder="Purchase Price">
    
                                    <span id="selling_price_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="discount_type">Discount Type</label>
                                    <select class="form-select" name="discount_type" id="discount_type">
                                        <option value="none" selected>-- None --</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percent">Percentage (%)</option>
                                    </select>
    
                                    <span id="discount_type_validate" class="text-danger mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3 discount_area d-none">
                                    <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                                    <input class="form-control" id="discount_value" type="number" name="discount_value" placeholder="Discount Value" min="1">
    
                                    <span id="discount_value_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3 discount_area d-none">
                                    <label for="discount_date" class="form-label">Discount Date <span class="text-danger">*</span></label>
                                    <input type="text" id="discount_date" name="discount_date" class="form-control" value="" placeholder="Select date range" />
    
                                    <span id="discount_date_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
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

                                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Branch Wise Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <input type="text" name="id" id="up_id" hidden>

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="up_product_id">Product Name <span class="text-danger">*</span></label>
                                    <select class="form-select up_product_id" name="product_id" id="up_product_id">
                                        <option value=" " selected data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">-- Selected --</option>
                                        @foreach ($products as $row)
                                            @php
                                                $assigned = $assignedCounts[$row->id] ?? 0;                                 
                                                $disabled = $assigned >= $totalBranches;
                                            @endphp

                                            <option value="{{ $row->id }}" data-image-url="{{ asset($row->thumb_image) }}" {{ $disabled ? 'disabled' : '' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="up_product_id_validate" class="text-danger mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="up_branch_id">Branch Name <span class="text-danger">*</span></label>
                                    <select class="form-select" name="branch_id" id="up_branch_id">
                                        @foreach ($branches as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="up_branch_id_validate" class="text-danger mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="up_qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_qty" type="text" name="qty" placeholder="Product Quantity">
    
                                    <span id="up_qty_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="up_alert_qty" class="form-label">Alert Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_alert_qty" type="text" name="alert_qty" placeholder="Alert Quantity">
    
                                    <span id="up_alert_qty_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="up_purchase_price" class="form-label">Purchase Price <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_purchase_price" type="number" name="purchase_price" placeholder="Purchase Price">
    
                                    <span id="up_purchase_price_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label for="up_profit_margin" class="form-label">Profit Margin (%) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_profit_margin" type="number" name="profit_margin" placeholder="Profit Margin" step="0.01">
    
                                    <span id="up_profit_margin_validate" class="text-danger validation-error mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label for="up_selling_price" class="form-label">Selling Price <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_selling_price" type="number" name="selling_price" placeholder="Purchase Price">
    
                                    <span id="up_selling_price_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="up_discount_type">Discount Type</label>
                                    <select class="form-select" name="discount_type" id="up_discount_type">
                                        <option value="none" selected>-- None --</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percent">Percentage (%)</option>
                                    </select>
    
                                    <span id="up_discount_type_validate" class="text-danger mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3 up_discount_area d-none">
                                    <label for="up_discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                                    <input class="form-control" id="up_discount_value" type="number" name="discount_value" placeholder="Discount Value" min="1">
    
                                    <span id="up_discount_value_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="col-lg-6 mb-3 up_discount_area d-none">
                                    <label for="up_discount_date" class="form-label">Discount Date <span class="text-danger">*</span></label>
                                    <input type="text" id="up_discount_date" name="discount_date" class="form-control" value="" placeholder="Select date range" />
    
                                    <span id="up_discount_date_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="up_status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-secondary waves-effect me-3"
                                        data-bs-dismiss="modal">Close
                                </button>

                                <button type="submit" id="edit_btn" class="btn btn-primary waves-effect waves-light">
                                   Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        <!-- View Modal -->
        <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View Branch wise Product</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Product Name : </label>
                            <span class="text-dark" id="view_product_name"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Branch Name : </label>
                            <span class="text-dark" id="view_branch_name"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Quantity : </label>
                            <span class="text-dark" id="view_qty"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Alert Quantity : </label>
                            <span class="text-dark" id="view_alert_qty"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Discount Type: </label>
                            <span class="text-dark" id="view_discount_type"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Discount Value: </label>
                            <span class="text-dark" id="view_discount_value"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Discount Date Start : </label>
                            <div id="view_dis_date_start"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Discount Date End : </label>
                            <div id="view_dis_date_end"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Created Date : </label>
                            <div id="created_date"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Updated Date : </label>
                            <div id="updated_date"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Status : </label>
                            <div id="view_status"></div>
                        </div>
                    </div>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        {{-- Filter Drawer Option --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="filterDrawer" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasExampleLabel">Branch Product Filter</h4>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div> <!-- end offcanvas-header-->

            <div class="offcanvas-body">
                <form method="GET" action="{{ route('admin.product.branch.index') }}" id="filterForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <h4 class="text-dark mb-2" style="font-weight: 700;">Products</h4>

                        <div class="bg-input-field ">
                            <select name="product_id" id="filter_product_id" class="form-select">
                                <option value=" " selected  data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">Select Product</option>
                                                            
                                @foreach ($products as $index => $row)
                                    <option value="{{ $row->id }}" data-image-url="{{ asset($row->thumb_image) }}" {{ request('product_id') == $row->id ? 'selected' : '' }}><strong>{{ $row->name }}</strong></option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-dark mb-2" style="font-weight: 700;">Branches</h4>

                        <div class="bg-input-field ">
                            <select name="branch_id" id="filter_branch_id" class="form-select">
                                <option value=" " selected data-image-url="{{ asset('public/admin/assets/images/select_option.png') }}">Select Branch</option>

                                @foreach ($branches  as $index => $row)
                                    <option value="{{ $row->id }}" {{ request('branch_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
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

    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

    <script>
        $('.product_id').change(function () {
            let productId = $(this).val();
            // First enable all options
            $('#branch_id option').prop('disabled', false);
    
            $.ajax({
                url: "{{ route('admin.get.product.branches', ':id') }}".replace(':id', productId),
                type: 'GET',
    
                success: function (res) {
                    $('#branch_id').html(``);
                    let firstAvailable = null;

                    $.each(res.all_branches, function (index, row) {
                        let isDisabled = res.branch_ids.includes(row.id)

                        $('#branch_id').append(`
                            <option value="${row.id}" ${isDisabled ? 'disabled' : ''}>
                                ${row.name}
                            </option>
                        `);

                        // store first enabled option
                        if (!isDisabled && firstAvailable === null) {
                            firstAvailable = row.id;
                        }
                    });

                    // 👉 Select first available branch
                    if (firstAvailable !== null) {
                        $('#branch_id').val(firstAvailable).trigger('change');
                    }

                    // Disable existing branches
                    $.each(res.branch_ids, function (index, branchId) {
                        $('#branch_id option[value="' + branchId + '"]')
                            .prop('disabled', true);
                    });
                }
            });
        });

        // $('.up_product_id').change(function () {
        //     let productId = $(this).val();
        //     // First enable all options
        //     $('#up_branch_id option').prop('disabled', false);
    
        //     $.ajax({
        //         url: "{{ route('admin.get.product.branches', ':id') }}".replace(':id', productId),
        //         type: 'GET',
    
        //         success: function (res) {
        //             $('#up_branch_id').html(``);
        //             let firstAvailable = null;

        //             $.each(res.all_branches, function (index, row) {
        //                 let isDisabled = res.branch_ids.includes(row.id)

        //                 $('#up_branch_id').append(`
        //                     <option value="${row.id}" ${isDisabled ? 'disabled' : ''}>
        //                         ${row.name}
        //                     </option>
        //                 `);

        //                 // store first enabled option
        //                 if (!isDisabled && firstAvailable === null) {
        //                     firstAvailable = row.id;
        //                 }
        //             });

        //             // 👉 Select first available branch
        //             if (firstAvailable !== null) {
        //                 $('#up_branch_id').val(firstAvailable).trigger('change');
        //             }

        //             // Disable existing branches
        //             $.each(res.branch_ids, function (index, branchId) {
        //                 $('#up_branch_id option[value="' + branchId + '"]')
        //                     .prop('disabled', true);
        //             });
        //         }
        //     });
        // });
    </script>

    <script>
         $(document).ready(function () {
            $('#purchase_price, #selling_price').on('input', function () {
                let purchasePrice = parseFloat(
                    $('#purchase_price').val()
                ) || 0;

                let sellingPrice = parseFloat(
                    $('#selling_price').val()
                ) || 0;

                // Prevent divide by zero
                if (purchasePrice > 0 && sellingPrice > 0) {
                    let profitMargin =
                        ((sellingPrice - purchasePrice)
                        / purchasePrice) * 100;

                    $('#profit_margin').val(
                        profitMargin.toFixed(2)
                    );
                }
                else {
                    $('#profit_margin').val('');
                }
            });


            $('#up_purchase_price, #up_selling_price').on('input', function () {
                let purchasePrice = parseFloat(
                    $('#up_purchase_price').val()
                ) || 0;

                let sellingPrice = parseFloat(
                    $('#up_selling_price').val()
                ) || 0;

                // Prevent divide by zero
                if (purchasePrice > 0 && sellingPrice > 0) {
                    let profitMargin =
                        ((sellingPrice - purchasePrice)
                        / purchasePrice) * 100;

                    $('#up_profit_margin').val(
                        profitMargin.toFixed(2)
                    );
                }
                else {
                    $('#up_profit_margin').val('');
                }
            });
        });

    </script>

    <script>
         $(document).ready(function () {
            $('#discount_type').change(function () {
                let discountType = $(this).val();
                if (
                    discountType === 'fixed' ||
                    discountType === 'percent'
                ) {
                    $('.discount_area').removeClass('d-none');
                }
                else {
                    $('.discount_area').addClass('d-none');
                    $('#discount_value').val('');
                    $('#discount_date').val('');
                }
            });

            $('#up_discount_type').on('change', function () {
                let value = $(this).val();

                if (value === 'fixed' || value === 'percent') {
                    $('.up_discount_area').removeClass('d-none');
                    $('#up_discount_value').prop('disabled', false);
                    $('#up_discount_date').prop('disabled', false);
                } 
                else {
                    $('.up_discount_area').addClass('d-none');
                    $('#up_discount_value').prop('disabled', true).val('');
                    $('#up_discount_date').prop('disabled', true).val('');
                }
            });

            $('#filter_product_id').select2({
                dropdownParent: $('#filterDrawer'),
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#filter_branch_id').select2({
                dropdownParent: $('#filterDrawer'),
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#admin_user').select2({
                placeholder: "Select users",
                closeOnSelect: false,
            });

            $('#product_id').select2({
                dropdownParent: $('#createModal'),
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#branch_id').select2({
                dropdownParent: $('#createModal'),
                templateResult: formatState,       
                templateSelection: formatState, 
            });
            
            $('#up_product_id').select2({
                dropdownParent: $('#editModal'),
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#up_branch_id').select2({
                dropdownParent: $('#editModal'),
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
            initDateRangePicker('#discount_date', "up");
            initDateRangePicker('#up_discount_date', "up");
            initDateRangePicker('#creation_date', "auto");
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#productBranchTable').on('draw.dt', function () {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(el => {
                    new bootstrap.Tooltip(el);
                });
            });

            // Show Data through Datatable
            let datatables = $('#productBranchTable').DataTable({
                "order": [[0, 'desc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url" : "{{ route('admin.product-branch-data') }}",
                    "data": function(e){
                        function getCheckedValues(name) {
                            return $(`input[name="${name}[]"]:checked`).map(function () {
                                    return this.value;
                                }).get();
                        }

                        let statusValues    = getCheckedValues('status');
            
                        e.product_name      = $('#product_name').val();
                        e.product_id        = $('#filter_product_id').val();
                        e.branch_id         = $('#filter_branch_id').val();
                        e.creation_date     = $('#creation_date').val();
                        e.admin_user        = $('#admin_user').val(); // array (select2 multiple)
                        e.status            = statusValues;
                    }
                },
                pageLength: 10,
                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product_name',
                    },
                    {
                        data: 'branch_name',
                        orderable: false,
                    },
                    {
                        data: 'product_bio',
                        orderable: false,
                    },
                    {
                        data: 'discount_bio',
                        orderable: false,
                    },
                    {
                        data: 'discount_date',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'created_by',
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
                    // topEnd: {
                    //     paging: true,
                    // }
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

            // filter form
            $('#filterForm').on('submit', function (e) {
                e.preventDefault(); // 🔥 stop page reload

                let params = new URLSearchParams();

                // Dropdowns
                if ($('#filter_product_id').val())
                    params.append('product_id', $('#filter_product_id').val());

                if ($('#filter_branch_id').val())
                    params.append('branch_id', $('#filter_branch_id').val());

                if ($('#creation_date').val())
                    params.append('creation_date', $('#creation_date').val());

                // Select2 multiple
                let adminUsers = $('#admin_user').val();
                if (adminUsers)
                    adminUsers.forEach(val => params.append('admin_user[]', val));

                // Checkboxes
                $('input[name="status[]"]:checked').each(function () {
                    params.append('status[]', $(this).val());
                });

                // Update URL
                let newUrl = window.location.pathname + '?' + params.toString();
                window.history.pushState({}, '', newUrl);

                // console.log(params);
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

            // status updates
            $(document).on('click', '#status', function () {
                var id = $(this).data('id');
                var status = $(this).data('status');

                // console.log(id, status);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.product.branch.status') }}",
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

            // Create Data
            $('#createForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.product.branch.store') }}",
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
                            $('#createModal').modal('hide');
                            $('#createForm')[0].reset();
                            $('.validation-error').html('');

                            // 3. Reset select dropdowns (important)
                            $('#product_id').val('').trigger('change');
                            $('#branch_id option:first').prop('selected', true).trigger('change');
                            $('#discount_type').val('none').trigger('change');

                            // 4. Hide discount section again
                            $('.discount_area').addClass('d-none');

                            // 5. Clear discount fields properly
                            $('#discount_value').val('');
                            $('#discount_date').val('');

                            // 6. Enable fields (if disabled before submit)
                            $('#discount_value').prop('disabled', false);
                            $('#discount_date').prop('disabled', false);

                            // ✅ IMPORTANT
                            reloadProductOptions();
                            updateReloadProductOptions()
                            datatables.ajax.reload();

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
                    },
                    // 🔹 Always runs (success or error)
                    complete: function () {
                        $('#submitBtn').prop('disabled', false);
                        $('#submitBtn').html(`Save Changes`);
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#branch_id_validate').empty().html(error.branch_id);
                        $('#product_id_validate').empty().html(error.product_id);
                        $('#qty_validate').empty().html(error.qty);
                        $('#alert_qty_validate').empty().html(error.alert_qty);
                        $('#purchase_price_validate').empty().html(error.purchase_price);
                        $('#profit_margin_validate').empty().html(error.profit_margin);
                        $('#selling_price_validate').empty().html(error.selling_price);
                        $('#ip_address_validate').empty().html(error.ip_address);
                        $('#discount_type_validate').empty().html(error.discount_type);
                        $('#discount_date_validate').empty().html(error.discount_date);
                        $('#discount_value_validate').empty().html(error.discount_value);
                        $('#status_validate').empty().html(error.status);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Edit Data
            $(document).on("click", '#editButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/product-branch') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;
                        // console.log(data);

                        // reset branch select
                        $('#up_branch_id option').prop('disabled', false);

                        // disable used branches except current branch
                        $.each(res.usedBranchIds, function(index, branchId){
                            if(branchId != data.branch_id){
                                $('#up_branch_id option[value="' + branchId + '"]')
                                    .prop('disabled', true);
                            }
                        });

                        // Open modal
                        $('#editModal').modal('show');

                        $('#up_id').val(data.id);
                        $('#up_branch_id').val(data.branch_id).trigger('change');
                        $('#up_product_id').val(data.product_id).trigger('change');
                        $('#up_qty').val(data.qty);
                        $('#up_alert_qty').val(data.alert_qty);
                        $('#up_purchase_price').val(data.purchase_price);
                        $('#up_profit_margin').val(data.profit_margin);
                        $('#up_selling_price').val(data.selling_price);
                        $('#up_discount_type').val(data.discount_type).trigger('change');
                        $('#up_discount_date').val(data.discount_date);
                        $('#up_discount_value').val(data.discount_value);
                        $('#up_status').val(data.status);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })

            // Update Data
            $("#EditForm").submit(function (e) {
                e.preventDefault();

                let id = $('#up_id').val();
                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/product-branch') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    beforeSend: function () {
                        $('#edit_btn').prop('disabled', true);
                        $('#edit_btn').html(`
                            <i class="fas fa-spinner fa-spin me-2"></i> Loading...
                        `);
                    },
                    success: function (res) {
                        swal.fire({
                            title: "Success",
                            text: "Branch Wise Product Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    // 🔹 Always runs (success or error)
                    complete: function () {
                        $('#edit_btn').prop('disabled', false);
                        $('#edit_btn').html(`Update`);
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_branch_id_validate').empty().html(error.branch_id);
                        $('#up_product_id_validate').empty().html(error.product_id);
                        $('#up_qty_validate').empty().html(error.qty);
                        $('#up_alert_qty_validate').empty().html(error.alert_qty);
                        $('#up_purchase_price_validate').empty().html(error.purchase_price);
                        $('#up_profit_margin_validate').empty().html(error.profit_margin);
                        $('#up_selling_price_validate').empty().html(error.selling_price);
                        $('#up_ip_address_validate').empty().html(error.ip_address);
                        $('#up_discount_type_validate').empty().html(error.discount_type);
                        $('#up_discount_date_validate').empty().html(error.discount_date);
                        $('#up_discount_value_validate').empty().html(error.discount_value);
                        $('#up_status_validate').empty().html(error.status);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            });

            // Delete Data
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
                            url: "{{ url('admin/product-branch') }}/" + id,
                            data: {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            success: function (res) {
                                // ✅ Reload product select again
                                reloadProductOptions();
                                updateReloadProductOptions()

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
                        swal.fire('Your Image is Safe');
                    }
                })
            })

            // View Data
            $(document).on("click", '#viewButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/product-branch/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;
                        // console.log(data);

                        // Open modal
                        $('#viewModal').modal('show');

                        $('#view_product_name').html(data.name);
                        $('#view_branch_name').html(data.branch_name);
                        $('#view_qty').html(data.qty);
                        $('#view_alert_qty').html(data.alert_qty);
                        $('#view_discount_type').html(data.discount_type);
                        $('#view_discount_value').html(data.discount_value);
                        $('#view_selling_price').html(data.selling_price);
                        $('#view_dis_date_start').html(res.dis_date_start);
                        $('#view_dis_date_end').html(res.dis_date_end);
                        $('#created_date').html(res.created_date);
                        $('#updated_date').html(res.updated_date);
                        $('#view_status').html(res.statusHtml);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })

            // Reload Product Options
            function reloadProductOptions() {
                $.ajax({
                    url: "{{ route('admin.get.product') }}",
                    type: "GET",

                    success: function(res) {

                        $('#product_id').html(`
                            <option value="">-- Selected --</option>
                        `);

                        $.each(res.products, function(index, row) {

                            let assigned = res.assignedCounts[row.id] ?? 0;

                            let disabled = assigned >= res.totalBranches;

                            $('#product_id').append(`
                                <option value="${row.id}"
                                    data-image-url="${row.image_url}"
                                    ${disabled ? 'disabled' : ''}>
                                    ${row.name}
                                </option>
                            `);
                        });

                        // Refresh Select2
                        $('#product_id').trigger('change');
                    }
                });
            }

            // Update Reload Product Options
            function updateReloadProductOptions() {
                $.ajax({
                    url: "{{ route('admin.get.product') }}",
                    type: "GET",

                    success: function(res) {

                        $('#up_product_id').html(`
                            <option value="">-- Selected --</option>
                        `);

                        $.each(res.products, function(index, row) {

                            let assigned = res.assignedCounts[row.id] ?? 0;

                            let disabled = assigned >= res.totalBranches;

                            $('#up_product_id').append(`
                                <option value="${row.id}"
                                    data-image-url="${row.image_url}"
                                    ${disabled ? 'disabled' : ''}>
                                    ${row.name}
                                </option>
                            `);
                        });

                        // Refresh Select2
                        $('#up_product_id').trigger('change');
                    }
                });
            }
        })
    </script>

@endpush

