@extends('admin.layout.master')

@push('add-title')
    View Product Received
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        body{
            font-family: "Nunito", sans-serif;
            background: #A9A9A9;
        }
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
        .table thead{
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }
        .table td {
            vertical-align: top;
            padding: 3px 10px !important;
        }
        .table thead tr th{
            font-size: 11px;
            font-weight: 900;
            color: #212B36;
            background: transparent;
            padding: 6px 10px !important;
        }
        .table tbody tr td{
            font-size: 11px;
            font-weight: 600;
            color: #212B36;
            border: 1px solid transparent; 
        }
        .table tbody tr.challan_total td{
            color: #0926b3;
            font-weight: 800;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: end;
        }
        .table tbody tr.day_total td{
            color: #0f8d2a;
            font-weight: 800;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: end;
        }
        .table tbody tr.store_total td{
            color: #7c1fd1;
            font-weight: 800;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: end;
        }
        .table tbody tr.grand_total td{
            color: #b10000;
            font-weight: 800;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: end;
        }
        .table tbody tr:hover td{
             background: #2f91a1;
             color: #FFF;
             cursor: pointer;
        }
        table.datatables {
            table-layout: fixed;
            width: 100%;
        }
        .datatables th:nth-child(5),
        .datatables td:nth-child(5) {
            width: 200px !important;
            max-width: 200px;
            white-space: normal;        /* allow wrapping */
            word-break: break-word;     /* break long words */
            overflow-wrap: anywhere;    /* modern support */
        }
        .datatables th:nth-child(7),
        .datatables td:nth-child(7) {
            width: 200px !important;
            max-width: 200px;
            white-space: normal;        /* allow wrapping */
            word-break: break-word;     /* break long words */
            overflow-wrap: anywhere;    /* modern support */
        }
        .fs-md{
            font-size: 10px !important;
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
        .report_view_structure{
            background: #fff;
            min-height: 100vh;
            padding: 10px 24px 20px;
            border: 1px solid #000;
            border-radius: 2px;
        }
        .custom-pagination{
            position: absolute;
            top: 90px;
            left: 70px;
        }
        .custom-pagination button{
            font-size: 12px;
            font-weight: 700;
            color: #6a6565;
            border: 2px solid #dee2e6 !important;
            width: 35px;
            height: 28px;
        }
        .custom-pagination button:hover{
            color: #fff !important;
            background: #288EA5 !important;
            border: 2px solid #288EA5 !important;
        }
        .custom-pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        #pageInput{
            width: 60px;
            height: 27px;
            text-align: center;
            border: 1px solid #1b333a4a;
            color: #686868;
        }
        #pageInput::-webkit-outer-spin-button,
        #pageInput::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

   <div class="report_view_structure">
        <h2 class="text-center fw-bold mb-1">Ghorer Bazar</h2>
        <h4 class="text-center fw-bold mb-1">Metro Shewrapara</h4>
        <h4 class="text-center fw-bold mb-1">Product Received Report</h4>
        <p class="text-center fw-bold mb-0">From 18-Feb-2026 To: 21-Feb-2026</p>

        <div class="row">
            {{-- Show Search Product Data --}}
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 datatables">
                            <thead>
                                <tr>
                                    <th>RECEIVE FROM</th>
                                    <th>RECEIVE DATE</th>
                                    <th>CHALLAN NO</th>
                                    <th>BARCODE</th>
                                    <th>NAME</th>
                                    <th>SKU</th>
                                    <th>SALE PRICE</th>
                                    <th>RQTY</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DHAKA</td>
                                    <td>18-Feb-2026</td>
                                    <td>DC10005000012</td>
                                    <td>8941140120087</td>
                                    <td>Gawa Ghee 200gm</td>
                                    <td>A000095</td>
                                    <td>360.00</td>
                                    <td>9.00</td>
                                    <td>3240.00</td>
                                </tr>

                                <tr class="challan_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Challan Total (DC10005000012) :</td>
                                    <td>9.00</td>
                                    <td>3240.00</td>
                                </tr>

                                <tr class="day_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Day Total :</td>
                                    <td>9.00</td>
                                    <td>3240.00</td>
                                </tr>

                                <tr>
                                    <td>DHAKA</td>
                                    <td>19-Feb-2026</td>
                                    <td>DC10005000013</td>
                                    <td>8941140120024</td>
                                    <td>Deshi mustard oil 5 Ltr</td>
                                    <td>A000036</td>
                                    <td>1550.00</td>
                                    <td>4.00</td>
                                    <td>6200.00</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Discovery Organic Apple cider vinegar 500ml</td>
                                    <td>A000065</td>
                                    <td>750.00</td>
                                    <td>5.00</td>
                                    <td>3750.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>African Organic Willd HOney 500gm</td>
                                    <td>A000135</td>
                                    <td>625.00</td>
                                    <td>10.00</td>
                                    <td>6250.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Honey Nut 500gm</td>
                                    <td>A000099</td>
                                    <td>1000.00</td>
                                    <td>15.00</td>
                                    <td>15000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Ajwa Premimum Dates ( Jumbo ) 500gm</td>
                                    <td>A000176</td>
                                    <td>1250.00</td>
                                    <td>5.00</td>
                                    <td>7250.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Karkuma Organic Apple cider Vinegar 1kg</td>
                                    <td>A000168</td>
                                    <td>750.00</td>
                                    <td>5.00</td>
                                    <td>3750.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>HImalaya Pink Salt 500gm</td>
                                    <td>A000161</td>
                                    <td>750.00</td>
                                    <td>10.00</td>
                                    <td>7500.00</td>
                                </tr>

                                 <tr class="challan_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Challan Total (DC10005000012) :</td>
                                    <td>54.00</td>
                                    <td>49700.00</td>
                                </tr>

                                <tr>
                                    <td>DHAKA</td>
                                    <td>19-Feb-2026</td>
                                    <td>DC10005000015</td>
                                    <td>8941140120024</td>
                                    <td>Black Seed Honey 500gm</td>
                                    <td>A000001</td>
                                    <td>800.00</td>
                                    <td>5.00</td>
                                    <td>4000.00</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Black Seed Honey 1kg</td>
                                    <td>A000002</td>
                                    <td>1600.00</td>
                                    <td>5.00</td>
                                    <td>8000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Gawa Ghee 1kg</td>
                                    <td>A000030</td>
                                    <td>1800.00</td>
                                    <td>10.00</td>
                                    <td>18000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Honey Nut 500gm</td>
                                    <td>A000078</td>
                                    <td>1000.00</td>
                                    <td>5.00</td>
                                    <td>5000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Honey Nut 800gm</td>
                                    <td>A000099</td>
                                    <td>1500.00</td>
                                    <td>5.00</td>
                                    <td>7500.00</td>
                                </tr>

                                <tr class="challan_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Challan Total (DC10005000015) :</td>
                                    <td>30.00</td>
                                    <td>42500.00</td>
                                </tr>
                                <tr class="day_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Day Total :</td>
                                    <td>84.00</td>
                                    <td>92200.00</td>
                                </tr>

                                <tr>
                                    <td>DHAKA</td>
                                    <td>21-Feb-2026</td>
                                    <td>DC10005000016</td>
                                    <td>8941140120024</td>
                                    <td>Lichu Flower Honey 500gm</td>
                                    <td>A000007</td>
                                    <td>600.00</td>
                                    <td>10.00</td>
                                    <td>6000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Honeyraj mixed flower honey with honeycomb 250gm</td>
                                    <td>A000021</td>
                                    <td>1000.00</td>
                                    <td>5.00</td>
                                    <td>5000.00</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>8941140120024</td>
                                    <td>Mustard Oil 500 ml</td>
                                    <td>A000037</td>
                                    <td>155.00</td>
                                    <td>15.00</td>
                                    <td>2325.00</td>
                                </tr>

                                <tr class="challan_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Challan Total (DC10005000016) :</td>
                                    <td>9.00</td>
                                    <td>3240.00</td>
                                </tr>

                                <tr class="day_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Day Total :</td>
                                    <td>30.00</td>
                                    <td>13325.00</td>
                                </tr>

                                <tr class="store_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Store Total ( Dhaka ) :</td>
                                    <td>123.00</td>
                                    <td>1,08,845.00</td>
                                </tr>

                                <tr class="grand_total">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Grand Total:</td>
                                    <td>123.00</td>
                                    <td>1,08,845.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
   </div>

   <div class="custom-pagination">
        <button id="first"><i class="ri-skip-left-fill"></i></button>
        <button id="prev"><i class="ri-arrow-drop-left-fill"></i></button>

        <span id="pageInfo">
            <input type="number" id="pageInput" min="1" value="1">  / <span id="totalPages">1</span>
        </span>

        <button id="next"><i class="ri-arrow-drop-right-fill"></i></button>
        <button id="last"><i class="ri-skip-right-fill"></i></button>
    </div>
    
