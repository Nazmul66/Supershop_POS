@extends('admin.layout.master')

@push('add-title')
    Stock Requisition
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
        .card-bordered{
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

    <h2 class="text-center fw-bold mb-2">Requisition</h2>

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="date_time" class="d-block text-end">Date</label>
                            </div>

                            <div class="col-lg-8">
                                <input type="text" name="date_time" class="search_field" id="date_time" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="product_info">
                        <span class="fw-bold d-block mb-2" style="border-bottom: 2px solid #726c6c;">Product Information</span>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="received_from" class="d-block text-end">Requisition To</label>
                                </div>
            
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center gap-1">
                                        <input type="text" name="cus_id" class="search_field" id="received_from" readonly>

                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#storeListModal" class="select_warehouse"><i class="ti ti-dots"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="barcode" class="d-block text-end">Barcode</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="barcode" class="search_field" id="barcode">
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="name" class="d-block text-end">Name</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="name" class="search_field" id="name" disabled>
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="category" class="d-block text-end">Category</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="category" class="search_field" id="category" disabled>
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="sub_category" class="d-block text-end">Sub Category</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="sub_category" class="search_field" id="sub_category" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="brand" class="d-block text-end">Brand</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="brand" class="search_field" id="brand" disabled>
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="vat" class="d-block text-end">VAT (%)</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="vat" class="search_field" id="vat" disabled>
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="sale_qty" class="d-block text-end">Sale Quantity</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="sale_qty" class="search_field" id="sale_qty" disabled>
                                </div>
                            </div>
                        </div>
        
                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="current_stock" class="d-block text-end">Current Stock</label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="current_stock" class="search_field" id="current_stock" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="Sale_price" class="d-block text-end">Sale Price </label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="Sale_price" class="search_field" id="Sale_price" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="requisition_qty" class="d-block text-end">Requisition Qty </label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="number" name="requisition_qty" class="search_field" id="requisition_qty">
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-4">
                                    <label for="reason" class="d-block text-end">Reason </label>
                                </div>
        
                                <div class="col-lg-8">
                                    <input type="text" name="reason" class="search_field" id="reason">
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
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
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

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Requisition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">Are you sure to discard this requisition</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3">Yes </button>

                            <button type="button" id="btn-store" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
 
    <!-- Save Challan Modal -->
    <div id="saveChallanModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Requisition</h5>
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
                    <h5 class="modal-title" id="myModalLabel">Requisition</h5>
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
                    <h5 class="modal-title" id="myModalLabel">Requisition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">You have some unsaved requisition(s)......Are you sure to exit.</p>
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

    <!-- Product Search Modal -->
    <div id="productSearchModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Product Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="">

                        {{-- Search Content --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-1">
                                        <label for="searchByName" style="white-space: nowrap;">Search <span class="text-danger">[F1]</span>:</label>
                                        <input type="text" name="searchByName" class="search_field" id="searchByName" >
                                    </div>
                        
                                    <div class="d-flex align-items-center gap-1">
                                        <label for="searchBybarcode" style="white-space: nowrap;">By Barcode <span class="text-danger">[F3]</span>:</label>
                                        <input type="text" name="searchBybarcode" class="search_field" id="searchBybarcode" >
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" name="showZero" type="checkbox" value="" id="showZero">
                                        <label class="" for="showZero">
                                            Show with zero(0) <span class="text-danger">[F2]</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Show Search Product Data --}}
                        <div class="mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 search_table">
                                        <thead>
                                            <tr>
                                                <th>Barcode or SKU</th>
                                                <th>User Barcode</th>
                                                <th>Name</th>
                                                <th>MRP</th>
                                                <th>Balance</th>
                                                <th>UOM</th>
                                                <th>VAT(%)</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>

                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>
                                                    <div class="price_show">
                                                        2500.00
                                                    </div>
                                                </td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>

                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>
                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
                                                <td>0.00</td>
                                                <td>Honey</td>
                                                <td>Organic Honey</td>
                                            </tr>

                                            <tr>
                                                <td>A000025</td>
                                                <td>8942240150072</td>
                                                <td>African Organic Willd HOney 500gm</td>
                                                <td>2500.00</td>
                                                <td>5</td>
                                                <td>Pcs</td>
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
                                            <th>Barcode or SKU</th>
                                            <th>User Barcode</th>
                                            <th>Name</th>
                                            <th>MRP</th>
                                            <th>Balance</th>
                                            <th>UOM</th>
                                            <th>VAT(%)</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        {{-- <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>



                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
                                        </tr>
                                        <tr>
                                            <td>A000025</td>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>2500.00</td>
                                            <td>5</td>
                                            <td>Pcs</td>
                                            <td>0.00</td>
                                            <td>Honey</td>
                                            <td>Organic Honey</td>
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
                        $('#requisition_qty').val(1);
                        $('#requisition_qty').focus();
                    }
                }
            });

            $('#requisition_qty').on('keydown', function (e) {
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
                    let requisition_qty = parseFloat($('#requisition_qty').val()) || 0;
                    let reason = $(this).val();

                     // ✅ Validation
                     if (!barcode) {
                        alert('Barcode must required');
                        $('#barcode').focus();
                        return;
                    }

                    if (!requisition_qty || requisition_qty < 1) {
                        alert('Qty must be at least 1');
                        $('#requisition_qty').val(1).focus();
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
                title: 'Are you sure?',
                text: "You want to remove this row!",
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
        $(document).ready(function () {
            $('#productSearchModal').on('shown.bs.modal', function () {
                $('.search_table').DataTable().columns.adjust().draw();
            });

            // Product Search option
            let search_table = $('.search_table').DataTable({
                pageLength: 10,
                scrollCollapse: true,
                scrollY: 400,
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

<script>
    $(document).ready(function () {
        $(document).on('keydown', function (e) {
            switch (e.key) {
                case 'F1':
                    e.preventDefault(); // ❗ stop browser help
                    $('#searchByName').focus();
                    break;

                case 'F2':
                    e.preventDefault();
                    let checkbox = $('#showZero');

                    checkbox.prop('checked', !checkbox.prop('checked')); // 🔄 toggle
                    checkbox.focus();
                    break;

                case 'F3':
                    e.preventDefault();
                    $('#searchBybarcode').focus();
                    break;
                case 'Escape':
                    let modalEl = document.getElementById('productSearchModal');
                    let modal = bootstrap.Modal.getInstance(modalEl);

                    if (modal) {
                        modal.hide();
                    }
                    $('#barcode').focus();
                    break;
            }
        });
    });
</script>
@endpush

