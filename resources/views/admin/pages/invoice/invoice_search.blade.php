@extends('admin.layout.master')

@push('add-title')
    Invoice Search
@endpush


@push('add-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
        label{
            font-size: 12px;
            cursor: pointer;
            display: block;
        }
        .search_field{
            color: #000;
            font-size: 0.9rem;
            font-weight: 500;
            width: 100%;
            height: 28px;
            border: 1px solid #dfdfdf;
            padding: 0px 9px;
            border-bottom: 2px solid #9b9797;
            border-radius: 4px;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
        }
        .search_field:focus{
            border-bottom: 2px solid #86b7fe;
        }
        .form-select {
            height: 34px;
            border: 2px solid #9b9797;
        }
        .heading_border{
            border-bottom: 2px solid #092C4C;
        }
        .card .card-body {
            height: 100vh;
        }
        .table_customs thead tr th,
        .table_customs tbody tr td{
            color: #000;
            font-weight: 700;
            font-size: 11px;
            cursor: pointer;
        }
        .table_customs thead tr{
            border-bottom: 1px solid #000;
        }
        .table_customs tbody tr:hover td {
            background-color: #0078D7 !important;
            color: #fff;
        }
        .table td {
            padding: 4px 10px !important;
        }

    </style>
@endpush

{{-- Active sidebar --}}
@section('invoice_search', 'active')


@section('body-content')

   <div class="row">
        <div class="col-lg-3">
           <div class="card">
               <div class="card-body">
                     <h2 class="mb-3 heading_border pb-1">Search Options</h2>
                    <div class="mb-2">
                        <label for="cus_id" class="mb-1">Customer ID</label>
                        <input type="text" name="cus_id" class="search_field" id="cus_id" >
                    </div>

                    <div class="mb-2">
                        <label for="cus_name" class="mb-1">Customer Name</label>
                        <input type="text" name="cus_name" class="search_field" id="cus_name" >
                    </div>
                    
                    <div class="mb-2">
                        <label for="cus_phone" class="mb-1">Mobile Number</label>
                        <input type="text" name="cus_phone" class="search_field" id="cus_phone" >
                    </div>

                    <div class="mb-2">
                        <label for="invoice_date" class="mb-1">Invoice Date Range</label>
                        <input type="text" name="invoice_date" class="search_field" id="invoice_date" placeholder="Select Date Range" />
                    </div>

                    <div class="mb-2">
                        <label for="invoice_number" class="mb-1">Invoice No.</label>
                        <input type="text" name="invoice_number" class="search_field" id="invoice_number" >
                    </div>

                    <div class="mb-2">
                        <label for="admin_user" class="mb-1">User</label>
                        <select class="form-select" name="admin_user" id="admin_user">
                            <option value="all" selected>-- All --</option>
                            <option value="nazmul-10693">Nazmul-10693</option>
                            <option value="safi-10667">Safi-10667</option>
                            <option value="ashik-10667">Ashik-10667</option>
                            <option value="zubair-10667">Zubair-10667</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="terminal" class="mb-1">Terminal</label>
                        <select class="form-select" name="terminal" id="terminal">
                            <option value="all" selected>-- All --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-danger">Reset</button>
                        <button type="button" class="btn btn-secondary">Search</button>
                    </div>
               </div>
           </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-3 text-center">Invoice Search <span class="invoice_count">(2)</span></h2>

                    {{-- Main table content --}}
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="table-responsive">
                                <table class="table_customs table-bordered table mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Invoice No.</th>
                                            <th>Date</th>
                                            <th>Total Item</th>
                                            <th>Net Amount.</th>
                                            <th>Print</th>
                                            <th>Preview</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>0126022200009</td>
                                            <td>22-Feb-2026</td>
                                            <td>1.000</td>
                                            <td>285.00</td>
                                            <td><button type="button" class="btn btn-sm btn-secondary">Reprint</button></td>
                                            <td><button type="button" class="btn btn-sm btn-secondary">Preview</button></td>
                                        </tr>
                                        <tr>
                                            <td><i class="ti ti-arrow-big-right"></i></td>
                                            <td>0126022200010</td>
                                            <td>18-Feb-2026</td>
                                            <td>5.000</td>
                                            <td>732.00</td>
                                            <td><button type="button" class="btn btn-sm btn-secondary">Reprint</button></td>
                                            <td><button type="button" class="btn btn-sm btn-secondary">Preview</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>

@endsection

@push('add-js')
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

    <script>
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
            initDateRangePicker('#invoice_date', "auto");
        });
    </script>
@endpush
