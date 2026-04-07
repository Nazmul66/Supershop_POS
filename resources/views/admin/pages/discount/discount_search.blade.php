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
            background: #fff;
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
            height: 30px;
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

