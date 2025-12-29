@extends('admin.layout.master')

@push('title')
    Order Details
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
        }
        h5{
            font-size: 16px;
            font-weight: 700;
            color: #666;
        }
        .ti-chevron-left,
        .ti-chevron-right{
            border: 2px solid #092C4C;
            padding: 5px;
            background: #F9FAFB;
            border-radius: 4px;
            cursor: pointer;
        }
        .ti-info-circle{
            font-size: 20px; 
            cursor: pointer;
        }
        .additional_box{
            position: relative;
        }
        .additional_box .btn_note{
            position: absolute;
            top: -38px;
            right: 0;
        }
        #copyNumber i{
           font-size: 22px;
        }
        .table thead tr th,
        .table tbody tr td{
            font-size: 12px !important;
        }
        .order_status option[value="pending"] {
           color: #000; 
        }
        .order_status option[value="hold"] {
            color: #FE9F43;
        }

        .order_status option[value="cancel"] {
            color: #dc3545; 
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
        .payment_action{
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #66667A;
            border-radius: 50px;
            cursor: pointer;
        }
        .payment_action .ti-plus{
            font-size: 16px;
        }
        .user_icon{
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            background: #b7cff6;
            margin: 0 auto 12px;
        }
        .user_icon .ti-credit-card{
            font-size: 30px;
            color: #212B36;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('faq', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Order Details</h4>
                <h6>Manage your Faqs</h6>
            </div>
        </div>

        <div class="page-btn">
            <a href="#" class="btn btn-primary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Left Column Start --}}
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-4">
                        <p class="badge badge-xl bg-soft-info my-1 me-2">
                            <span id="copyName">GB-4658</span> <span id="copyId" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success ms-2" style="cursor: pointer;"><i class="ti ti-copy"></i></span>
                        </p>

                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#orderModal">
                              Pending
                            </a>
                        </div>

                        <div class="ms-3">
                            <i class="ti ti-chevron-left" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Previous"></i>

                            <i class="ti ti-chevron-right" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Next"></i>
                        </div>
                    </div>

                    <p class="mb-2"><strong>Shipping Date :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>Follow Up Date :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>On Hold Reason :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>Cancelled Reason :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>Auto approve date :</strong> Dec 12-2025 09:10 P.M</p>
                    <div class="mb-2 d-flex align-items-center gap-1"><strong>Assign to delivery partner :</strong> <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" width="20"> Steadfast </div>
                    <div class="mb-2 d-flex align-items-center gap-1"><strong>Source :</strong>  Website <img src="{{ asset('public/admin/assets/img/logo-small.png') }}" alt="" width="20"> </div>
                    <p class="mb-2"><strong>Delivery Type :</strong> Regular / New</p>
                    <p class="mb-2"><strong>Source Info :</strong> https://ghorerbazar.com/collections/dates</p>
                    <p class="mb-4"><strong>Delivery Note :</strong> dgdfgsdfdfds sddsfsd sdfsdfsdf sdfsdfsf</p>
                    <p class="mb-2"><strong>Internal Note :</strong></p>
                    <div class="additional_box">
                        <textarea name="" class="form-control" id="additional_form" cols="30" rows="4" disabled></textarea>
                        <div class="btn_note">
                            <button class="btn btn-square btn-secondary">Add Note</button>
                        </div>
                    </div>
                </div>
                {{-- /Left Column End --}}


                {{-- Right Column Start --}}
                <div class="col-lg-4 offset-lg-4 text-end">
                    <div class="d-flex align-items-center justify-content-end gap-1 mb-2">
                        <i class="ti ti-info-circle text-info"></i>
                        <h2>Mahtab</h2>
                    </div>
                    <p class="badge badge-sm bg-primary mb-2">New</p>

                    <div class="d-flex align-items-center justify-content-end mb-2">
                        <a href="https://wa.me/01833220886" target="_blank">
                            <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="20">
                        </a>
                        <span id="copyNumber" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success ms-2" style="cursor: pointer;"><i class="ti ti-copy"></i></span>
                        <strong><span id="copyText" class="ms-2">+8801833220886</span></strong>
                    </div>

                    <p class="mb-3">53, kazi nazrul islam avenue, kawran bazar, 1215, Dhaka</p>

                    <div class="d-flex align-items-center justify-content-end gap-3 mb-2">
                        <h5 class="mb-0">Pick Up Location</h5>
                        <span class="badge bg-soft-secondary">Warehouse</span>
                    </div>

                    <p class="mb-3">Banasree Warehouse (1055)</p>

                    <div class="d-flex align-items-center justify-content-end gap-3 mb-2">
                        <h5 class="mb-0">Drop Off Location</h5>
                        <span class="badge bg-soft-secondary">Billing</span>
                    </div>
                     
                    <p class="mb-3">1306/1, east monipur (rokeya villa), mirpur, 1218, Dhaka</p>
                </div>
                {{-- /Right Column End --}}


                {{-- Table Part Start --}}
                <div class="mt-5">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Sku</th>
                                    <th>Image</th>
                                    <th>
                                        <span style="text-wrap: auto;">
                                            Product Name
                                        </span>
                                    </th>
                                    <th>Weight / Unit</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Requested Qty</th>
                                    <th>total Weight / Unit</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A000268</td>
                                    <td>
                                        <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" width="20">
                                    </td>
                                    <td>
                                        <span style="text-wrap: auto;">
                                            Safawi/kalmi Dates (A Grade) 1kg
                                        </span>
                                    </td>
                                    <td>1 kg</td>
                                    <td>BDT 750</td>
                                    <td>BDT 686.25 (8.5%)</td>
                                    <td>3</td>
                                    <td>3 kg</td>
                                    <td>BDT 2058.75 <del class="ms-1">BDT 2250</del></td>
                                </tr>
                                <tr>
                                    <td>A000268</td>
                                    <td>
                                        <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" width="20">
                                    </td>
                                    <td>
                                        <span style="text-wrap: auto;">
                                            Safawi/kalmi Dates (A Grade) 1kg
                                        </span>
                                    </td>
                                    <td>1 kg</td>
                                    <td>BDT 750</td>
                                    <td>BDT 686.25 (8.5%)</td>
                                    <td>3</td>
                                    <td>3 kg</td>
                                    <td>BDT 2058.75 <del class="ms-1">BDT 2250</del></td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">SubTotal</span>
                                    </td>
                                    <td>6</td>
                                    <td>6 kg</td>
                                    <td>BDT 4117.5</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">(-) Discount</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>- BDT 00.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">Delivery Fee</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>BDT 130.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">(-) Advance Payment</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td sty>- BDT 200.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">Total Received</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="text-success">BDT 4047.00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- /Table Part End --}}

                <div class="text-end mt-5 mb-5">
                    <button type="button" class="btn btn-secondary" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#add_payment">Add Payment</button>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment History <sup class="badge bg-soft-info">In Processing...</sup></h4>
                </div>

                <div class="card-body">
                    {{-- <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Payment Type</th>
                                    <th>
                                        <span style="text-wrap: auto;">
                                           Note
                                        </span>
                                    </th>
                                    <th>Payment Method</th>
                                    <th>Transaction</th>
                                    <th>Updated At</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Advance</td>
                                    <td>
                                        <span style="text-wrap: auto;">
                                            Safawi/kalmi Dates (A Grade) 1kg
                                        </span>
                                    </td>
                                    <td>Cash On Delivery</td>
                                    <td>Trans-154645564</td>
                                    <td>25 Dec 2025, 09:10 A.M</td>
                                    <td>BDT 750</td>
                                    <td>
                                        <div class="payment_action">
                                            <i class="ti ti-plus"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">SubTotal</span>
                                    </td>
                                    <td colspan="2">BDT 4047.00</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">Total Owing</span>
                                    </td>
                                    <td colspan="2">BDT 4047.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}

                    <div class="">
                        <div class="user_icon">
                            <i class="ti ti-credit-card"></i>
                        </div>
                        <p class="text-center mb-2">No Payment History</p>
                    </div>
                </div>
            </div>


            <!-- Order Status Modal -->
            <div id="orderModal" class="modal fade effect-flip-vertical" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
            style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Order Status</h5>
                            <button type="button" class="btn-close" id="btn_cross" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                        </div>

                        <div class="modal-body">
                            <form id="createForm" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="order_status" class="form-label">Order Status <span class="text-danger">*</span></label>

                                    <select class="form-select order_status" id="order_status" name="order_status">
                                        <option value="pending" selected><strong>Pending</strong></option>
                                        <option value="hold"><strong>On Hold</strong></option>
                                        <option value="cancel"><strong>Cancelled</strong></option>
                                    </select>

                                    <span id="holiday_name_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="mb-3 hold_status_reason d-none">
                                    <label class="form-label" for="hold_status_reason">Select On Hold Status </label>
                                    <select class="form-select" id="hold_status_reason" name="hold_status_reason">
                                        <option value="">Select Option</option>
                                        <option value="can_not_answer">Can not answer </option>
                                        <option value="phone_number_unreachable">Phone number unreachable</option>
                                        <option value="pre_order">Pre-order</option>
                                        <option value="out_of_stock">Out of stock</option>
                                        <option value="awaiting_payment_confirm">Awaiting payment confirmation</option>
                                    </select>

                                    <span id="featured_validate" class="text-danger validation-error mt-1"></span>
                                </div>

                                <div class="mb-3 cancel_status_reason d-none">
                                    <label class="form-label" for="cancel_status_reason">Select Cancelled Status </label>
                                    <select class="form-select" id="cancel_status_reason" name="cancel_status_reason">
                                        <option value="">Select Option</option>
                                        <option value="can_not_payment_advanced">Can not payment advanced </option>
                                        <option value="product_unavailable">Product Unavailable</option>
                                        <option value="duplicate_order">Duplicate Order</option>
                                        <option value="payment_failed">Payment Failed</option>
                                        <option value="found_better_price">Found Better Price Elsewhere</option>
                                        <option value="delivery_too_long">Delivery Time Too Long</option>
                                        <option value="payment_failed">Payment Failed</option>
                                        <option value="product_out_of_stock">Product Out of Stock</option>
                                        <option value="ordered_by_mistake">Ordered by Mistake</option>
                                        <option value="changed_my_mind">Changed My Mind</option>
                                        <option value="high_delivery_charge">High Delivery Charge</option>
                                        <option value="other_reason">Other Reason</option>
                                    </select>

                                    <span id="featured_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                                
                                <div class="mb-3 shipping_date d-none">
                                    <label class="form-label" for="reportrange">Shipping Date <span class="text-danger"> *</span></label>

                                    <input type="text" id="shipping_date" name="shipping_date" class="form-control" placeholder="Select date range" readonly disabled="true" />
                                </div>

                                <div class="col-lg-12 approve_status d-none">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" id="approve_status" disabled="true">

                                        <span>Auto-Approve Status</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 approve_date d-none">
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Approve Date <span class="text-danger"> *</span></label>

                                        <input type="text" id="approve_date" name="approve_date" class="form-control" placeholder="Select date range" readonly />
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3"
                                        data-bs-dismiss="modal">Close </button>

                                    <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Save changes</button>
                                </div>
                            </form>
                        </div>


                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>


            <!-- Add Payment Modal -->
            <div id="add_payment" class="modal fade effect-flip-vertical" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
            style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Add Payment</h5>
                            <button type="button" class="btn-close" id="btn_cross" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                        </div>

                        <div class="modal-body">
                            <form id="createForm" enctype="multipart/form-data">
                                @csrf

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="payment_type">Payment Type <span class="text-danger"> *</span></label>

                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value="payment">Payment</option>
                                            <option value="advance_payment">Advance Payment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="payment_method">Payment Method <span class="text-danger"> *</span></label>

                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <option value="cod">Cash On Delivery</option>
                                            <option value="bkash">Bkash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="upay">Upay</option>
                                            <option value="rupali_bank">Rupali Bank</option>
                                            <option value="eastarn_bank">Eastern Bank</option>
                                            <option value="dutch_bank">Dutch Bangla Bank</option>
                                            <option value="brac_bank">Brac Bank</option>
                                            <option value="city_bank">City Bank</option>
                                            <option value="bank_asia">Bank Asia</option>
                                            <option value="mutual_trust">Mutual Trust</option>
                                            <option value="ifici_bank">IFICI Bank</option>
                                            <option value="ucb_bank">UCB Bank</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3 mt-3">
                                        <label class="form-label" for="trans_id">Transaction ID <span class="text-danger"> *</span></label>
                                        <input type="text" id="trans_id" name="trans_id" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3 mt-3">
                                        <label class="form-label" for="cus_number">Amount <span class="text-danger"> *</span></label>
                                        <input type="text" id="cus_number" name="cus_number" class="form-control" placeholder="00.00" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="note">Note</label>
                                        <div class="input-addon-right position-relative">
                                            <textarea name="note" class="form-control" id="note" cols="30" rows="3"></textarea>
                                        </div>
        
                                        <span id="note_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3"
                                        data-bs-dismiss="modal">Close </button>

                                    <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Save changes</button>
                                </div>
                            </form>
                        </div>


                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

        </div>
    </div>
@endsection

@push('add-js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        // select order status option appears
        document.addEventListener('DOMContentLoaded', function () {
            const orderStatus = document.getElementById('order_status');
            const holdReasonBox = document.querySelector('.hold_status_reason');
            const cancelReasonBox = document.querySelector('.cancel_status_reason');
            const shippingDateField = document.querySelector('.shipping_date');
            const autoApproveField = document.querySelector('.approve_status');
            const holdReasonInput = document.getElementById('hold_status_reason');
            const cancelReasonInput = document.getElementById('cancel_status_reason');
            const approveDateBox  = document.querySelector('.approve_date');
            const autoApproveInput = document.getElementById('approve_status');

            function toggleHoldReason() {
                orderStatus.style.color =
                orderStatus.value === 'pending' ? '#000' :
                orderStatus.value === 'hold'    ? '#FE9F43' : '#dc3545';

                if (orderStatus.value === 'hold') {
                    holdReasonBox.classList.remove('d-none');
                    cancelReasonBox.classList.add('d-none');
                    approveDateBox.classList.add('d-none');
                    holdReasonInput.value = "";
                    autoApproveInput.checked = false;
                } 
                else if( orderStatus.value === 'cancel' ){
                    holdReasonBox.classList.add('d-none');
                    cancelReasonBox.classList.remove('d-none');
                    approveDateBox.classList.add('d-none');
                    shippingDateField.classList.add('d-none');
                    autoApproveField.classList.add('d-none');
                    cancelReasonInput.value = "";
                } 
                else {
                    holdReasonBox.classList.add('d-none');
                    cancelReasonBox.classList.add('d-none');
                    approveDateBox.classList.add('d-none');
                    shippingDateField.classList.add('d-none');
                    autoApproveField.classList.add('d-none');
                }
            }

            // On change
            orderStatus.addEventListener('change', toggleHoldReason);

            // On page load (important if "hold" is preselected)
            toggleHoldReason();


            function allReset(){
                orderStatus.style.color = '#000';
                orderStatus.value = 'pending';
                holdReasonBox.classList.add('d-none');
                cancelReasonBox.classList.add('d-none');
                approveDateBox.classList.add('d-none');
                shippingDateField.classList.add('d-none');
                autoApproveField.classList.add('d-none');
                holdReasonInput.value = "";
                cancelReasonInput.value = "";
                autoApproveInput.checked = false;
            }

            document.getElementById('btn_saves').addEventListener('click', allReset);
            document.getElementById('btn_close').addEventListener('click', allReset);
            document.getElementById('btn_cross').addEventListener('click', allReset);
            document.getElementById('orderModal').addEventListener('hidden.bs.modal', allReset);
        });

        // On hold Status select
        document.addEventListener('DOMContentLoaded', function() {
            const holdReasonSelect = document.getElementById('hold_status_reason');
            const shippingDateField = document.querySelector('.shipping_date');
            const autoApproveField = document.querySelector('.approve_status');
            const shippingDateInput = document.getElementById('shipping_date');
            const autoApproveInput = document.getElementById('approve_status');
            const approveDateBox  = document.querySelector('.approve_date');
            const approveDateInput = document.getElementById('approve_date');

            function toggleDependentFields() {
                if (holdReasonSelect.value !== '') {
                    // Show dependent fields
                    shippingDateField.classList.remove('d-none');
                    autoApproveField.classList.remove('d-none');
                    shippingDateInput.removeAttribute('disabled');
                    autoApproveInput.removeAttribute('disabled');

                    if ($(shippingDateInput).data('daterangepicker')) {
                        const picker = $(shippingDateInput).data('daterangepicker');
                        picker.setStartDate(moment());
                        picker.setEndDate(moment());
                    }

                    if ($(approveDateInput).data('daterangepicker')) {
                        const picker = $(approveDateInput).data('daterangepicker');
                        picker.setStartDate(moment());
                        picker.setEndDate(moment());
                    }

                } else {
                    // Hide dependent fields
                    shippingDateField.classList.add('d-none');
                    autoApproveField.classList.add('d-none');
                    shippingDateInput.setAttribute('disabled', true);
                    autoApproveInput.setAttribute('disabled', true);
                    autoApproveInput.checked = false;
                    approveDateBox.classList.add('d-none');
                }
            }

            // Listen to change event
            holdReasonSelect.addEventListener('change', toggleDependentFields);

            // Run on page load in case a value is preselected
            toggleDependentFields();

        });


        // On Auto Approve daterange
        document.addEventListener('DOMContentLoaded', function() {
            const approveCheckbox = document.getElementById('approve_status');
            const approveDateBox  = document.querySelector('.approve_date');
            const approveDateInput = document.getElementById('approve_date');

            function toggleApproveDate() {
                if (approveCheckbox.checked) {
                    approveDateBox.classList.remove('d-none');
                    approveDateInput.disabled = false;
                } else {
                    approveDateBox.classList.add('d-none');
                    approveDateInput.disabled = true;
                    approveDateInput.value = '';

                    if ($(approveDateInput).data('daterangepicker')) {
                        const picker = $(approveDateInput).data('daterangepicker');
                        picker.setStartDate(moment());
                        picker.setEndDate(moment());
                    }
                }
            }

            // Listen to checkbox change
            approveCheckbox.addEventListener('change', toggleApproveDate);

            // Initial state on page load
            toggleApproveDate();

        });
        

    </script>

    <script type="text/javascript">
        $(function() {
        
            function initDateRangePicker(selector, up){

            
                var start = moment().subtract(29, 'days');
                var end = moment();
            
                function cb(start, end) {
                    $(selector).find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            
                $(selector).daterangepicker({
                    timePicker: true,
                    drops: up,
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
            
                cb(start, end);
            }

            // Initialize both inputs
            initDateRangePicker('#shipping_date', "down");
            initDateRangePicker('#approve_date', "up");
        });
    </script>

<script>
    // Copy Order Id function
    document.getElementById('copyId').addEventListener('click', function () {
        const copyText = document.getElementById('copyName').innerText;
        const iconWrapper = this;

        // Copy to clipboard
        navigator.clipboard.writeText(copyText).then(() => {
            // Change icon to check
            this.setAttribute("data-bs-original-title", "Copied!");
            iconWrapper.innerHTML = '<i class="ti ti-checks"></i>';

            // Revert back after 3 seconds
            setTimeout(() => {
                this.setAttribute("data-bs-original-title", "Copy");
                iconWrapper.innerHTML = '<i class="ti ti-copy"></i>';
            }, 1000);
        }).catch(error => {
            console.error('Copy failed:', error);
        });
    });

    // Copy Phone Number function
    document.getElementById('copyNumber').addEventListener('click', function () {
        const copyNumber = document.getElementById('copyText').innerText;
        const iconWrappers = this;

        // Copy to clipboard
        navigator.clipboard.writeText(copyNumber).then(() => {
            // Change icon to check
            this.setAttribute("data-bs-original-title", "Copied!");
            iconWrappers.innerHTML = '<i class="ti ti-checks"></i>';

            // Revert back after 3 seconds
            setTimeout(() => {
                this.setAttribute("data-bs-original-title", "Copy");
                iconWrappers.innerHTML = '<i class="ti ti-copy"></i>';
            }, 1000);
        }).catch(error => {
            console.error('Copy failed:', error);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('additional_form');
        const btnContainer = document.querySelector('.btn_note');

        // Initial Add Note click
        btnContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-secondary')) {
                enableNote();
            }

            if (e.target.closest('.btn-danger')) {
                cancelNote();
            }

            if (e.target.closest('.btn-success')) {
                saveNote();
            }
        });

        function enableNote() {
            textarea.removeAttribute('disabled');
            textarea.setAttribute('placeholder', 'Write here...');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-danger">Cancel</button>
                <button type="button" class="btn btn-square btn-success ms-2">Save</button>
            `;
        }

        function cancelNote() {
            textarea.value = '';
            textarea.setAttribute('disabled', true);
            textarea.removeAttribute('placeholder');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-secondary">Add Note</button>
            `;
        }

        function saveNote() {
            textarea.setAttribute('disabled', true);

            // 🔹 Add AJAX / form submit here if needed

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-secondary">Add Note</button>
            `;
        }
    });
</script>
@endpush