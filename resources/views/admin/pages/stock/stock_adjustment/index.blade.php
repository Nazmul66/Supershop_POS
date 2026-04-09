@extends('admin.layout.master')

@push('add-title')
    Stock Adjustment
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

    <style>
        body{
            font-family: "Roboto", sans-serif;
        }
        label{
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: block;
            user-select: none;
            -webkit-user-select: none; /* Chrome, Safari */
            -moz-user-select: none;    /* Firefox */
            -ms-user-select: none;     /* IE/Edge */
        }
        .search_field{
            color: #000;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            height: 25px;
            border: 1px solid #dfdfdf;
            padding: 0px 9px;
            border-bottom: 2px solid #9b9797;
            border-radius: 2px;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
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
            color: #000;
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

    <h2 class="text-center fw-bold mb-2">Item Inventory Journal</h2>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="session_no" class="d-block text-end">Session No</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="session_no" class="search_field" id="session_no" style="background: #C0FFFF;" readonly value="0006042603000001">
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="barcode" class="d-block text-end">Barcode</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="barcode" class="search_field" id="barcode" style="background: #FFFFC0;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="current_stock" class="d-block text-end">Current Stock</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="current_stock" class="search_field" id="current_stock" style="background: #C0FFFF;" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="date_time" class="d-block text-end">Date</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="date_time" class="search_field" id="date_time" style="background: #C0FFFF;" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="description" class="d-block text-end">Description</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="description" class="search_field" id="description" style="background: #C0FFFF;" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="scan_quantity" class="d-block text-end">Scan Quantity</label>
                            </div>
        
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" name="scan_quantity" class="search_field" id="scan_quantity" style="background: #C0FFFF;" readonly>

                                    <div class="d-flex align-items-center gap-2">
                                        <input class="form-check-input m-0" type="checkbox" value="" id="autoScan">
                                        <label class="text-danger" for="autoScan" style="white-space: nowrap;">
                                            Auto Scan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-2">
                                <label for="note" class="d-block text-end">Note</label>
                            </div>
        
                            <div class="col-lg-10">
                                <input type="text" name="note" class="search_field" id="note" style="background: #FFFFC0;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    <div class="d-flex align-items-center">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50">
                    <p>Are you sure to save the challan</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                data-bs-dismiss="modal">Yes </button>

                            <button type="button" id="btn-store" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">No</button>
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

