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
        .table tbody tr {
           cursor: pointer;
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
        .table tbody tr:hover td {
            background-color: #0078D7 !important;
            color: #fff;
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
        .card{
            margin-bottom: 1rem
        }
        .card .card-body {
            padding: 0.5rem;
            height: 310px;
            overflow-y: auto;
        }
        .fs-sm{
            font-size: 12px;
        }
        .fs-xs{
            font-size: 11px;
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
                                <input type="text" name="barcode" class="search_field" id="barcode" style="background: #FFFFC0;" value="8942240180086">
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-4">
                                <label for="current_stock" class="d-block text-end">Current Stock</label>
                            </div>
        
                            <div class="col-lg-8">
                                <input type="text" name="current_stock" class="search_field" id="current_stock" style="background: #C0FFFF;" readonly value="10">
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
                                <input type="text" name="description" class="search_field" id="description" style="background: #C0FFFF;" readonly value="Fig Tangy, Sweet & Spicy pickle 215gm">
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
                                    <input type="number" name="scan_quantity" class="search_field" id="scan_quantity" style="background: #FFFFC0;" >
                                    <input type="hidden" name="mrp_amount" class="" value="280" id="mrp_amount" readonly>

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

                {{-- Show Product Data --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 datatables" id="stock_table">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Description</th>
                                            <th>Current Stock</th>
                                            <th>Actual Stock</th>
                                            <th>Adjust Stock</th>
                                            <th>MRP</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>15.000</td>
                                            <td>5.000</td>
                                            <td>-10.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>20.000</td>
                                            <td>5.000</td>
                                            <td>-15.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>11.000</td>
                                            <td>1.000</td>
                                            <td>-10.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>21.000</td>
                                            <td>10.000</td>
                                            <td>-11.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>16.000</td>
                                            <td>10.000</td>
                                            <td>-6.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>9.000</td>
                                            <td>2.000</td>
                                            <td>-7.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>10.000</td>
                                            <td>9.000</td>
                                            <td>-1.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>12.000</td>
                                            <td>8.000</td>
                                            <td>-4.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>10.000</td>
                                            <td>8.000</td>
                                            <td>-2.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>17.000</td>
                                            <td>8.000</td>
                                            <td>-9.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr>
            
                                        <tr>
                                            <td>8942240150072</td>
                                            <td>African Organic Willd HOney 500gm</td>
                                            <td>10.000</td>
                                            <td>5.000</td>
                                            <td>-5.000</td>
                                            <td>2500.00</td>
                                            <td></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-lg-9">
                        <p class="mb-1 text-danger fs-xs fw-bold">Number of line: <span id="line_number">0</span></p>

                        <div class="d-flex align-items-center gap-5">
                            <p class="mb-0 text-danger fw-bold">Current Stock: <span id="total_current_stock">00.000</span></p>
                            <p class="mb-0 text-danger fw-bold" id="actual_stock">Actual Stock: <span>00.000</span></p>
                            <p class="mb-0 text-danger fw-bold" id="adjust_qty">Adjust Qty: <span>-00.000</span></p>
                        </div>
                    </div>

                    <div class="col-lg-3 text-end">
                        <span class="text-danger fs-sm fw-bold">Double Click To Delete</span>

                        <div class="">
                            <button type="button" class="btn btn-sm btn-secondary"  data-bs-toggle="modal" data-bs-target="#saveModal">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary" id="closePage">Close</button>
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

            $('#barcode').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let barcode = $(this).val();

                    if (!barcode) {
                        alert('Barcode must required');
                        return;
                    }

                    // 👉 Auto set quantity
                    $('#scan_quantity').val(1);

                    // 👉 Focus qty
                    $('#scan_quantity').focus().select();
                }
            });

            // 👉 Focus flow (Enter key navigation)
            $('#scan_quantity').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let qty = $(this).val();

                    if (!qty || qty < 1) {
                        alert('Qty must be at least 1');
                        $(this).val(1).focus().select();
                        return;
                    }

                    $('#note').focus();
                }
            });

            // 👉 Final step: Add to table
            $('#note').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    let barcode = $('#barcode').val();
                    let current_stock = parseFloat($('#current_stock').val()) || 0;
                    let scan_quantity = parseFloat($('#scan_quantity').val()) || 0;
                    let mrp_amount    = parseFloat($('#mrp_amount').val()) || 0;
                    let note = $('#note').val();

                    // ✅ Validation
                    if (!barcode) {
                        alert('Barcode must required');
                        $('#barcode').focus();
                        return;
                    }

                    if (!scan_quantity || scan_quantity < 1) {
                        alert('Qty must be at least 1');
                        $('#scan_quantity').val(1).focus();
                        return;
                    }

                    if (!note) {
                        alert('Note must required');
                        $('#note').focus();
                        return;
                    }

                    // ❗ Fix your logic here
                    if (scan_quantity > current_stock) {
                        alert('Exceeding stock qty');
                        $('#scan_quantity').val(1).focus();
                        return;
                    }

                    let existingRow = null;

                    $('#stock_table tbody tr').each(function () {
                        let rowBarcode = $(this).find('td:eq(0)').text();

                        if (rowBarcode === barcode) {
                            existingRow = $(this);
                            return false; // break loop
                        }
                    });

                    if (existingRow) {
                        let oldActual = parseFloat(existingRow.find('.actual_stock').text()) || 0;
                        let newActual = oldActual + scan_quantity;
                        // console.log(
                        //     `current_stock ==>${current_stock}` ,
                        //     `oldActual ==>${oldActual}`, 
                        //     `newActual ==>${newActual}`
                        //     );

                        // validation
                        if (newActual > current_stock) {
                            alert('Exceeding stock! Resetting previous data...');

                            // ✅ RESET LOGIC
                            let resetActual = scan_quantity;

                            // যদি একবারেই exceed করে (scan_quantity > current_stock)
                            if (resetActual > current_stock) {
                                alert('Qty itself exceeds stock!');
                                return;
                            }

                            let resetAdjust = current_stock - resetActual;

                            // 👉 overwrite previous values
                            existingRow.find('.actual_stock').text(resetActual.toFixed(3));
                            existingRow.find('.adjust_stock').text(resetAdjust.toFixed(3));
                            existingRow.find('.stock_note').text(note);
                        }
                        else{
                            let newAdjust = current_stock - newActual; 
                            // 👉 Update row
                            existingRow.find('.adjust_stock').text(newAdjust.toFixed(3));
                            existingRow.find('.actual_stock').text(newActual.toFixed(3));
                            existingRow.find('.stock_note').text(note);
                        }
                    }
                    else{
                        let actual = current_stock - scan_quantity;
                        // 👉 Add to table function
                        let row = `
                            <tr>
                                <td>${barcode}</td>
                                <td>${$('#description').val() ?? ''}</td>
                                <td class="current_stock">${current_stock.toFixed(3)}</td>
                                <td class="actual_stock">${scan_quantity.toFixed(3)}</td>
                                <td class="adjust_stock">${actual.toFixed(3)}</td>
                                <td>${mrp_amount.toFixed(3)}</td>
                                <td class="stock_note">${note}</td>
                            </tr>
                        `;

                        $('tbody').prepend(row);
                    }

                    calculateTotals()
                    // 👉 Reset fields
                    // $('#barcode').val('').focus();
                    // $('#description').val('');
                    // $('#current_stock').val('');
                    // $('#scan_quantity').val('');
                    // $('#mrp_amount').val('');
                    // $('#note').val('');
                }
            });


            function calculateTotals() {
                let totalLine = 0;
                let totalCurrent = 0;
                let totalAdjust = 0;

                $('#stock_table tbody tr').each(function () {
                    totalLine++;

                    let current = parseFloat($(this).find('.current_stock').text()) || 0;
                    let adjust = parseFloat($(this).find('.adjust_stock').text()) || 0;

                    totalCurrent += current;
                    totalAdjust += adjust;
                });

                let totalActual = totalCurrent - totalAdjust;

                // 👉 Update UI
                $('#line_number').text(totalLine);
                $('#total_current_stock').text(totalCurrent.toFixed(3)); // ⚠️ use DIFFERENT ID
                $('#actual_stock span').text(totalActual.toFixed(3));
                $('#adjust_qty span').text("-" + totalAdjust.toFixed(3));
            }

            // Show Data through Datatable
            let datatables = $('.datatable').DataTable({
                pageLength: 10,
                scrollCollapse: true,
                scrollY: 250,
                layout: {
                    topStart: null,   // ✅ clean dropdown only
                    topEnd: null,         // ✅ pagination on top right
                    bottomStart: null,          // ❌ remove "Showing entries"
                    bottomEnd: null             // ❌ remove bottom pagination
                },

                language: {
                    lengthMenu: "_MENU_Page_Entries"   // 🔥 remove "Entries per page" text
                }
            });


            $(document).on('dblclick', '.table tbody tr', function () {
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
                        calculateTotals();

                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Deleted!',
                        //     text: 'Row has been removed.',
                        //     timer: 1500,
                        //     showConfirmButton: false
                        // });
                    }
                });
            });

            $(document).on('click', '#closePage', function () {
                window.location.href = "{{ route('admin.dashboard') }}";
            });
            
        });
    </script>

@endpush