@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Product Search option
            let table = $('.datatables').DataTable({
                pageLength: 20,
                scrollCollapse: true,
                scrollY: 450,
                ordering: false,
                lengthChange: false,
                searching: false,
                paging: true,
                info: false,
                layout: {
                    topStart: null,   // ✅ clean dropdown only
                    topEnd: null,         // ✅ pagination on top right
                    bottomStart: null,          // ❌ remove "Showing entries"
                    bottomEnd: null             // ❌ remove bottom pagination
                },
            });
       

        // 👉 Update Page Info
            function updatePageInfo() {
                let info = table.page.info();

                $('#pageInput').val(info.page + 1); // current page
                $('#totalPages').text(info.pages);  // total pages
            }

            $('#pageInput').on('keydown', function (e) {
                if (e.key === 'Enter') {

                    let info = table.page.info();
                    let inputPage = parseInt($(this).val());

                    // ❌ invalid input
                    if (isNaN(inputPage)) {
                        inputPage = 1;
                    }

                    // ❌ less than 1
                    if (inputPage < 1) {
                        inputPage = 1;
                    }

                    // ❌ greater than last page
                    if (inputPage > info.pages) {
                        inputPage = info.pages;
                    }

                    // 👉 go to page (DataTables is 0-based)
                    table.page(inputPage - 1).draw('page');
                }
            });

            // 👉 Button Actions
            $('#first').on('click', function () {
                table.page('first').draw('page');
            });

            $('#prev').on('click', function () {
                table.page('previous').draw('page');
            });

            $('#next').on('click', function () {
                table.page('next').draw('page');
            });

            $('#last').on('click', function () {
                table.page('last').draw('page');
            });

            // 👉 Update on draw
            table.on('draw', function () {
                updatePageInfo();
            });

            // 👉 Initial load
            updatePageInfo();

            function updateButtons() {
                let info = table.page.info();

                $('#first, #prev').prop('disabled', info.page === 0);
                $('#next, #last').prop('disabled', info.page === info.pages - 1);
            }

            table.on('draw', function () {
                updatePageInfo();
                updateButtons();
            });
        });
    </script>
@endpush

