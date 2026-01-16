@extends('admin.layout.master')

@push('title')
    Order Checkout
@endpush


@push('add-css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
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
        @page {
            margin: 0;
        }
        .print-wrapper {
            background: #ccc;
            padding: 20px;
        }

        .invoice {
            background: #fff;
            padding: 10px;
            margin: auto;
            color: #000;
        }

        .headers h3 {
            text-align: center;
            margin: 0;
        }

        .info, .total {
            font-size: 12px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .items th,
        .items td {
            border: 1px solid #d5d5d5;
            padding: 4px 6px;
        }

        @media print {
            body {
                margin: 0;
            }
            .print-wrapper {
                padding: 0;
                background: none;
            }
        }
        .pos-2x4 {
            width: 192px;
            height: 384px;
            font-size: 10px;
        }

        .pos-3x4 {
            width: 288px;
            height: 384px;
            font-size: 11px;
        }
        .pos-4x4 {
            width: 384px;
            height: 384px;
            font-size: 12px;
        }

        .pos-6x4 {
            width: 576px;
            height: 384px;
            font-size: 13px;
        }
        .pos-3x5 {
            width: 288px;
            height: 480px;
            font-size: 12px;
        }
        .pos-3x6 {
            width: 288px;
            height: 576px;
            font-size: 12px;
        }

        .pos-4x6 {
            width: 384px;
            height: 576px;
            font-size: 13px;
        }

        .invoice-header {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .invoice-header td {
            vertical-align: top;
        }

        .left_info_column {
            width: 40%;
        }

        .right_info_column {
            width: 60%;
            text-align: right;
        }

        .shop-name {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }

        .info-table td {
            padding: 1px 4px 1px 0;
            /* white-space: nowrap; */
        }

        .qr-box img {
            width: 70px;
            height: 70px;
        }

        .invoice-to {
            margin-top: 5px;
            text-align: left;
            font-size: 11px;
            line-height: 1.3;
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
            <div class="pos-settings-panel">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">POS Type</label>
        
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sticker" id="pos_sticker" value="pos_sticker" checked>
                                    <label class="form-check-label" for="pos_sticker">
                                        POS Sticker
                                    </label>
                                </div>
        
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sticker" id="rolling_paper" value="rolling_paper">
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
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="2_4" value="2_4" onclick="setInvoiceSize('2x4');">
                                    <label class="form-check-label" for="2_4">
                                        2x4
                                    </label>
                                </div>
        
                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="3_4" value="3_4" onclick="setInvoiceSize('3x4');">
                                    <label class="form-check-label" for="3_4">
                                        3x4
                                    </label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="4_4" value="4_4" onclick="setInvoiceSize('4x4');">
                                    <label class="form-check-label" for="4_4">
                                        4x4
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="3_5" value="3_5" onclick="setInvoiceSize('3x5');">
                                    <label class="form-check-label" for="3_5">
                                        3x5
                                    </label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="6_4" value="6_4" onclick="setInvoiceSize('6x4');">
                                    <label class="form-check-label" for="6_4">
                                        6x4
                                    </label>
                                </div>

    
                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="3_6" value="3_6" onclick="setInvoiceSize('3x6');">
                                    <label class="form-check-label" for="3_6">
                                        3x6
                                    </label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input ratio_size" type="radio" name="ratio_size" id="4_6" value="4_6" checked onclick="setInvoiceSize('4x6');">
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
                                    <input class="form-check-input" type="checkbox" value="" id="sku">
                                    <label class="form-check-label" for="sku">
                                        SKU
                                    </label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="name" checked>
                                    <label class="form-check-label" for="name">
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
                                    <input class="form-check-input" type="checkbox" value="" id="due_amount" checked>
                                    <label class="form-check-label" for="due_amount">
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
        </div>

        <div class="col-lg-9">
            <div class="print-wrapper pos-settings-panel">
                <div class="invoice pos-4x6" id="invoice">
                    <strong class="shop-name">GhorerBazar</strong>

                    <table class="invoice-header mb-3" >
                        <tr>
                            <!-- LEFT COLUMN -->
                            <td class="left_info_column">
                                <table class="info-table">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong>GB-718434</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td>Jan 05, 2026</td>
                                    </tr>
                                    <tr>
                                        <td>Courier:</td>
                                        <td><strong>Steadfast</strong></td>
                                    </tr>
                                </table>
                            </td>
                    
                            <!-- RIGHT COLUMN -->
                            <td class="right_info_column">
                                <div class="invoice-to">
                                    <strong>Invoice To:</strong><br>
                                    মোঃ আশিকুর রহমান<br>
                                    📞 +8801982243535<br>
                                    🗺️ বসুন্ধরা রেসিডেন্স, কুড়িল, ঢাকা, বাংলাদেশ
                                </div>
                            </td>
                        </tr>
                    </table>
            
                    <table class="items mb-0">
                        <thead style="background: #ECEDEE;">
                            <tr>
                                <th style="width: 60%;">Product</th>
                                <th style="width: 10%; text-align:center;">Qty</th>
                                <th style="width: 30%; text-align:right;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 60%;">
                                    <div class="">
                                        <span class="sku" style="display: none;"><strong>SKU:</strong>A000028</span>
                                        <p>লিচু ফুলের মধু/Litchi Flower Honey 250g</p>
                                    </div>
                                </td>
                                <td style="width: 10%; text-align:center;">1</td>
                                <td style="width: 30%; text-align:right;">300.00</td>
                            </tr>
                            <tr class="sub_total">
                                <td style="text-align:right;" colspan="2"><strong>Sub Total</strong></td>
                                <td style="text-align:right;"><strong>300.00</strong></td>
                            </tr>
                            <tr class="discount">
                                <td style="text-align:right;" colspan="2"><strong>Discount</strong></td>
                                <td style="text-align:right;"><strong>00.00</strong></td>
                            </tr>
                            <tr class="delivery_fee">
                                <td style="text-align:right;" colspan="2"><strong>Delivery Fee</strong></td>
                                <td style="text-align:right;"><strong>70.00</strong></td>
                            </tr>
                            <tr class="payment">
                                <td style="text-align:right;" colspan="2"><strong>Payment</strong></td>
                                <td style="text-align:right;"><strong>00.00</strong></td>
                            </tr>
                            <tr class="grand_total">
                                <td style="text-align:right;" colspan="2"><strong>Grand Total</strong></td>
                                <td style="text-align:right;"><strong>370.00</strong></td>
                            </tr>
                            <tr class="due_amount">
                                <td style="text-align:right;" colspan="2"><strong>Due Amount</strong></td>
                                <td style="text-align:right;"><strong>370.00</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('add-js')
<script>
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const rowClass = this.id;
            const rows = document.querySelectorAll('.' + rowClass);

            rows.forEach(row => {
                row.style.display = this.checked ? '' : 'none';
            });
        });
    });
</script>

    <script>
        function setInvoiceSize(size) {
            const invoice = document.getElementById('invoice');
            let left_info_column = document.querySelector('.left_info_column');
            let right_info_column = document.querySelector('.right_info_column');

            invoice.className = 'invoice pos-' + size;
        }

        // Example
        setInvoiceSize('4x6');
    </script>

@endpush