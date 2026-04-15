@extends('admin.layout.master')

@push('add-title')
    Stock Received
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

    <style>
        label{
            font-size: 11px;
            cursor: pointer;
            display: block;
        }
        .header{
            display: none;
        }
        .page-wrapper {
            padding: 0px 0px 0px 30px;
        }
        .search_field{
            color: #000;
            font-size: 12px;
            font-weight: 500;
            width: 100%;
            height: 25px;
            border: 1px solid #dfdfdf;
            padding: 0px 9px;
            border-bottom: 2px solid #9b9797;
            border-radius: 2px;
            box-shadow: 0px 3px 20px rgba(0, 0, 0, 0.1);
        }
        .search_field:focus{
            border-bottom: 2px solid #86b7fe;
        }
        .search_field:disabled {
            background-color: #F0F0F0;
            color: #6c757d;
            cursor: not-allowed;
            opacity: 0.8;
        }
        .search_field[readonly] {
            background-color: #F0F0F0;
            color: #495057;
            cursor: default;
        }
        .form-select {
            height: 34px;
            border: 2px solid #9b9797;
        }
        .row>* {
            padding-right: 0.4rem !important;
            padding-left: 0.4rem !important;
        }
        .form_check {
            /* display: block;
            min-height: 1.5rem;
            padding-left: 1.5em;
            margin-bottom: .125rem; */
        }
        .form-check-input {
            border-color: #86b7fe;
            outline: 0;
        }
        .table thead tr,
        .table tbody tr {
            border-color: #8d8d8d;
        }
        .table thead tr th{
            font-size: 11px;
            font-weight: 700;
            color: #212B36;
            padding: 6px 10px !important;
        }
        .table tbody tr td{
            font-size: 10px;
            font-weight: 700;
            color: #212B36;
        }
        .table td {
            padding: 6px 10px !important;
        }
        .fs-md{
            font-size: 10px !important;
        }
        .table tbody tr td:nth-child(4) {
            background-color: #FFFFE0;
            color: #000;
            font-weight: 900;
        }
        .dt-container .dt-length{
            display: flex !important;
            align-items: center !important;
        }
        div.dt-container select.dt-input {
            margin-right: 8px !important;
        }
        div.dt-container .dt-info{
            font-size: 12px;
        }
        body div.dt-container .dt-paging .dt-paging-button.current, body div.dt-container .dt-paging .dt-paging-button.current:hover {
            font-size: 12px;
        }
        body div.dt-container .dt-paging .dt-paging-button.disabled, body div.dt-container .dt-paging .dt-paging-button.disabled {
            font-size: 12px;
        }
        body div.dt-container .dt-paging .dt-paging-button.disabled:hover, body div.dt-container .dt-paging .dt-paging-button.disabled:active {
            font-size: 12px;
        }
        div.dt-container select.dt-input {
            font-size: 12px;
        }
        div.dt-container .dt-paging .dt-paging-button {
            font-size: 12px;
        }
        .product_info{

        }
        .copyright-footer {
            display: none !important;
        }
        .modal-header{
            background: #F0F0F0;
        }
        .modal-footer{
            padding: 0.4rem .8rem !important;
            background: #F0F0F0;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

    <h2 class="text-center fw-bold mb-2">Stock Received</h2>

 <div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                     <div class="row align-items-center justify-content-between">
                        <div class="col-lg-4">
                            <label for="date_time" class="d-block text-end">Date</label>
                        </div>

                        <div class="col-lg-8">
                            <input type="text" name="date_time" class="search_field" id="date_time" readonly>
                        </div>
                     </div>
                </div>

                <div class="mb-1">
                     <div class="row align-items-center justify-content-between">
                        <div class="col-lg-4">
                            <label for="admin_user" class="d-block text-end">Challan #</label>
                        </div>

                        <div class="col-lg-8">
                            <select class="search_field" name="admin_user" id="admin_user" style="cursor: pointer;">
                                <option value="all" selected>-- Select --</option>
                                <option value="dc10005000011">DC10005000011</option>
                            </select>
                        </div>
                     </div>
                </div>

                <div class="mb-3">
                    <div class="row align-items-center justify-content-between">
                       <div class="col-lg-4">
                           <label for="received_from" class="d-block text-end">Received From</label>
                       </div>

                       <div class="col-lg-8">
                            <input type="text" name="cus_id" class="search_field" id="received_from" readonly>
                       </div>
                    </div>
               </div>

                <div class="product_info">
                    <span class="fw-bold d-block mb-2" style="border-bottom: 2px solid #726c6c;">Product Information</span>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="barcode" class="d-block text-end">Barcode</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="barcode" class="search_field" id="barcode">
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="name" class="d-block text-end">Name</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="name" class="search_field" id="name" disabled>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="category" class="d-block text-end">Category</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="category" class="search_field" id="category" disabled>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="sub_category" class="d-block text-end">Sub Category</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="sub_category" class="search_field" id="sub_category" disabled>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="sale_price" class="d-block text-end">Sale price</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="sale_price" class="search_field" id="sale_price" disabled>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="challan_qty" class="d-block text-end">Challan Qty</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="challan_qty" class="search_field" id="challan_qty" disabled>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="receiving_qty" class="d-block text-end">Receiving Qty</label>
                            </div>
    
                            <div class="col-lg-8">
                                <input type="text" name="receiving_qty" class="search_field" id="receiving_qty" style="width: 50%;">
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="receiving_qty" class="d-block text-end">Auto Scan</label>
                            </div>
    
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-2">
                                    <input class="form-check-input m-0" type="checkbox" value="" id="autoScan">
                                    <label class="" for="autoScan">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Show Search Product Data --}}
    <div class="col-lg-9">
        <div class="">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 datatables">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Rec. Qty</th>
                                <th>Remain Qty</th>
                                <th>UOM</th>
                                <th>MRP</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>5.000</td>
                                <td>5.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>

                            <tr>
                                <td>A000025</td>
                                <td>8942240150072</td>
                                <td>African Organic Willd HOney 500gm</td>
                                <td>10.000</td>
                                <td>10.000</td>
                                <td>Pcs</td>
                                <td>2500.00</td>
                                <td>0.00</td>
                                <td>Honey</td>
                                <td>Organic Honey</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>

 <div class="footer_line mt-3">
    <div class="row align-items-end justify-content-between">
        <div class="col-lg-6 offset-lg-2">
            <div class="d-flex align-items-end gap-3">
                <div class="">
                    <a href="{{ route('admin.stock-receive-preview') }}" class="btn btn-sm btn-secondary">Preview</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#saveChallanModal">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary" id="closePage">Close</button>
                </div>
        
                <div class="">
                    <p class="mb-1 text-danger fw-bold">TOTAL QTY: 81</p>
                    <p class="mb-0 text-danger fw-bold">TOTAL Value: 120550</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <p class="mb-0 text-danger fw-bold text-end">TOTAL LINE: 9</p>
        </div>
    </div>
 </div>


 
    <!-- Save Challan Modal -->
    <div id="saveChallanModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Stock Receive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">Are you sure to save the challan</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                            data-bs-toggle="modal" data-bs-target="#saveModal">Yes </button>

                            <button type="button" id="btn-store" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Save Modal -->
    <div id="saveModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Stock Receive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/info_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">Saved Successfully!!!!</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                data-bs-dismiss="modal">OK </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>

    <script>
        $(document).ready(function () {
            let today = new Date();
    
            let day = String(today.getDate()).padStart(2, '0');
            let monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            let month = monthNames[today.getMonth()];
            let year = today.getFullYear();
    
            let formattedDate = day + '-' + month + '-' + year;
    
            $('#date_time').val(formattedDate);
        });
    </script>

    <script>
        $(document).ready(function () {
            // Show Data through Datatable
            let datatables = $('.datatables').DataTable({
                pageLength: 10,
                scrollCollapse: true,
                scrollY: 300,
                layout: {
                    topStart: ['info','pageLength'],   // ✅ clean dropdown only
                    topEnd: ['paging'],         // ✅ pagination on top right

                    bottomStart: null,          // ❌ remove "Showing entries"
                    bottomEnd: null             // ❌ remove bottom pagination
                },

                language: {
                    lengthMenu: "_MENU_Page_Entries"   // 🔥 remove "Entries per page" text
                }
            });


            $(document).on('click', '#closePage', function () {
                window.location.href = "{{ route('admin.dashboard') }}";
            });
        });
    </script>
@endpush

