@extends('admin.layout.master')

@push('add-title')
    Stock Transfer By Category
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
        .datatables tbody tr td:nth-child(4) {
            background-color: #FFFFE0;
            color: #000;
            font-weight: 900;
        }
        .search_table tbody tr td:nth-child(5) {
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
        .table tbody tr:hover td {
            background-color: #0078D7 !important;
            color: #fff;
            cursor: pointer;
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
        .select_warehouse{
            background: #ebebeb;
            padding: 4px 8px 0;
            border-radius: 4px;
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table_responsive {
                overflow-x: auto;
                overflow-y: auto;
                height: 300px;
            }
        }
        .warehouse_table thead th {
            position: sticky;
            top: 0;
            background: #fff;      /* must set background */
            z-index: 2;
        }
        .warehouse_table tbody tr.active {
            background-color: #0078D7 !important;
            color: #fff;
            cursor: pointer;
        }
        .warehouse_table tbody tr.active td{
            font-size: 10px !important;
            color: #4D555E;
            font-weight: 700 !important;
            background-color: #0078D7 !important;
            color: #fff;
        }
        .card-bordered{
            background: #ABABAB;
            border: 1px solid #a39e9e;
            padding: 5px;
        }
        #storeListModal .modal-body{
            padding: 10px;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

    <h2 class="text-center fw-bold mb-2">Stock Transfer By Category</h2>

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
                                <label for="challan" class="d-block text-end">Challan#</label>
                            </div>

                            <div class="col-lg-8">
                                <input type="text" name="challan" class="search_field" id="challan" readonly value="DC005010000001" style="font-weight: 700;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="transfer_to" class="d-block text-end">Transfer To</label>
                            </div>
        
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-1">
                                    <input type="text" name="transfer_to" class="search_field" id="transfer_to" disabled style="font-weight: 700;">
                                    <input type="hidden" name="warehouse_id" class="search_field" id="warehouse_id">

                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#storeListModal" class="select_warehouse"><i class="ti ti-dots"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product_info">
                        <span class="fw-bold d-block mb-2" style="border-bottom: 2px solid #726c6c;">Product Information</span>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="brand" class="d-block text-end">Brand</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <select class="search_field" name="brand" id="brand" style="cursor: pointer;">
                                        <option value="all" selected>All</option>
                                        <option value="khejuri">Khejuri</option>
                                        <option value="honeyraj">Honeyraj</option>
                                        <option value="shoshti">Shosti</option>
                                        <option value="glarvest">Glarvest</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="category" class="d-block text-end">Category</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <select class="search_field" name="category" id="category" style="cursor: pointer;">
                                        <option value="all" selected>All</option>
                                        <option value="bevarage">Bevarage</option>
                                        <option value="honey">Honey</option>
                                        <option value="rice">Rice</option>
                                        <option value="spices">Spices</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="sub_category" class="d-block text-end">Sub Category</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <select class="search_field" name="sub_category" id="sub_category" style="cursor: pointer;">
                                        <option value="all" selected>All</option>
                                        <option value="bevarage">Bevarage</option>
                                        <option value="honey">Honey</option>
                                        <option value="rice">Rice</option>
                                        <option value="spices">Spices</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="item" class="d-block text-end">Item</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <select class="search_field" name="item" id="item" style="cursor: pointer;">
                                        <option value="all" selected>All</option>
                                        <option value="bevarage">Bevarage</option>
                                        <option value="honey">Honey</option>
                                        <option value="rice">Rice</option>
                                        <option value="spices">Spices</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2 text-end">
                            <button type="button" class="btn btn-sm btn-secondary">Add</button>
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
                                    <th>Quantity</th>
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
                        <p class="fw-bold fs-sm text-danger mb-1">Double Click To delete row</p>
                        <div class="">
                            <a href="{{ route('admin.stock-receive-preview') }}" class="btn btn-sm btn-secondary">Preview</a>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#saveChallanModal">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#closeModal">Close</button>
                        </div>
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
                    <h5 class="modal-title" id="myModalLabel">Transfer</h5>
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
                    <h5 class="modal-title" id="myModalLabel">Transfer</h5>
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

    <!-- Close Modal -->
    <div id="closeModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">You have some unsaved transfer(s)......Are you sure to exit.</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" id="closePage" class="btn btn-secondary waves-effect me-3">Yes </button>

                            <button type="button" id="btn-store" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- Store List Modal -->
    <div id="storeListModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Store List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="card-bordered">
                        <div class="card-body">
                            <div class="table_responsive">
                                <table class="table table-bordered warehouse_table mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Code</th>
                                            <th>Store Name</th>
                                            <th>Area</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Postal Code</th>
                                            <th>Phone Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-id="1"><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Banasree</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>dhaka</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>

                                        <tr>
                                            <td data-id="2"><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010002</td>
                                            <td>Chittagong</td>
                                            <td>Talertek</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>Chittagong</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>

                                        <tr>
                                            <td data-id="3"><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010003</td>
                                            <td>Chandpur</td>
                                            <td>Suchipara</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>Chandpur</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>

                                        <tr>
                                            <td data-id="4"><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Baneshor</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>Chuadanga</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>
                                        
                                        {{--  <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Banasree</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>dhaka</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>
                                       
                                        <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Banasree</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>dhaka</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>
                                         <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Banasree</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>dhaka</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr>
                                         <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>100010001</td>
                                            <td>Dhaka</td>
                                            <td>Banasree</td>
                                            <td>House 5, Road 3, Block B</td>
                                            <td>dhaka</td>
                                            <td>1212</td>
                                            <td>01710-254136</td>
                                        </tr> --}}
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

    <script>
        $(document).ready(function () {
            $(document).on('keydown', '#barcode', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let barcode = $.trim($(this).val());
                    // 👉 CASE 1: Empty → open modal
                    if (barcode === '') {
                        let modal = new bootstrap.Modal(document.getElementById('productSearchModal'));
                        modal.show();
                    } 
                    // 👉 CASE 2: Has value → set qty + focus
                    else {
                        $('#transfer_stock').val(1);
                        $('#transfer_stock').focus();
                    }
                }
            });

            $('#transfer_stock').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let qty = $(this).val();

                    if (!qty || qty < 1) {
                        alert('Qty must be at least 1');
                        $(this).val(1).focus().select();
                        return;
                    }

                    // 👉 Focus qty
                    $('#reason').focus().select();
                }
            });

            $('#reason').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let barcode = $('#barcode').val();
                    let transfer_stock = parseFloat($('#transfer_stock').val()) || 0;
                    let reason = $(this).val();

                     // ✅ Validation
                     if (!barcode) {
                        alert('Barcode must required');
                        $('#barcode').focus();
                        return;
                    }

                    if (!transfer_stock || transfer_stock < 1) {
                        alert('Qty must be at least 1');
                        $('#transfer_stock').val(1).focus();
                        return;
                    }

                    if (!reason) {
                        alert('Reason must required');
                        $('#reason').focus();
                        return;
                    }
                }
            });
        });


        // Date set
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        let month = monthNames[today.getMonth()];
        let year = today.getFullYear();

        let formattedDate = day + '-' + month + '-' + year;


        $('#date_time').val(formattedDate);

        $(document).on('dblclick', '.datatables tbody tr', function () {
            let row = $(this);

            Swal.fire({
                // title: 'Are you sure?',
                text: "Are you sure to discard the requision product???",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#092C4C',
                cancelButtonColor: '#db0000',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Remove row
                    row.remove();
                }
            });
        });
    </script>


    <script>
        // Warehouse Select Modal
        let currentIndex = 0;

        function highlightRow(index) {
            let rows = $('.warehouse_table tbody tr');

            rows.removeClass('active');

            if (rows.length > 0) {
                $(rows[index]).addClass('active');

                // scroll into view (optional but useful)
                $('.table_responsive').scrollTop(
                    $(rows[index]).position().top + $('.table_responsive').scrollTop()
                );
            }
        }

        // 👉 Modal Open Event
        $('#storeListModal').on('shown.bs.modal', function () {
            currentIndex = 0;
            highlightRow(currentIndex);
        });

        // 👉 Keyboard Control
        $(document).on('keydown', function (e) {
            let rows = $('.warehouse_table tbody tr');

            if ($('#storeListModal').hasClass('show')) {

                if (e.key === "ArrowDown") {
                    e.preventDefault();
                    if (currentIndex < rows.length - 1) {
                        currentIndex++;
                        highlightRow(currentIndex);
                    }
                }

                if (e.key === "ArrowUp") {
                    e.preventDefault();
                    if (currentIndex > 0) {
                        currentIndex--;
                        highlightRow(currentIndex);
                    }
                }

                if (e.key === "Enter") {
                    e.preventDefault();

                    let selectedRow = $(rows[currentIndex]);

                    let id   = selectedRow.find('td:eq(0)').data('id');
                    let code = selectedRow.find('td:eq(1)').text(); // Code column
                    let name = selectedRow.find('td:eq(2)').text(); // Store name

                    // 👉 Set value to input
                    $('#warehouse_id').val(id);
                    $('#transfer_to').val( name + ' - ' + code);

                    // 👉 Optional: close modal
                    $('#storeListModal').modal('hide');
                }
            }
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

