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
        .form-check-input[type=radio],
        .form-check-input[type=checkbox]{
            border: 1px solid #646363 !important;
        }
        .form-check-input[type=radio]:focus,
        .form-check-input[type=checkbox]:focus {
            border: 1px solid #FE9F43 !important;
        }
        .form-check-input[type=radio]:checked,
        .form-check-input[type=checkbox]:checked {
            border: 1px solid #FE9F43 !important;
        }
        .form-check-input[type=checkbox] {
            border-radius: 0px;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title d-flex align-items-center gap-2">
                <button class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Back">
                    <i class="ti ti-arrow-back-up" style="font-size: 24px;"></i>
                </button>
                <h4 class="fw-bold mb-0">Invoice Print</h4>
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
                        <label for="" class="form-label">POS Type</label>
    
                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="pos_sticker" value="pos_sticker" checked>
                                <label class="form-check-label" for="pos_sticker">
                                    POS Sticker
                                </label>
                            </div>
    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="rolling_paper" value="rolling_paper">
                                <label class="form-check-label" for="rolling_paper">
                                    3inch Rolling Paper
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="border border-2 px-3 py-2 rounded-3 mb-3">
                        <label for="" class="form-label">Label Size ( Width X Height )</label>
    
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="2_4" value="2_4">
                                <label class="form-check-label" for="2_4">
                                    2x4
                                </label>
                            </div>
    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="3_4" value="3_4">
                                <label class="form-check-label" for="3_4">
                                    3x4
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="4_4" value="4_4">
                                <label class="form-check-label" for="4_4">
                                    4x4
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="6_4" value="6_4">
                                <label class="form-check-label" for="6_4">
                                    6x4
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="3_5" value="3_5">
                                <label class="form-check-label" for="3_5">
                                    3x5
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="3_6" value="3_6">
                                <label class="form-check-label" for="3_6">
                                    3x6
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="4_6" value="4_6" checked>
                                <label class="form-check-label" for="4_6">
                                    4x6
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="border border-2 px-3 py-2 rounded-3 mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Product Identification</label>
    
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="SKU">
                                <label class="form-check-label" for="SKU">
                                    SKU
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="Name" checked>
                                <label class="form-check-label" for="Name">
                                    Name
                                </label>
                            </div>
                        </div>

                        <div class="">
                            <label for="" class="form-label">Order Summary</label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="sub_total" checked>
                                <label class="form-check-label" for="sub_total">
                                    Sub Total
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="discount" checked>
                                <label class="form-check-label" for="discount">
                                    Discount
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="delivery_fee" checked>
                                <label class="form-check-label" for="delivery_fee">
                                    Delivery Fee
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="grand_total" checked>
                                <label class="form-check-label" for="grand_total">
                                    Grand Total
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="payment" checked>
                                <label class="form-check-label" for="payment">
                                    Payment
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="due_total" checked>
                                <label class="form-check-label" for="due_total">
                                    Due Total
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="border border-2 px-3 py-2 rounded-3 mb-3">
                        <label for="" class="form-label">Date Type</label>
    
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="creation" value="creation">
                                <label class="form-check-label" for="creation">
                                    Creation
                                </label>
                            </div>
    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="shipping" value="shipping" checked>
                                <label class="form-check-label" for="shipping">
                                    Shipping
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <button type="button" id="resetFilter" class="btn btn-primary">Reset</button>
                            <button type="button" class="btn btn-secondary">Print</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-9">
            
        </div>
    </div>


@endsection


@push('add-js')
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

@endpush