@extends('admin.layout.master')

@push('title')
    Manage Product List
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
                body{
            font-family: "Arimo", sans-serif !important;
        }
        .page-wrapper .nav-pills .nav-link {
            background-color: transparent;
            font-size: 12px;
            font-weight: 700;
            color: #4f8290;
        }
        .nav.nav-style-1 .nav-link.active:hover {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .nav.nav-style-1 .nav-link:hover {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .page-wrapper .nav-pills .nav-link.active {
            background-color: #ddebf0 !important;
            color: #2892af !important;
        }
        .search_box{
            position: relative;
            width: 260px;
            padding: 0;
            border-radius: 2px;
        }
        .search_box .search_filter{
            border: 1px solid #ebebeb;
            width: 100%;
            height: 40px;
            padding-left: 15px;
            color: #212B36;
            padding-right: 60px;
        }
        .search_box .search_filter::-webkit-input-placeholder,
        .search_box .search_filter::-moz-placeholder,
        .search_box .search_filter::-ms-input-placeholder{
            color: #CACACA;
        }
        .search_box #clear_search_filter{
            position: absolute;
            top: 50%;
            right: 42px;
            transform: translate(0, -50%);
            font-size: 22px;
            cursor: pointer;
        }

        .search_sub_container{
            position: relative;
        }
        .search_sub_container .cus_history_box{
            position: absolute;
            top: 40px;
            left: 0px;
            padding: 20px 12px 12px;
            border-radius: 6px;
            background: #FFF;
            z-index: 50;
            width: 100%;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        }
        .search_sub_container .cus_history_box.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .search_box .ti-search{
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background: #092C4C;
            color: #FFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
        }
        .filter_name{
            font-size: 16px;
        }
        .all_icons{
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 18px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .ti-copy,
        .ti-edit,
        .ti-printer{
            color: #1e857a;
        }
        .ti-plus{
            font-size: 20px;
            cursor: pointer;
        }
        .user_icon{
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            background: #e0eef9;
            margin: 0 auto 12px;
        }
        .user_icon .ti-user{
            font-size: 30px;
            color: #212B36;
        }
        th .checkboxs .checkmarks, td .checkboxs .checkmarks {
            width: 18px;
            height: 18px;
            border: 1px solid #8c8686 !important;
        }
        .form-check-input {
            border: 1px solid #000;
        }
        .form-check-input[type=checkbox] {
            border-radius: 0px;
        }
        .form-check-input:focus {
            border: 1px solid #000;
            border: 1px solid #FE9F43;
        }
        .calender_icon{
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            font-size: 24px;
            color: #9292a9;
            cursor: pointer;
            background: #F7F7F7;
        }
        .form_labels{
            color: #BEC1C4;
        }
        a:hover{
            color: #000 !important;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid transparent !important;
            background-color: transparent !important;
        }

        .table thead tr th{
            font-size: 13px !important;
        }
        .table tbody tr td{
            font-size: 12px !important;
        }
        .table thead tr th{
            font-weight: 700;
        }
        .popup_table thead tr th,
        .popup_table tbody tr td{
            font-size: 10px !important;
            font-weight: 600;
            padding: .5rem .5rem;
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
        @media (min-width: 1561px) and (max-width: 1920px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('Product', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Product</h4>
                <h6>Manage your Products</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.faq.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel"><img src="{{ asset('public/admin/assets/img/icons/excel.svg') }}" alt="img"></a>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
        <div class="page-btn">
            @if(auth("admin")->user()->can("create.brand"))
                <a href="" class="btn btn-teal"><i class="ti ti-circle-plus me-1"></i>Add Product</a>
             @endif
        </div>
    </div>
    

        {{-- Table Responsive --}}
        <div class="mb-0 border-1">
            <div class="row">
                <div class="mt-0">
                    <div class="table-responsive pb-3">
                        <table class="table table-hover table-nowrap mb-0 datatables">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Invoice No.</th>
                                    <th>Date</th>
                                    <th>Follow Up Date</th>
                                    <th>Auto-Approve Date</th>
                                    <th>Customer</th>
                                    <th>Pick Up Address</th>
                                    <th>Payment Info</th>
                                    <th>Order Status</th>
                                    <th>Delivery Partner</th>
                                    <th>Delivery Fee</th>
                                    <th>
                                        <span style="text-wrap: auto;">Cancel Reason</span>
                                    </th>
                                    <th>Internal Notes</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="copy-row">
                                            <div class="all_icons mb-2">
                                                <i data-tooltip="tip1" class="ti ti-info-circle cursor-pointer tooltip-trigger"></i>
    
                                                <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>
    
                                                <i class="ti ti-printer cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Print"></i>
    
                                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Edit"></i>
                                            </div>
    
                                            <a href="#" class="mb-2 d-block">
                                                <p class="text-teal font-bold copy_element">GB-9632541</p>
                                            </a>
    
                                            <div class="">
                                                <span class="badge bg-success">Whatsapp</span>
                                                {{-- <span class="badge bg-primary">Website</span>
                                                <span class="badge bg-success">Phone Call</span>
                                                <span class="badge bg-info">Facebook</span>
                                                <span class="badge bg-dark">Instagram</span> --}}
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                       <div class="d-flex flex-column">
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                       </div>
                                    </td>
    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="copy-row">
                                            <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <span class="badge badge-sm bg-primary">New</span>
                                                <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                            </div>
    
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <strong><span class="copyNumber">+8801833220886</span></strong>
                                                <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                                <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                    <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                                </a>
                                            </div>
    
                                            <div style="text-wrap: auto;">
                                                <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <span class="badge bg-soft-secondary">Warehouse</span>
                                            <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning">On Hold</button>
                                        <button type="button" class="btn btn-sm btn-primary">Approved</button>
                                        <button type="button" class="btn btn-sm btn-dark">Flagged</button>
                                        <button type="button" class="btn btn-sm btn-success">Ready To Ship</button>
                                        <button type="button" class="btn btn-sm btn-info">In-Transit</button>
                                        <button type="button" class="btn btn-sm btn-danger">Cancelled</button>
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button> --}}
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center gap-1"> 
                                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                            <p class="mb-0">Steadfast</p> 
                                        </div>
                                    </td>
    
                                    <td>
                                        <p>BDT 130.00</p>
                                    </td>
    
                                    <td style="text-wrap: auto;">
                                        
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus"></i> 
                                        </div>
                                    </td>
                                </tr>
    
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="copy-row">
                                            <div class="all_icons mb-2">
                                                <i data-tooltip="tip1" class="ti ti-info-circle cursor-pointer tooltip-trigger"></i>
    
                                                <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>
    
                                                <i class="ti ti-printer cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Print"></i>
    
                                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Edit"></i>
                                            </div>
    
                                            <a href="#" class="mb-2 d-block">
                                                <p class="text-teal font-bold copy_element">GB-9632541</p>
                                            </a>
    
                                            <div class="">
                                                <span class="badge bg-success">Whatsapp</span>
                                                {{-- <span class="badge bg-primary">Website</span>
                                                <span class="badge bg-success">Phone Call</span>
                                                <span class="badge bg-info">Facebook</span>
                                                <span class="badge bg-dark">Instagram</span> --}}
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                       <div class="d-flex flex-column">
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                       </div>
                                    </td>
    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="copy-row">
                                            <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <span class="badge badge-sm bg-primary">New</span>
                                                <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                            </div>
    
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <strong><span class="copyNumber">+8801833220886</span></strong>
                                                <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                                <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                    <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                                </a>
                                            </div>
    
                                            <div style="text-wrap: auto;">
                                                <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <span class="badge bg-soft-secondary">Warehouse</span>
                                            <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning">On Hold</button>
                                        <button type="button" class="btn btn-sm btn-primary">Approved</button>
                                        <button type="button" class="btn btn-sm btn-dark">Flagged</button>
                                        <button type="button" class="btn btn-sm btn-success">Ready To Ship</button>
                                        <button type="button" class="btn btn-sm btn-info">In-Transit</button>
                                        <button type="button" class="btn btn-sm btn-danger">Cancelled</button>
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button> --}}
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center gap-1"> 
                                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                            <p class="mb-0">Steadfast</p> 
                                        </div>
                                    </td>
    
                                    <td>
                                        <p>BDT 130.00</p>
                                    </td>
    
                                    <td style="text-wrap: auto;">
                                        
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus"></i> 
                                        </div>
                                    </td>
                                </tr>
    
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="copy-row">
                                            <div class="all_icons mb-2">
                                                <i data-tooltip="tip1" class="ti ti-info-circle cursor-pointer tooltip-trigger"></i>
    
                                                <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>
    
                                                <i class="ti ti-printer cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Print"></i>
    
                                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Edit"></i>
                                            </div>
    
                                            <a href="#" class="mb-2 d-block">
                                                <p class="text-teal font-bold copy_element">GB-9632541</p>
                                            </a>
    
                                            <div class="">
                                                <span class="badge bg-success">Whatsapp</span>
                                                {{-- <span class="badge bg-primary">Website</span>
                                                <span class="badge bg-success">Phone Call</span>
                                                <span class="badge bg-info">Facebook</span>
                                                <span class="badge bg-dark">Instagram</span> --}}
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                       <div class="d-flex flex-column">
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                       </div>
                                    </td>
    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="copy-row">
                                            <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <span class="badge badge-sm bg-primary">New</span>
                                                <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                            </div>
    
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <strong><span class="copyNumber">+8801833220886</span></strong>
                                                <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                                <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                    <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                                </a>
                                            </div>
    
                                            <div style="text-wrap: auto;">
                                                <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <span class="badge bg-soft-secondary">Warehouse</span>
                                            <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning">On Hold</button>
                                        <button type="button" class="btn btn-sm btn-primary">Approved</button>
                                        <button type="button" class="btn btn-sm btn-dark">Flagged</button>
                                        <button type="button" class="btn btn-sm btn-success">Ready To Ship</button>
                                        <button type="button" class="btn btn-sm btn-info">In-Transit</button>
                                        <button type="button" class="btn btn-sm btn-danger">Cancelled</button>
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button> --}}
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center gap-1"> 
                                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                            <p class="mb-0">Steadfast</p> 
                                        </div>
                                    </td>
    
                                    <td>
                                        <p>BDT 130.00</p>
                                    </td>
    
                                    <td style="text-wrap: auto;">
                                        
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus"></i> 
                                        </div>
                                    </td>
                                </tr>
    
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="copy-row">
                                            <div class="all_icons mb-2">
                                                <i data-tooltip="tip1" class="ti ti-info-circle cursor-pointer tooltip-trigger"></i>
    
                                                <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>
    
                                                <i class="ti ti-printer cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Print"></i>
    
                                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Edit"></i>
                                            </div>
    
                                            <a href="#" class="mb-2 d-block">
                                                <p class="text-teal font-bold copy_element">GB-9632541</p>
                                            </a>
    
                                            <div class="">
                                                <span class="badge bg-success">Whatsapp</span>
                                                {{-- <span class="badge bg-primary">Website</span>
                                                <span class="badge bg-success">Phone Call</span>
                                                <span class="badge bg-info">Facebook</span>
                                                <span class="badge bg-dark">Instagram</span> --}}
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                       <div class="d-flex flex-column">
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                       </div>
                                    </td>
    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="copy-row">
                                            <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <span class="badge badge-sm bg-primary">New</span>
                                                <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                            </div>
    
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <strong><span class="copyNumber">+8801833220886</span></strong>
                                                <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                                <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                    <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                                </a>
                                            </div>
    
                                            <div style="text-wrap: auto;">
                                                <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <span class="badge bg-soft-secondary">Warehouse</span>
                                            <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning">On Hold</button>
                                        <button type="button" class="btn btn-sm btn-primary">Approved</button>
                                        <button type="button" class="btn btn-sm btn-dark">Flagged</button>
                                        <button type="button" class="btn btn-sm btn-success">Ready To Ship</button>
                                        <button type="button" class="btn btn-sm btn-info">In-Transit</button>
                                        <button type="button" class="btn btn-sm btn-danger">Cancelled</button>
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button> --}}
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center gap-1"> 
                                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                            <p class="mb-0">Steadfast</p> 
                                        </div>
                                    </td>
    
                                    <td>
                                        <p>BDT 130.00</p>
                                    </td>
    
                                    <td style="text-wrap: auto;">
                                        
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus"></i> 
                                        </div>
                                    </td>
                                </tr>
    
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="copy-row">
                                            <div class="all_icons mb-2">
                                                <i data-tooltip="tip1" class="ti ti-info-circle cursor-pointer tooltip-trigger"></i>
    
                                                <i class="ti ti-copy cursor-pointer copy_name" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy"></i>
    
                                                <i class="ti ti-printer cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Print"></i>
    
                                                <i class="ti ti-edit cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Edit"></i>
                                            </div>
    
                                            <a href="#" class="mb-2 d-block">
                                                <p class="text-teal font-bold copy_element">GB-9632541</p>
                                            </a>
    
                                            <div class="">
                                                <span class="badge bg-success">Whatsapp</span>
                                                {{-- <span class="badge bg-primary">Website</span>
                                                <span class="badge bg-success">Phone Call</span>
                                                <span class="badge bg-info">Facebook</span>
                                                <span class="badge bg-dark">Instagram</span> --}}
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                       <div class="d-flex flex-column">
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Created:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Shipping:</span> Jan 1, 2026 09:49 A.M</p>
                                           <p class="mb-1"><span class="text-dark" style="font-weight: 700;">Approved:</span> Jan 1, 2026 09:49 A.M</p>
                                       </div>
                                    </td>
    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="copy-row">
                                            <h6 style="color: #1e857a;" class="mb-1"><strong>Minhajhul Islam</strong></h6>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <span class="badge badge-sm bg-primary">New</span>
                                                <i data-bs-effect="effect-scale" data-bs-toggle="modal" href="#customer_history" class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
                                            </div>
    
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <strong><span class="copyNumber">+8801833220886</span></strong>
                                                <span data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success" style="cursor: pointer;"><i class="ti ti-copy copyIcon" style="font-size: 18px;"></i></span>
                                                <a href="https://wa.me/01833220886" target="_blank" style="width: 18px;">
                                                    <img src="{{ asset('public/admin/assets/images/whatsapp.png') }}" alt="" width="18">
                                                </a>
                                            </div>
    
                                            <div style="text-wrap: auto;">
                                                <p style="font-weight: 500;">K-39/5, KURIL VATARA - 1229 K-39/5, KURIL VATARA - 1229</p>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <span class="badge bg-soft-secondary">Warehouse</span>
                                            <p class="mt-1" style="color: #1e857a;"><strong>Banasree Warehouse (1055)</strong></p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <div class="">
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Sales Amount:</span> BDT 1150.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Paid Amount:</span> BDT 0.00</p>
                                            <p class="mb-1"><span class="text-dark" style="font-weight: 500;">Due Amount:</span> BDT 1280.00</p>
                                        </div>
                                    </td>
    
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">Pending</button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning">On Hold</button>
                                        <button type="button" class="btn btn-sm btn-primary">Approved</button>
                                        <button type="button" class="btn btn-sm btn-dark">Flagged</button>
                                        <button type="button" class="btn btn-sm btn-success">Ready To Ship</button>
                                        <button type="button" class="btn btn-sm btn-info">In-Transit</button>
                                        <button type="button" class="btn btn-sm btn-danger">Cancelled</button>
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button> --}}
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center gap-1"> 
                                            <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" style="width: 20px; border-radius: 50px;"> 
                                            <p class="mb-0">Steadfast</p> 
                                        </div>
                                    </td>
    
                                    <td>
                                        <p>BDT 130.00</p>
                                    </td>
    
                                    <td style="text-wrap: auto;">
                                        
                                    </td>
    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus"></i> 
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
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
            initDateRangePicker('#discount_date', "down");
        });
    </script>

    <script>
        $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('.datatables').DataTable({
                pageLength: 25,
                layout: {
                    topStart: {
                        buttons: [
                            {
                                text: `<i class="ti ti-refresh"></i>`,
                                className: 'btn btn-outline-secondary refresh_btn',
                                action: function (e, dt, node, config) {
                                    alert('Button activated');
                                }
                            },
                            {
                                text: '<i class="ti ti-adjustments"></i> Filter Column',
                                className: 'btn btn-secondary filter-column-btn',
                                action: function () {
                                    // Bootstrap dropdown will handle it
                                }
                            }
                        ],
                        pageLength: {
                            menu: [10, 25, 50, 100, 250, -1]
                        },
                    },
                    topEnd: {
                        paging: true,
                    }
                },
                language: {
                    lengthMenu: "Show _MENU_"
                },
                initComplete: function () {
                    let table = this.api(); // Safe reference to DataTable

                    // Inject dropdown HTML AFTER table initialization
                    $('.filter-column-btn').replaceWith(`
                        <div class="dropdown">
                            <button class="btn btn-secondary border dropdown-toggle filter-column-btn"
                                    data-bs-toggle="dropdown">
                                <i class="ti ti-adjustments"></i> Filter Column
                            </button>
                            <div class="dropdown-menu filter-column-menu p-2"></div>
                        </div>
                    `);

                    let columnMenu = $('.filter-column-menu');

                    // Build checkboxes for all columns
                    table.columns().every(function (index) {
                        let column = this;
                        let title = $(column.header()).text().trim();
                        if (!title) return;

                        columnMenu.append(`
                            <div class="form-check mb-1">
                                <input class="form-check-input toggle-column"
                                    type="checkbox"
                                    data-column="${index}"
                                    checked>
                                <label class="form-check-label">${title}</label>
                            </div>
                        `);
                    });

                    // Bind toggle event
                    $(document).on('change', '.toggle-column', function () {
                        let columnIndex = $(this).data('column');
                        let visible = $(this).is(':checked');
                        table.column(columnIndex).visible(visible);
                    });
                }
            });

            //____ category_id Select2 ____//
            $('#units').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            function formatState (state) {
                if (!state.id) {
                    return state.text; // Return text for disabled option
                }

                var imageUrl = $(state.element).data('image-url'); // Access image URL from data attribute

                if (!imageUrl) {
                    return state.text; // Return text if no image URL is available
                }

                var $state = $(
                    '<span><img src="' + imageUrl + '" style="width: 35px; height: 30px; margin-right: 8px;" /> ' + state.text + '</span>'
                );
                return $state;
            };
        });

    </script>

@endpush

