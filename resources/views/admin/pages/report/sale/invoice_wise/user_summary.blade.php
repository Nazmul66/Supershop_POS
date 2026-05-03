@extends('admin.layout.master')

@push('add-title')
    Summary - Invoice Wise Sale
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
        .datatables thead{
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }
        .datatables td {
            vertical-align: top;
            padding: 3px 10px !important;
        }
        .datatables thead tr th{
            font-size: 11px;
            font-weight: 900;
            color: #212B36;
            background: transparent;
            padding: 6px 10px !important;
        }
        .datatables tbody tr:hover td {
            background: #2f91a1;
            color: #FFF;
            cursor: pointer;
        }
        .datatables tbody tr td{
            font-size: 11px;
            font-weight: 600;
            color: #212B36;
            border: 1px solid transparent; 
        }
        .datatables tbody tr td.highlight{
            color: #373796;
            font-weight: 700;
        }
        .datatables tbody tr:hover td.highlight{
            color: #FFF;
        }
        .datatables tbody tr.grandTotal td{
            font-weight: 700;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: start;
        }
        .datatables tbody tr.grandTotal td.highlight{
            color: #840704;
        }
        table.datatables {
            table-layout: fixed;
            width: 100%;
        }
        .datatables th:nth-child(1),
        .datatables td:nth-child(1) {
            width: 140px !important;
            max-width: 140px;
            white-space: normal;        
            word-break: break-word;    
            overflow-wrap: anywhere;    
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
            position: relative;
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
        .text-end {
            text-align: right;
        }
        .report_view_structure .foote_body{
            position: absolute;
            bottom: 15px;
            left: 0;
            padding: 0 28px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .foote_body span{
            font-size: 12px;
            font-weight: 800;
            color: #000;
        }
        .card_wise_breakdown{
            margin: auto;
        }
        .card_wise_breakdown .card_wise tbody{
            font-size: 11px;
        }
        .card_wise_breakdown .card_wise thead tr th{
            font-size: 13px;
            background: transparent;
            border: 1px solid #000;
            font-weight: 800;
        }
        .card_wise_breakdown .card_wise tbody tr td{
            font-size: 11px;
            border: 1px solid #000;
            color: #000;
            font-weight: 600;
        }
        .card_wise_breakdown .card_wise tbody tr.total_card_wise td{
            font-size: 11px;
            font-weight: 800;
            color: #000;
            border: 1px solid #000;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

   <div class="report_view_structure">
        <h2 class="text-center fw-bold mb-1">Ghorer Bazar</h2>
        <h4 class="text-center fw-bold mb-1">Metro Shewrapara</h4>
        <h4 class="text-center fw-bold mb-1">CASHIER WISE SUMMARY REPORT</h4>
        <p class="text-center fw-bold mb-0">From: <strong class="fw-bold text-dark">18-Feb-2026 08:00:00 AM</strong> To: <strong class="fw-bold text-dark">21-Feb-2026 11:59:59 PM</strong></p>

        <div class="row">
            {{-- Show Search Product Data --}}
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 datatables">
                            <thead>
                                <tr>
                                    <th>USER NAME</th>
                                    <th>VALUE</th>
                                    <th>DISC AMT</th>
                                    <th>SP DISC</th>
                                    <th>SD AMT</th>
                                    <th>VAT AMT</th>
                                    <th>EXG AMT</th>
                                    <th>RTN AMT</th>
                                    <th>CASH AMT</th>
                                    <th>CARD AMT</th>
                                    <th>NET AMT</th>
                                    <th>ADJ AMT</th>
                                    <th>RDM_VAL</th>
                                    <th>RTN DISC</th>
                                    <th>RTN SP DISC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="highlight">Anisur-10701</td>
                                    <td>42,750.00</td>
                                    <td class="highlight">3,747.75</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td class="highlight">2,691.74</td>
                                    <td class="highlight">0.00</td>
                                    <td class="highlight">0.00</td>
                                    <td class="highlight">26,313.00</td>
                                    <td class="highlight">12,690.00</td>
                                    <td class="highlight">39,003.00</td>
                                    <td class="highlight">0.75</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td class="highlight">Nazmul-10693</td>
                                    <td>25,660.00</td>
                                    <td class="highlight">1,969.25</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td class="highlight">1,630.71</td>
                                    <td class="highlight">0.00</td>
                                    <td class="highlight">0.00</td>
                                    <td class="highlight">10,306.00</td>
                                    <td class="highlight">13,395.00</td>
                                    <td class="highlight">23,701.00</td>
                                    <td class="highlight">0.25</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                </tr>

                                <tr class="grandTotal">
                                    <td>TOTAL</td>
                                    <td>68,410.00</td>
                                    <td class="highlight">5707.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td class="highlight" >4322.45</td>
                                    <td>0.00</td>
                                    <td class="highlight">0.00</td>
                                    <td class="highlight">36,619.00</td>
                                    <td class="highlight">26,085.00</td>
                                    <td class="highlight">62,704.00</td>
                                    <td class="highlight">1.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="text-center fw-bold mt-5 mb-1">CARD WISE BREAKDOWN</h4>

                        <div class="card_wise_breakdown" style="width: 40%;">
                            <table class="table card_wise mb-0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-end">Bkash (Merchant)</th>
                                        <th class="text-end">City Bank</th>
                                        <th class="text-end">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">Anisur-10701</td>
                                        <td class="text-end">5,170.00</td>
                                        <td class="text-end">7,520.00</td>
                                        <td class="text-end">12,693.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Nazmul-10701</td>
                                        <td class="text-end">7,070.00</td>
                                        <td class="text-end">6,325.00</td>
                                        <td class="text-end">13,395.00</td>
                                    </tr>
                                    <tr class="total_card_wise">
                                        <td class="text-start">TOTAL</td>
                                        <td class="text-end">12,240.00</td>
                                        <td class="text-end">13,845.00</td>
                                        <td class="text-end">26,085.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="foote_body">
                        <span>System By: Mediasoft Data System Ltd</span>
                        <span id="pageInfo">Page 1 of 1</span>
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
                scrollY: 300,
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
                columnDefs: [
                    { targets: '_all', defaultContent: '' }
                ],
                createdRow: function (row) {
                    if ($(row).hasClass('payment-summary-row')) {
                        $(row).addClass('not-data');
                    }
                }
            });
       

        // 👉 Update Page Info
            function updatePageInfo() {
                let info = table.page.info();

                let currentPage = info.page + 1;
                let totalPages = info.pages;

                $('#pageInput').val(info.page + 1); // current page
                $('#totalPages').text(info.pages);  // total pages

                // 👉 update footer text
                $('#pageInfo').text(`Page ${currentPage} of ${totalPages}`);
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

