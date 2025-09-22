@extends('admin.layout.master')

@push('title')
    Payslip
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

@php
    use NumberToWords\NumberToWords;
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('en');
@endphp

{{-- Active sidebar --}}
@section('payroll-toggle', 'subdrop active')
@section('payroll', 'active')


@section('body-content')

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Payslip</h4>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer feather-rotate-ccw"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn">
        <a href="{{ route('admin.hrm.payroll.index') }}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Back to Payroll</a>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Payslip for the Month of {{ date('M Y', strtotime($payroll->updated_at)) }}</h4>
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-primary me-2"><i class="ti ti-mail me-2"></i>Send Email</button>
                <button type="button" class="btn btn-secondary me-2"><i class="ti ti-download me-2"></i>Download</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1">Employee Name : <span class="text-gray-9">{{ $payroll->first_name . ' ' . $payroll->last_name }}</span></p>
                    <p>Employee ID :  <span class="text-gray-9">{{ $payroll->employee_code }}</span></p>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="mb-3">
                    <p class="mb-1">Location :  <span class="text-gray-9">{{ $payroll->country_name }}</span></p>
                    <p>Pay Period :   <span class="text-gray-9">{{ date('M Y', strtotime($payroll->updated_at)) }}</span></p>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <div class="row p-3">
                    <div class="col-6">
                        <h4>Earnings</h4>
                    </div>
                    <div class="col-6">
                        <h4>Deductions</h4>
                    </div>
                </div>
                <div class="table-responsive mb-3">
                    <div>
                        
                    </div>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Pay Type</th>
                                <th>Amount</th>
                                <th>Pay Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Basic Salary</td>
                                <td>${{ $payroll->basic_salary }}</td>
                                <td>PF</td>
                                <td>${{ $payroll->provident_fund }}</td>
                            </tr>
                            <tr>
                                <td>HRA Allowance</td>
                                <td>${{ $payroll->hra_allow }}</td>
                                <td>Professional  Tax</td>
                                <td>${{ $payroll->professional_tax }}</td>
                            </tr>
                            <tr>
                                <td>Conveyance</td>
                                <td>${{ $payroll->conveyance }}</td>
                                <td>TDS</td>
                                <td>${{ $payroll->tds }}</td>
                            </tr>
                            <tr>
                                <td>Medical Allowance</td>
                                <td>${{ $payroll->medical_allow }}</td>
                                <td>Loans &amp; Others</td>
                                <td>${{ $payroll->loan_others }}</td>
                            </tr>
                            <tr>
                                <td>Bonus</td>
                                <td>${{ $payroll->bonus }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><h6>Total Earnings</h6></td>
                                <td><h6>${{ $total_earnings }}</h6></td>
                                <td><h6>Total Deductions</h6></td>
                                <td><h6>${{ $total_deductions }}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center border-bottom mb-3">
            <div class="mb-3 me-3">
                <h6 class="mb-2">Net Salary</h6>
                <p>Inwords</p>
            </div>
            <div class="mb-3">
                <h6 class="mb-2">${{ $net_salary }}</h6>
                <p>{{  ucfirst($numberTransformer->toWords($net_salary)); }}</p>
            </div>
        </div>
        <div class="text-center">
            <div class="mb-3">
                <img src="{{ asset('public/admin/assets/img/logo.svg') }}" width="130" class="img-fluid" alt="logo">
            </div>
            <p>81, Randall Drive,Hornchurch <br>
                RM126TA.</p>
        </div>
    </div>
</div>

@endsection


@push('add-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
@endpush