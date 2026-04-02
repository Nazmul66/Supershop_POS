@extends('admin.layout.master')

@push('add-title')
    Invoice Payment Type Change
@endpush


@push('add-css')
    <style>
        .invoice_heading{
            color: #009688;
            text-align: center;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .search_invoice{
            display: flex;
            gap: 12px;
        }
        .invoice_form {
            color: #0a0a0a;
            font-size: 2rem;
            font-weight: 700;
            width: 100%;
            height: 50px;
            border: 1px solid #dfdfdf;
            padding: 0px 60px;
            border-bottom: 3px solid #1E78C8;
        }
        .invoice_form::placeholder,
        .invoice_form::-webkit-input-placeholder,
        .invoice_form:-ms-input-placeholder{
            color: #645c5c;    
            font-weight: 700;  
            opacity: 1;   
        }
        .existing_cash_summary{
            margin-top: 1rem;
            margin-bottom: 1rem;
            width: 100%;
            height: 125px;
            overflow: auto;
            background: #fff;
            padding: 8px;
            border: 1px solid #000;
        }
        .table_customs thead tr th,
        .table_customs tbody tr td{
            color: #000;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
        }
        .table_customs thead tr{
            border-bottom: 1px solid #000;
        }
        .table_customs tbody tr:hover td {
            background-color: #0078D7 !important;
            color: #fff;
        }
        .recent_form_field{
            color: #645c5c;
            font-size: 0.9rem;
            font-weight: 500;
            width: 100%;
            height: 30px;
            border: 1px solid #dfdfdf;
            padding: 0px 9px;
            border-bottom: 1px solid #9b9797;
            border-radius: 4px;
        }
        .recent_form_field:focus{
            border-bottom: 2px solid #86b7fe;
        }
        .recent_cash_summary{
            padding: 8px;
            border: 1px solid #000;
            background: #fff;
            width: 100%;
            height: 175px;
            overflow: auto;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('faq', 'active')


@section('body-content')

 <div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h2 class="invoice_heading">Enter Invoice Number</h2>

        {{-- 1st row content --}}
        <div class="row ">
            <div class="col-lg-8">
                <div class="search_invoice">
                    <input type="text" class="invoice_form" id="">
                    <button type="button" class="btn btn-secondary btn-lg">Search</button>
                </div>
            </div>

            <div class="col-lg-4">
                <input type="text" class="invoice_form" id="invoice_amount" style="background: #FFE0C0; padding: 0; text-align: right;" value="" readonly>
            </div>
        </div>

        {{-- 2nd row content --}}
        <div class="existing_cash_summary">
            <div class="row">
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table_customs table-bordered table mb-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>SL.</th>
                                    <th>Description</th>
                                    <th>Card No.</th>
                                    <th>Machine No.</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td><i class="ti ti-arrow-big-right"></i></td>
                                    <td>1</td>
                                    <td>CASH</td>
                                    <td></td>
                                    <td></td>
                                    <td>580.00</td>
                                </tr>
                                <tr>
                                    <td><i class="ti ti-arrow-big-right"></i></td>
                                    <td>2</td>
                                    <td>Bkash (Merchant)</td>
                                    <td>2204</td>
                                    <td></td>
                                    <td>80.00</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3rd row content --}}
        <div class="">
           <div class="row">
               <div class="col-lg-5">
                   <div class="d-flex align-items-center gap-3 mb-1">
                         <label class="col-form-label" style="white-space: nowrap;">Payment Type</label>
                         <select class="form-select" id="payment_type">
                            <option selected disabled>-- Select --</option>
                            <option value="cash">Cash</option>
                            <option value="bkash_merchant">Bkash (Merchant)</option>
                            <option value="bkash_personal">Bkash (Personal)</option>
                            <option value="dbbl">DBBL</option>
                            <option value="ebl">EBL</option>
                            <option value="city_bank">City Bank</option>
                            <option value="brac_bank">Brac Bank</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-1">
                        <label class="col-form-label" style="white-space: nowrap;">Card Number</label>
                        <input type="text" class="recent_form_field" id="card_number">   
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-1">
                        <label class="col-form-label" style="white-space: nowrap;">Machine Number</label>
                        <input type="text" class="recent_form_field" id="machine_number">   
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-1">
                        <label class="col-form-label" style="white-space: nowrap;">Amount</label>
                        <input type="text" class="recent_form_field" id="amount">   
                    </div>
               </div>

               <div class="col-lg-7">
                    <div class="recent_cash_summary">
                        <div class="table-responsive">
                            <table class="table_customs table-bordered table mb-0" id="recent_table_data">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Card No.</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>CASH</td>
                                        <td></td>
                                        <td>580.00</td>
                                    </tr>
                                    <tr>
                                        <td>Bkash (Merchant)</td>
                                        <td>2204</td>
                                        <td>80.00</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
           </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-3 mt-3 mb-5">
            <button type="button" class="btn btn-lg btn-danger">Close</button>
            <button type="button" class="btn btn-lg btn-secondary">Change</button>
        </div>
    </div>
 </div>

