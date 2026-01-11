@extends('admin.layout.master')

@push('title')
    Order Checkout
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <link href="{{ asset('public/admin/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
        }
        .caption_head{
            font-size: 13px;
            display: block;
        }
        h5{
            font-size: 15px;
            line-height: 24px;
        }
        .form-check-input {
            border: 1px solid #000;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Order Checkout</h4>
                {{-- <h6>Manage your Faqs</h6> --}}
            </div>
        </div>

        <div class="page-btn">
            <a href="#" class="btn btn-primary">Back</a>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="mb-1 caption_head">Customer Name</span>
                        <h5>Nazmul Hassan <span class="badge badge-sm bg-primary">Regular</span></h5>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Phone Number</span>
                        <h5>+8801542695148</h5>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Customer Address</span>
                        <h5>Ranks Business Centre, Plot-Ka-218/1-2, Pragati Sarani Main Road, Kuril, Dhaka-1229</h5>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="mb-1 caption_head">Delivery Address</span>
                        <h5>Ranks Business Centre, Plot-Ka-218/1-2, Pragati Sarani Main Road, Kuril, Dhaka-1229</h5>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Shipping Date</span>
                        <h5>Jan 01,2026 10:12 A.M</h5>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Pickup Location</span>
                        <h5>Banasree Warehouse</h5>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Preferred Delivery Partner</span>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" width="20" style="border-radius: 50px;"> 
                            <h5>Steadfast</h5>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="mb-1 caption_head">Order Source</span>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="20" style="border-radius: 50px;"> 
                            <h5>Whatsapp</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                {{-- Table Part Start --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>#SL.</th>
                                    <th>Details</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" alt="" width="85">
                                                <div class="">
                                                   <h4 class="mb-2">সুন্দরবনের মধু/Sundarban Honey</h4>
                                                   <p class="mb-1"><strong>SKU:</strong> A000251</p>
                                                   <div class="d-flex align-items-center gap-2">
                                                       <h5>BDT 1550.00</h5>
                                                       <del>
                                                         <h5>BDT 1700.00</h5>
                                                       </del>
                                                   </div>

                                                   <div class="d-flex align-items-center gap-3">
                                                       <p class="m-0"><strong><span>Qty:</span> 2</strong></p>
                                                       <p class="m-0"><strong><span>Weight:</span> 1Kg</strong></p>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <h5 class="text-dark m-0">BDT 3100.00</h5>
                                        <del><h5 class="text-dark m-0">BDT 3400.00</h5></del>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">SubTotal<span/>
                                    </td>
                                    <td><span class="text-dark">BDT 3100.00</span></strong></td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">(-) Discount</span>
                                    </td>
                                    <td>
                                        <strong>
                                            <span class="text-danger">- BDT 200.00</span>
                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">Delivery Fee</span>
                                    </td>
                                    <td><strong><span class="text-success">BDT 130.00</span></strong></td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">(-) Advance Payment</span>
                                    </td>
                                    <td><strong><span class="text-danger">BDT 200.00</span></strong></td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <span style="font-weight: 700; color: #000;">Total Received</span>
                                    </td>
                                    <td><strong><span class="text-dark">BDT 2830.00</span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                {{-- /Table Part End --}}

                    <div class="form-check form-check-md d-flex align-items-center justify-content-end mb-3 mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="checkebox-md">
                        <label class="form-check-label" for="checkebox-md">
                            <h5 class="m-0">Auto-Approve Status</h5>
                        </label>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary">Placed Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('add-js')
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

@endpush