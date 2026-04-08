@extends('admin.layout.master')

@push('add-title')
    Invoice Payment Type Change
@endpush


@push('add-css')
    <style>
        .discount_heading{
            color: #000;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .discount_summary{
            margin-top: 1rem;
            margin-bottom: 1rem;
            width: 100%;
            height: 250px;
            padding: 25px;
            border: 1px solid #000;
        }
        .col-form-label{
            font-size: 12px;
            font-weight: 700;
        }
        .discount_form {
            color: #0a0a0a;
            font-size: 1rem;
            font-weight: 700;
            width: 100%;
            height: 25px;
            border: 1px solid #dfdfdf;
            padding: 0px 10px;
            border-bottom: 1px solid #1E78C8;
        }
        .discount_form::placeholder,
        .discount_form::-webkit-input-placeholder,
        .discount_form:-ms-input-placeholder{
            color: #645c5c;    
            font-weight: 700;  
            opacity: 1;   
        }

    </style>
@endpush

{{-- Active sidebar --}}
@section('discount-search', 'active')


@section('body-content')

 <div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h2 class="discount_heading">Discount Circular Search By Barcode</h2>

        {{-- 1st row content --}}
        <div class="discount_summary">
            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">Barcode</label>
                        </div>

                        <div class="col-lg-9">
                            <div class="d-flex gap-2">
                                <input type="text" class="discount_form" id="invoice_amount" style="background: #FFF;" value="">
                               <button type="button" class="btn btn-sm btn-info">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">SKU</label>
                        </div>

                        <div class="col-lg-9">
                            <input type="text" class="discount_form" id="invoice_amount" style="background: #FFFFC0;" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">Name</label>
                        </div>

                        <div class="col-lg-9">
                            <input type="text" class="discount_form" id="invoice_amount" style="background: #FFE0C0;" value="">
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">MRP</label>
                        </div>

                        <div class="col-lg-9">
                            <input type="text" class="discount_form" id="invoice_amount" style="background: #FFE0C0;" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">Disc %</label>
                        </div>

                        <div class="col-lg-9">
                            <input type="text" class="discount_form" id="invoice_amount" style="background: #FFE0C0;" value="">
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="col-form-label d-block text-end">Disc Amount</label>
                        </div>

                        <div class="col-lg-9">
                            <input type="text" class="discount_form" id="invoice_amount" style="background: #FFE0C0;" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

@endsection

@push('add-js')

    <script>
        $(document).ready(function () {

        });
    </script>
@endpush

