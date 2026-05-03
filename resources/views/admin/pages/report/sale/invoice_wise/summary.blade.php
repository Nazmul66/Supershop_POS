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
        .table tbody tr.invoice_date td{
            color: #0926b3;
            font-weight: 800;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: start;
        }
        .table tbody tr.subTotal_day_invoice td{
            color: #484CA5;
            font-weight: 700;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: start;
        }
        .table tbody tr.grandTotal td{
            color: #840704;
            font-weight: 700;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000 !important;
            text-align: start;
        }
        .table tbody tr.invoice_date:hover td{
            color: #FFF;
        }
        /* .table tbody tr:hover td{
            background: #2f91a1;
            color: #FFF;
            cursor: pointer;
        } */
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
        .datatables th:nth-child(12),
        .datatables td:nth-child(12) {
            width: 70px !important;
            max-width: 70px;
            white-space: normal;        
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



        .payment-summary-row td {
            padding: 20px 0 !important;
            border: none !important;
        }

        .payment-box {
            width: 850px;
            margin: auto; /* right align like your image */
            border: 2px solid #000;
            padding: 10px 15px;
            background: #fff;
        }
        .payment_history{
            width: 55%;
            max-width: 100%;
            margin-left: auto;
        }

        .payment-inner-table {
            width: 100%;
            border-collapse: collapse;
        }
        /* .payment-inner-table tr{
            background: transparent !important;
            border-bottom: 2px solid #000 !important;
        } */

        .payment-inner-table tr .payment_th {
            font-size: 12px;
            font-weight: 900 !important;
            background: transparent !important;
            border-bottom: 2px solid #000 !important;
            text-align: left;
            white-space: nowrap !important;
            padding: 3px !important;
        }

        .payment-inner-table tr .payment_td{
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap !important;
            padding: 4px 0 !important;
        }
        .payment-inner-table tr.total-row .payment_td{
            border-top: 2px solid #000 !important;
        }

        .text-end {
            text-align: right;
        }

        .total-row td {
            border-top: 2px solid #000;
            padding-top: 6px;
            font-weight: bold;
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
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

   <div class="report_view_structure">
        <h2 class="text-center fw-bold mb-1">Ghorer Bazar</h2>
        <h4 class="text-center fw-bold mb-1">Metro Shewrapara</h4>
        <h4 class="text-center fw-bold mb-1">INVOICE WISE SALE REPORT (SUMMARY)</h4>
        <p class="text-center fw-bold mb-0">From: <strong class="fw-bold text-dark">18-Feb-2026 08:00:00 AM</strong> To: <strong class="fw-bold text-dark">21-Feb-2026 11:59:59 PM</strong></p>

        <div class="row">
            {{-- Show Search Product Data --}}
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 datatables">
                            <thead>
                                <tr>
                                    <th>INVOICE NO</th>
                                    <th>VALUE</th>
                                    <th>DISC AMT</th>
                                    <th>SP DISC</th>
                                    <th>SD AMT</th>
                                    <th>VAT AMT</th>
                                    <th>RTN AMT</th>
                                    <th>ADJ AMT</th>
                                    <th>NET AMT</th>
                                    <th>CASH AMT</th>
                                    <th>CARD AMT</th>
                                    <th>CARD NAME</th>
                                    <th>RDM_VAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="invoice_date">
                                    <td>16-Feb-2026</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td>0126021600001</td>
                                    <td>1300.00</td>
                                    <td>130.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>81.63</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>1170.00</td>
                                    <td>0.00</td>
                                    <td>1170.00</td>
                                    <td>City Bank</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600002</td>
                                    <td>155.00</td>
                                    <td>7.75</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>7.01</td>
                                    <td>0.00</td>
                                    <td>-0.25</td>
                                    <td>147.00</td>
                                    <td>147.00</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600003</td>
                                    <td>1300.00</td>
                                    <td>130.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>81.63</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>1170.00</td>
                                    <td>0.00</td>
                                    <td>1170.00</td>
                                    <td>City Bank</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600004</td>
                                    <td>4200.00</td>
                                    <td>420.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>263.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>City Bank</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600005</td>
                                    <td>5325.00</td>
                                    <td>470.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>338.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>4855.00</td>
                                    <td>855.00</td>
                                    <td>4000.00</td>
                                    <td>Bkash (Merchant)</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600004</td>
                                    <td>4200.00</td>
                                    <td>420.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>263.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>City Bank</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600005</td>
                                    <td>5325.00</td>
                                    <td>470.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>338.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>4855.00</td>
                                    <td>855.00</td>
                                    <td>4000.00</td>
                                    <td>Bkash (Merchant)</td>
                                    <td>0.00</td>
                                </tr>


                                <tr>
                                    <td>0126021600004</td>
                                    <td>4200.00</td>
                                    <td>420.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>263.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>0.00</td>
                                    <td>3780.00</td>
                                    <td>City Bank</td>
                                    <td>0.00</td>
                                </tr>

                                <tr>
                                    <td>0126021600005</td>
                                    <td>5325.00</td>
                                    <td>470.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>338.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>4855.00</td>
                                    <td>855.00</td>
                                    <td>4000.00</td>
                                    <td>Bkash (Merchant)</td>
                                    <td>0.00</td>
                                </tr>

                                <tr class="subTotal_day_invoice">
                                    <td></td>
                                    <td>5325.00</td>
                                    <td>470.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>338.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>4855.00</td>
                                    <td>855.00</td>
                                    <td>4000.00</td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>

                                <tr class="grandTotal">
                                    <td>GRAND TOTAL</td>
                                    <td>5325.00</td>
                                    <td>470.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>338.72</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>4855.00</td>
                                    <td>855.00</td>
                                    <td>4000.00</td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>

                                <tr class="payment-summary-row">
                                    <td colspan="13">
                                        <div class="payment-box">
                                            <div class="payment_history">
                                                <table class="payment-inner-table">
                                                    <tr>
                                                        <th class="payment_th">PAYMENT TYPE</th>
                                                        <th class="text-end payment_th">AMOUNT</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="payment_td">CASH</td>
                                                        <td class="text-end payment_td">36,619.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="payment_td">Bkash (Merchant)</td>
                                                        <td class="text-end payment_td">12,240.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="payment_td">City Bank</td>
                                                        <td class="text-end payment_td">13,845.00</td>
                                                    </tr>
                                                    <tr class="total-row">
                                                        <td class="payment_td"></td>
                                                        <td class="text-end payment_td fw-bolder">62,704.00</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                scrollY: 420,
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