@endsection

@push('add-js')

    <script>
        $(document).ready(function () {

            function getInvoiceAmount() {
                return parseFloat($('#invoice_amount').val()) || 0;
            }

            function setInvoiceAmount(value) {
                $('#invoice_amount').val(value.toFixed(2));
            }

            // 👉 Focus flow (Enter key navigation)
            $('#payment_type').on('change', function () {
                $('#card_number').focus();
            });

            $('#card_number').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#machine_number').focus();
                }
            });

            $('#machine_number').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#amount').focus();
                }
            });

            // 👉 Final step: Add to table
            $('#amount').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();

                    let paymentType = $('#payment_type').val();
                    let cardNumber = $('#card_number').val();
                    let machineNumber = $('#machine_number').val();
                    let amount = parseFloat($('#amount').val());
                    let currentTotal = getInvoiceAmount();

                    // ✅ Validation
                    if (!paymentType) {
                        alert('Select Payment Type');
                        $('#payment_type').focus();
                        return;
                    }

                    if (!amount || amount <= 0) {
                        alert('Amount is required');
                        return;
                    }

                    // ❌ Prevent exceed
                    if (amount > currentTotal) {
                        // alert('Amount exceeds invoice total!');
                        swal.fire({
                            title: "Sorry!!! exceeding invoice amount...!!",
                            icon: "error",
                            confirmButtonText: "Okay"
                        })
                        $('#amount').focus();
                        return;
                    }

                    // ✅ Subtract from total
                    let newTotal = currentTotal - amount;
                    setInvoiceAmount(newTotal);

                    // ✅ Append row
                    let row = `
                        <tr data-amount="${amount}">
                            <td>${paymentType}</td>
                            <td>${cardNumber ?? ''}</td>
                            <td>${amount.toFixed(2)}</td>
                        </tr>
                    `;

                    $('#recent_table_data tbody').append(row);

                    // ✅ Reset fields
                    $('#card_number').val('');
                    $('#machine_number').val('');
                    $('#amount').val('');

                    // 👉 Focus আবার শুরুতে
                    $('#payment_type').prop('selectedIndex', 0).focus();
                }
            });

        $(document).on('dblclick', '#recent_table_data tbody tr', function () {
            let row = $(this);
            let rowAmount = parseFloat(row.data('amount')) || 0;

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove this row!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#092C4C',
                cancelButtonColor: '#db0000',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Add back amount
                    let currentTotal = getInvoiceAmount();
                    let newTotal = currentTotal + rowAmount;
                    setInvoiceAmount(newTotal);

                    // ✅ Remove row
                    row.remove();

                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Deleted!',
                    //     text: 'Row has been removed.',
                    //     timer: 1500,
                    //     showConfirmButton: false
                    // });
                }
            });
        });
    });
    </script>
@endpush

