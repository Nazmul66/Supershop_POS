@extends('admin.layout.master')

@push('add-title')
    Branch Product Template
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
            @if(auth("admin")->user()->can("pdf.device"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.device.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.device"))
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
            @if(auth("admin")->user()->can("create.device"))
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
                                    <select class="form-select" name="product_id" id="product_id">
                                        <option value="0" selected disabled>-- Selected --</option>
                                        @foreach ($products as $row)
                                            <option value="{{ $row->id }}" data-image-url="{{ asset($row->thumb_image) }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="product_id_validate" class="text-danger mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="branch_id">Branch Name <span class="text-danger">*</span></label>
                                    <select class="form-select" name="branch_id" id="branch_id">
                                        <option value="0" selected disabled>-- Selected --</option>
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
                                    <select class="form-select" name="product_id" id="up_product_id">
                                        <option value="0" selected disabled>-- Selected --</option>
                                        @foreach ($products as $row)
                                            <option value="{{ $row->id }}" data-image-url="{{ asset($row->thumb_image) }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
    
                                    <span id="up_product_id_validate" class="text-danger mt-1"></span>
                                </div>
    
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="up_branch_id">Branch Name <span class="text-danger">*</span></label>
                                    <select class="form-select" name="branch_id" id="up_branch_id">
                                        <option value="0" selected disabled>-- Selected --</option>
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

                            <div class="mb-3">
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

                                <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
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
                        <h5 class="modal-title" id="myModalLabel">View Device List</h5>

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
                            <span class="text-dark" id="view_device_code"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Ip Address : </label>
                            <span class="text-dark" id="view_ip_address"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Last Active At: </label>
                            <span class="text-dark" id="view_last_active"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Is Online: </label>
                            <span class="text-dark" id="view_is_online"></span>
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
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

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

            $('#up_discount_type').change(function () {
                let discountType = $(this).val();
                if ( discountType === 'fixed' || discountType === 'percent') {
                    $('.up_discount_area').removeClass('d-none');
                }
                else {
                    $('.up_discount_area').addClass('d-none');
                    $('#up_discount_value').val('');
                    $('#up_discount_date').val('');
                }
            });

            $('#product_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#branch_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });
            
            $('#up_product_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            $('#up_branch_id').select2({
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
        });
    </script>

    <script>
        $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('#productBranchTable').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.product-branch-data') }}",
                // pageLength: 30,
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
                ]
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
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            $('#createModal').modal('hide');
                            $('#createForm')[0].reset();
                            $('.validation-error').html('');
                            datatables.ajax.reload();

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })
                        }
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

                        $('#view_branch_name').html(data.branch_name);
                        $('#view_device_name').html(data.device_name);
                        $('#view_device_code').html(data.device_code);
                        $('#view_ip_address').html(data.ip_address);
                        $('#view_last_active').html(data.last_active_at);
                        $('#view_is_online').html(res.is_online);
                        $('#created_date').html(res.created_date);
                        $('#updated_date').html(res.updated_date);
                        $('#view_status').html(res.statusHtml);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })
        })

    </script>
@endpush

