@extends('admin.layout.master')

@push('add-title')
    Invoice Wise Sale
@endpush


@push('add-css')
    <link href="{{ asset('public/admin/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
        label{
            font-size: 12px;
            cursor: pointer;
            display: block;
        }
        .header{
            display: none;
        }
        .report_type{
            position: relative;
            border: 2px solid #cfcfcf;
            padding: 25px 45px;
        }
        .report_list{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 24px 0px;
        }
        .report_type span{
            position: absolute;
            top: -12px;
            left: 23px;
            background: #F7F7F7;
            padding: 0 10px;
            font-weight: 500;
            color: #5c5c5c;
        }
        .form-check-label{
            font-weight: 800;
            color: #000;
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
        .form-check-input {
            border-color: #86b7fe;
            outline: 0;
        }
        .copyright-footer {
            display: none !important;
        }
        .fs-md{
            font-size: 10px !important;
        }
        .modal-footer {
            padding: .7rem !important;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

    <h2 class="text-center fw-bold mb-5">Invoice Wise Sale</h2>

    <div class="row">
        <div class="col-lg-4 offset-lg-4">
            <div class="mb-4">
                <div class="d-flex align-items-center gap-3">
                    <label for="product" class="d-block text-end">Date</label>
                    <input type="text" id="date" name="date" class="search_field" placeholder="Select date range" />
                </div>
            </div>
        </div>

        <div class="col-lg-8 offset-lg-2">
            <div class="mb-5 report_type">
                <span class="">Report Type</span>

                <div class="report_list">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="summary" value="summary" checked="">
                        <label class="form-check-label" for="summary"> Summary </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="details" value="details">
                        <label class="form-check-label" for="details"> Details </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="user" value="user">
                        <label class="form-check-label" for="user"> User </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="user_summary" value="user_summary">
                        <label class="form-check-label" for="user_summary">User Summary</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="user_paytype" value="user_paytype">
                        <label class="form-check-label" for="user_paytype">User Pay Type</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="terminal" value="terminal">
                        <label class="form-check-label" for="terminal">Terminal</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="terminal_paytype" value="terminal_paytype">
                        <label class="form-check-label" for="terminal_paytype">Terminal Pay Type</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="pending_sale_item" value="pending_sale_item">
                        <label class="form-check-label" for="pending_sale_item">Pending Sale Item</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="exchange" value="exchange">
                        <label class="form-check-label" for="exchange">Exchange</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="invoice_wise" id="return" value="return">
                        <label class="form-check-label" for="return">Return</label>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#emptyModal">Show</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#closeModal">Close</button>
            </div>
        </div>
    </div>

    <!-- No data found Modal Modal -->
    <div id="emptyModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50">
                        <p class="fw-bold">No Data Found!!</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect me-3"  data-bs-dismiss="modal">Okk</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Close Modal -->
    <div id="closeModal" class="modal effect-scale fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Reprint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('public/admin/assets/images/question_mark.png') }}" alt="" width="50" style="-webkit-user-drag: none;">
                    <p class="fw-bold">Are you sure do you want to exit.</p>
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

@endsection

@push('add-js')
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>
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
                    autoUpdateInput: true,
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'D-MMM-YYYY'
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
                    $(this).val(picker.startDate.format('D-MMM-YYYY') + ' To ' + picker.endDate.format('D-MMM-YYYY'));
                });

                $(selector).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            
                cb(start, end);
            }
            // Initialize both inputs
            initDateRangePicker('#date', "auto");



            $(document).on('click', '#closePage', function () {
                window.location.href = "{{ route('admin.dashboard') }}";
            });
        });
    </script>

@endpush

