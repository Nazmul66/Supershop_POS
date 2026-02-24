@extends('admin.layout.master')

@push('title')
    Order Manage
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="{{ asset('public/admin/assets/css/select2.min.css') }}" rel="stylesheet" />
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
@section('faq', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header mb-2">
        <div class="add-item d-flex">
            <div class="page-title">
                <h2 class="fw-bold">Orders</h2>
                {{-- <h6>Manage your Faqs</h6> --}}
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="avatar-list-stacked">
                <span class="avatar avatar-rounded">
                    <img class="border border-white" src="{{ asset('public/admin/assets/img/profiles/avatar-05.jpg')}}" alt="img">
                </span>
                <span class="avatar avatar-rounded">
                    <img class="border border-white" src="{{ asset('public/admin/assets/img/profiles/avatar-05.jpg')}}" alt="img">
                </span>
                <span class="avatar avatar-rounded">
                    <img class="border border-white" src="{{ asset('public/admin/assets/img/profiles/avatar-05.jpg')}}" alt="img">
                </span>
                <a class="avatar bg-primary avatar-rounded text-fixed-white" href="javascript:void(0);">
                    +8
                </a>
            </div>

            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" style="">
                    <li><a class="dropdown-item" href="javascript:void(0);">Excel</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">PDF</a></li>
                </ul>
            </div>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-teal ">Create Order</a>
        </div>
    </div>

    {{-- Search Box --}}
    <div class="search_container d-flex align-items-center gap-2 mb-2">
        <div class="search_sub_container">
            <div class="search_box">
                <input type="text" placeholder="Search" name="search_filter" class="search_filter" id="search_filter">
                <i class="ti ti-search" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-placement="top" data-bs-original-title="Search by Customer Name, Order Id, Phone Number, Email, "></i>

                <i class="ti ti-x d-none" id="clear_search_filter"></i>
            </div>

            
            <div class="cus_history_box">
                <h6 class="text-success mb-3">Showing <span>1</span> result of "<span id="rt_input">GB-412536</span>"</h6>

                <div class="border border-1 p-3">
                    {{-- <div class="">
                        <div class="user_icon">
                            <i class="ti ti-user"></i>
                        </div>
                        <p class="text-center mb-2">Sorry! Data not found.</p>
                    </div> --}}

                    <div class="border-bottom pb-1 mb-3">
                        <a href="" class="d-block">
                            <h5 class="mb-1">Kabir Hassan</h5>
                            <span class="badge badge-xs bg-soft-info">GB-467545</span>
                            <p class="mt-1">01765201685</p>
                        </a>
                    </div>
    
                    <div class="border-bottom pb-1 mb-3">
                        <a href="" class="d-block">
                            <h5 class="mb-1">Kabir Hassan</h5>
                            <span class="badge badge-xs bg-soft-info">GB-465845</span>
                            <p class="mt-1">01765201685</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" data-bs-toggle="offcanvas" data-bs-target="#filterDrawer" aria-controls="offcanvasExample" class="btn btn-square btn-secondary d-flex align-items-center gap-2"><i class="ti ti-filter" style="font-size: 20px;"></i> <span class="filter_name">Filter</span></button>
    </div>

    {{-- Tab Button --}}
    <nav class="nav nav-style-1 nav-pills mb-3 gap-2" role="tablist">
        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#nav-products" aria-selected="true">All Orders</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-cart" aria-selected="false" tabindex="-1">Pending</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-orders" aria-selected="false" tabindex="-1">On Hold</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">Approved</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">Ready To Ship</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">In-Transit</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">Delivered</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">Flagged</a>
        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nav-offers" aria-selected="false" tabindex="-1">Cancelled</a>
    </nav>

    {{-- Button --}}
    <a href="#" class="border border-2 border-secondary p-2 d-inline-block mw-fit fw-bold rounded">
        Multiple Order <span class="badge bg-primary">0</span> with the same phone number <span class="badge bg-success">0</span>
    </a>

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


    {{-- Custom Tooltips --}}
    <div class="custom-tooltip" id="tip1">
        <div class="tooltip-arrows"></div>
        <div class="tooltip-content">
            <div class="mb-0">
                <div class="table-responsive">
                    <table class="popup_table table table-hover table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Sku</th>
                                <th>Image</th>
                                <th>
                                    <span class="d-block" style="width: 105px; text-wrap: auto;">
                                        Product Name
                                    </span>
                                </th>
                                <th>Price</th>
                                <th>Qty</th>
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
                                        Safawi/kalmi Dates (A Grade) 1kg Safawi/kalmi Dates (A Grade) 1kg
                                    </span>
                                </td>
                                <td>BDT 750 <br/> <del class="ms-1">BDT 900.00</del></td>
                                <td>3 kg</td>
                                <td>BDT 2250.00 <br/> <del class="ms-1">BDT 2700.00</del></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Filter Drawer Option --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterDrawer" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasExampleLabel">Order Filter</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> <!-- end offcanvas-header-->

        <div class="offcanvas-body">
           <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Delivery Types</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="regular">
                        <label class="form-check-label" for="regular">
                            Regular
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="express">
                        <label class="form-check-label" for="express">
                            Express
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="in-Store">
                        <label class="form-check-label" for="in-Store">
                            In-Store Pickup
                        </label>
                    </div>
                </div>
           </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Order Status</h4>

                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="pending">
                        <label class="form-check-label" for="pending">
                            Pending
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Hold">
                        <label class="form-check-label" for="Hold">
                            On Hold
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Approved">
                        <label class="form-check-label" for="Approved">
                            Approved
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Processing">
                        <label class="form-check-label" for="Processing">
                            Processing
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="ready_to_ship">
                        <label class="form-check-label" for="ready_to_ship">
                            Ready To Ship
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="in-Transit">
                        <label class="form-check-label" for="in-Transit">
                            In-Transit
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Delivered">
                        <label class="form-check-label" for="Delivered">
                            Delivered
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Flagged">
                        <label class="form-check-label" for="Flagged">
                            Flagged
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Cancelled">
                        <label class="form-check-label" for="Cancelled">
                            Cancelled
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Order Sources</h4>

                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Phone Call
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Facebook">
                        <label class="form-check-label" for="Facebook">
                            Facebook
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Messenger">
                        <label class="form-check-label" for="Messenger">
                            Messenger
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Whatsapp">
                        <label class="form-check-label" for="Whatsapp">
                            Whatsapp
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Instagram">
                        <label class="form-check-label" for="Instagram">
                            Instagram
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Tiktok">
                        <label class="form-check-label" for="Tiktok">
                            Tiktok
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Offline">
                        <label class="form-check-label" for="Offline">
                            Offline
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="up_sell">
                        <label class="form-check-label" for="up_sell">
                            Up Sell
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="Website">
                        <label class="form-check-label" for="Website">
                            Website
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="live_chat">
                        <label class="form-check-label" for="live_chat">
                            Live Chat
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="telesales">
                        <label class="form-check-label" for="telesales">
                            Telesales
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="others">
                        <label class="form-check-label" for="others">
                            Others
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Creation Date Range</h4>

                <div class="bg-input-field">
                    <div class="position-relative">
                        <input type="text" id="creation_date" name="creation_date" class="form-control form_inputs" placeholder="Select date range" />
                        <label for="creation_date" class="calender_icon">
                            <i class="ti ti-calendar-event"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Shipping Date Range</h4>

                <div class="bg-input-field">
                    <div class="position-relative">
                        <input type="text" id="shipping_date" name="shipping_date" class="form-control form_inputs" placeholder="Select date range" />
                        <label for="shipping_date" class="calender_icon">
                            <i class="ti ti-calendar-event"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Transition Date Range</h4>

                <div class="bg-input-field">
                    <div class="position-relative">
                        <input type="text" id="transition_date" name="transition_date" class="form-control form_inputs" placeholder="Select date range" />
                        <label for="transition_date" class="calender_icon">
                            <i class="ti ti-calendar-event"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Invoice Range</h4>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Starting Invoice</label>
                        <input type="number" min="1" id="start_invoice" name="start_invoice" class="form-control form_inputs" placeholder="" />
                    </div>

                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Ending Invoice</label>
                        <input type="number" min="1" id="end_invoice" name="end_invoice" class="form-control form_inputs" placeholder="" />
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Total Order Value</h4>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Min</label>
                        <input type="number" id="min_order_value" min="1" name="min_order_value" class="form-control form_inputs" placeholder="" />
                    </div>

                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Max</label>
                        <input type="number" id="max_order_value" min="1" name="max_order_value" class="form-control form_inputs" placeholder="" />
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Total Product Count</h4>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Min</label>
                        <input type="number" id="min_product_count" min="1" name="min_product_count" class="form-control form_inputs" placeholder="" />
                    </div>

                    <div class="bg-input-field ">
                        <label for="" class="form_labels">Max</label>
                        <input type="number" id="max_product_count" min="1" name="max_product_count" class="form-control form_inputs" placeholder="" />
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Delivery Partner</h4>

                <div class="bg-input-field ">
                    <select name="courier_agent" id="courier_agent" class="form-select" required>
                        <option value="" selected disabled>Select Courier Agent</option>
                        <option value="dd" data-image-url="{{ asset('public/admin/assets/images/steadfast.png') }}">SteadFast</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Delivery Partner Status</h4>

                <div class="bg-input-field ">
                    <select name="courier_agent_status[]" id="courier_agent_status" class="form-select" multiple required>
                        <option value="created">Pending</option>
                        <option value="in_review">In Review</option>
                        <option value="hold">Hold</option>
                        <option value="delivered_approval_pending">Delivered Approval Pending</option>
                        <option value="partial_delivered">Partial Delivered</option>
                        <option value="cancelled_approval_pending">Cancelled Approval Pending</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="delivery_status" id="delivery_status">
                    <label class="form-check-label" for="delivery_status">
                        Select All
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Pick Up Address</h4>

                <div class="bg-input-field ">
                    <select name="pickup_location" id="pickup_location" class="form-select select_form" required>
                        <option value="" selected disabled>Select Warehouse</option>
                        <option >Banasree Warehouse</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">By User</h4>

                <div class="bg-input-field ">
                    <select name="agent_user" id="agent_user" class="form-select" required>
                        <option value="" selected disabled>Select User</option>
                        <option value="dd" data-image-url="{{ asset('public/admin/assets/images/steadfast.png') }}">SteadFast</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Customer Tag</h4>

                <div class="bg-input-field mb-1">
                    <select name="cus_tag[]" id="cus_tag" class="form-control select_form"  multiple required>
                        <option value="fraud">Fraud</option>
                        <option value="new">New</option>
                        <option value="regular">Regular</option>
                        <option value="vip">VIP</option>
                        <option value="corporate">Corporate</option>
                        <option value="employee">Employee</option>
                        <option value="probashi">Probashi</option>
                    </select>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="" id="cus_tag_select">
                    <label class="form-check-label" for="cus_tag_select">
                        Select All
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Internal Notes</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inter_available">
                        <label class="form-check-label" for="inter_available">
                            Available
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inter_unavailable">
                        <label class="form-check-label" for="inter_unavailable">
                            Unavailable
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Discount (Order & Product)</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="discount_available">
                        <label class="form-check-label" for="discount_available">
                            Available
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="discount_unavailable">
                        <label class="form-check-label" for="discount_unavailable">
                            Unavailable
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Advance Payments & Payments</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="payment_available">
                        <label class="form-check-label" for="payment_available">
                            Available
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="payment_unavailable">
                        <label class="form-check-label" for="payment_unavailable">
                            Unavailable
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Invoice Print</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invoice_available">
                        <label class="form-check-label" for="invoice_available">
                            Already Printed
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invoice_unavailable">
                        <label class="form-check-label" for="invoice_unavailable">
                            Not Yet Printed
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="text-dark mb-2" style="font-weight: 700;">Customer Additional Info</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="customer_available">
                        <label class="form-check-label" for="customer_available">
                            Available
                        </label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="customer_unavailable">
                        <label class="form-check-label" for="customer_unavailable">
                            Unavailable
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-end gap-3">
                    <button type="button" id="resetFilter" class="btn btn-danger">Reset Filter</button>
                    <button type="button" class="btn btn-secondary">Apply Filter</button>
                </div>
            </div>
        </div> <!-- end offcanvas-body-->
    </div>

    {{-- Customer all history --}}
    <div class="modal effect-scale fade" id="customer_history" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Customer Overview</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body text-start">
                    {{-- Customer Details --}}
                    <div class="card customer_details">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="mb-1 d-block" style="font-size: 12px;">Customer ID</span>
                                <div class="d-flex align-items-center gap-2">
                                    <h5>C-415236</h5>
                                    <span class="badge badge-sm bg-primary">New</span>
                                </div>
                            </div>
        
                            <div class="mb-3">
                                <span class="mb-1 d-block" style="font-size: 12px;">Customer Name</span>
                                <h5>Nazmul Hassan</h5>
                            </div>
        
                            <div class="mb-3">
                                <span class="mb-1 d-block" style="font-size: 12px;">Phone Number</span>
                                <h5>+8801542695148</h5>
                            </div>
        
                            <div class="mb-3">
                                <span class="mb-1 d-block" style="font-size: 12px;">Customer Address</span>
                                <h5>K-39/5, kuril vatara - 1229</h5>
                            </div>
        
                            <div class="mb-3">
                                <span class="mb-1 d-block" style="font-size: 12px;">Map Location</span>
                                <h5> Ranks Business Centre, Plot-Ka-218/1-2, Pragati Sarani Main Road, Kuril, Dhaka-1229.</h5>
                            </div>
                        </div>
                    </div>

                    {{-- OnGoing Order Part --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="order_processing">
                                <div class="d-flex align-items-center gap-3 mb-3 border-bottom pb-3">
                                    <h5>OnGoing Order</h5>
                                    <span class="badge badge-lg bg-primary">3</span>
                                    <div class="bar_loader">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
            
                                {{-- 1st Order History --}}
                                <div class="border-bottom pb-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="#" class="text-secondary"><strong>GB-465888</strong></a>
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="1. Safawi/kalmi Dates (A Grade) 1kg Safawi/kalmi Dates (A Grade) 1kg . BDT 1550, 2. সুন্দরবনের মধু/Sundarban Honey . BDT 2250">
                                                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark  icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                            </div>

                                        </div>
            
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" >
                                                Pending
                                            </button>
                                        </div>
                                    </div>
            
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>BDT 2250.00</span>
                                        <div class="">
                                            <span>Sep 22,2025 9:45 P.M</span>
                                            <i class="ti ti-info-circle text-dark" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="This sales order GB-254136 was created by Nazmul Hassan at 11.23 A.M on Dec 02, 2026"></i>
                                        </div>
                                    </div>
                                </div>
            
                                {{-- 2nd Order History --}}
                                <div class="border-bottom pb-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="#" class="text-secondary"><strong>GB-4885</strong></a>
                                            <svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="1. Safawi/kalmi Dates (A Grade) 1kg Safawi/kalmi Dates (A Grade) 1kg . BDT 1550, 2. সুন্দরবনের মধু/Sundarban Honey . BDT 2250" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                        </div>
            
                                        <div class="dropdown">
                                            <button class="btn btn-primary" type="button">
                                                On Hold
                                            </button>
                                        </div>
                                    </div>
            
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>BDT 2075.50</span>
                                        <div class="">
                                            <span>Sep 29,2025, 11:45 P.M</span>
                                            <i class="ti ti-info-circle text-dark" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="This sales order GB-254136 was created by Admin at 11.23 A.M on Dec 02, 2026"></i>
                                        </div>
                                    </div>
                                </div>
            
                                {{-- 3rd Order History --}}
                                <div class="border-bottom pb-2" >
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="#" class="text-secondary"><strong>GB-4985</strong></a>
                                            <svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="1. Safawi/kalmi Dates (A Grade) 1kg Safawi/kalmi Dates (A Grade) 1kg . BDT 1550, 2. সুন্দরবনের মধু/Sundarban Honey . BDT 2250" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                        </div>
            
                                        <div class="dropdown">
                                            <a class="btn btn-info" type="button" >
                                                In Transit
                                            </a>
                                        </div>
                                    </div>
            
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>BDT 2075.50</span>
                                        <div class="">
                                            <span>Sep 29,2025, 11:45 P.M</span>
                                            <i class="ti ti-info-circle text-dark" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="This sales order GB-254136 was created by Admin at 11.23 A.M on Dec 02, 2026"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    {{-- Delivery Partner --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5><strong>Delivery Success Rate</strong></h5>
                                <a data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Refresh" type="button" class="btn btn-square btn-secondary btn_refresh"><i style="line-height: 0; font-size: 16px;" class="ti ti-rotate"></i></a>
                            </div>
        
                            <div class="d-flex align-items-center justify-content-between gap-1 mb-3">
                                <div class="progress progress-sm" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: #FF0000;">
                                    <div class="progress-bar bg-secondary" style="width: 88%"></div>
                                </div>
                                <span id="percentage">88.00%</span>
                            </div>
                            
                            <p style="font-size: 12px;">Updated On: Sep 22,2025, 9:45 P.M</p>
        
                            <div class="delivery_progress">
                                <div class="loading_zone d-none">
                                    <div class="load-position">
                                        <span class="arrow_loader"></span>
                                    </div>
                                </div>
        
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Partner</th>
                                                <th>Total</th>
                                                <th>Delivered</th>
                                                <th class="text-danger">Undelivered</th>
                                                <th>Percentage(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Steadfast</td>
                                                <td>23</td>
                                                <td>21</td>
                                                <td>2</td>
                                                <td>91.30%</td>
                                            </tr>
                                            <tr>
                                                <td>Pathao</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>100.00%</td>
                                            </tr>
                                            <tr>
                                                <td>Redx</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>00.00%</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>25</td>
                                                <td>22</td>
                                                <td>3</td>
                                                <td>88.00%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    {{-- Customer Order History --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <h5>Order History</h5>
                                    <span class="badge badge-md bg-primary">3</span>
                                </div>
        
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <h5>Delivered</h5>
                                    <span class="badge badge-md bg-primary">3</span>
                                </div>
        
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <h5>Flagged</h5>
                                    <span class="badge badge-md bg-primary">0</span>
                                </div>
        
                                <div class="d-flex align-items-center gap-3">
                                    <h5>Delivered</h5>
                                    <span class="badge badge-md bg-primary">3</span>
                                </div>
                            </div>
        
                            <div class="">
                                {{-- 1st Order History --}}
                                {{-- <div class="border-bottom pb-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="#" class="text-secondary"><strong>GB-4658</strong></a>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                        </div>
        
                                        <button class="btn btn-soft-info"> Delivered</button>
                                    </div>
        
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>BDT 2250.00</span>
                                        <span>Sep 22,2025 9:45 P.M</span>
                                    </div>
                                </div> --}}
        
                                {{-- 2nd Order History --}}
                                {{-- <div class="border-bottom pb-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="#" class="text-secondary"><strong>GB-4885</strong></a>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                        </div>
        
                                        <button class="btn btn-soft-info"> Delivered</button>
                                    </div>
        
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>BDT 2075.50</span>
                                        <span>Sep 29,2025, 11:45 P.M</span>
                                    </div>
                                </div> --}}
        
                                {{-- Delivery Record --}}
                                <div class="mt-5">
                                    <div class="user_icon">
                                        <i class="ti ti-package"></i>
                                    </div>
                                    <h6 class="text-center mb-2">No Order History ?</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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


        document.querySelector('.btn_refresh').addEventListener('click', function () {
            const loader = document.querySelector('.loading_zone');
        
            // show loader
            loader.classList.remove('d-none');
        
            // optional: hide again after loading (example)
            setTimeout(() => {
                loader.classList.add('d-none');
            }, 2000);
        });

        // Clear Search Filer
        document.addEventListener('DOMContentLoaded', function () {
            const clear_search_filter = document.getElementById('clear_search_filter');
            const searchInput = document.getElementById('search_filter');
            const historyBox = document.querySelector('.cus_history_box');
        
            clear_search_filter.addEventListener('click', function () {
                searchInput.value = "";
                historyBox.classList.remove('show');
                clear_search_filter.classList.add('d-none');
            });
        });


         // Search Filer
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search_filter');
            const rt_input = document.getElementById('rt_input');
            const historyBox = document.querySelector('.cus_history_box');
            const clear_search_filter = document.getElementById('clear_search_filter');
        
            searchInput.addEventListener('input', function () {
                const value = this.value.trim();

                if (this.value.trim() !== '') {
                    clear_search_filter.classList.remove('d-none');
                    historyBox.classList.add('show');
                    rt_input.innerText = value; 
                    
                } else {
                    clear_search_filter.classList.add('d-none');
                    historyBox.classList.remove('show');
                }
            });

            searchInput.addEventListener('focus', function () {
                if (this.value.trim() !== '') {
                    // clear_search_filter.classList.add('d-none');
                    historyBox.classList.add('show');
                    rt_input.innerText = value; 
                } else {
                    // clear_search_filter.classList.remove('d-none');
                    historyBox.classList.remove('show');
                }
            });
        
            // Optional: hide box when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.search_sub_container')) {
                    historyBox.classList.remove('show');
                }
            });
        });
        

        $('#agent_user').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });

        $('#courier_agent').select2({
            dropdownParent: $('#filterDrawer'),
            templateResult: formatState,       
            templateSelection: formatState, 
        });
        
        $('#courier_agent_status').select2({
            placeholder: "Select Delivery Status",
            closeOnSelect: false,
        });

        $('#cus_tag').select2({
            placeholder: "Select Customer Tag",
            closeOnSelect: false,
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
                '<span><img src="' + imageUrl + '" style="width: 30px; height: 30px; border-radius: 6px; margin-right: 8px;" /> ' + state.text + '</span>'
            );
            return $state;
        };


        /* -------- SELECT ALL -------- */
        $('#delivery_status').on('change', function () {
            if ($(this).is(':checked')) {
                let allValues = [];

                $('#courier_agent_status option').each(function () {
                    allValues.push($(this).val());
                });

                $('#courier_agent_status').val(allValues).trigger('change');
            } else {
                $('#courier_agent_status').val(null).trigger('change');
            }
        });

        /* -------- ON SELECT / UNSELECT -------- */
        $('#courier_agent_status').on('change', function () {
            let total = $('#courier_agent_status option').length;
            let selected = $('#courier_agent_status option:selected').length;

            $('#delivery_status').prop('checked', total === selected);
        });
        

        /* -------- SELECT ALL -------- */
        $('#cus_tag_select').on('change', function () {
            if ($(this).is(':checked')) {
                let allValues = [];

                $('#cus_tag option').each(function () {
                    allValues.push($(this).val());
                });

                $('#cus_tag').val(allValues).trigger('change');
            } else {
                $('#cus_tag').val(null).trigger('change');
            }
        });

        /* -------- ON SELECT / UNSELECT -------- */
        $('#cus_tag').on('change', function () {
            let total = $('#cus_tag option').length;
            let selected = $('#cus_tag option:selected').length;

            $('#cus_tag_select').prop('checked', total === selected);
        });



        // Reset Filter
        $('#resetFilter').on('click', function () {
            $('.form-check-input').prop('checked', false);
            $('.form_inputs').val('');
            $('.select_form').val('');

            /* ---DATE RANGE PICKER  --- */
            if ($('.daterange').length) {
                $('.daterange').val('');
            }

            /* -----SELECT2 RESET ---- */
            $('.select2-hidden-accessible').each(function () {
                $(this).val(null).trigger('change');
            });

            /* ----- MULTI SELECT / SELECT2 ----- */
            $('select[multiple]').val(null).trigger('change');
        });
</script>

<script>

    // Custom Tooltips
    document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('.tooltip-trigger');
        const GAP = 25;

        triggers.forEach(trigger => {
            const tooltip = document.getElementById(trigger.dataset.tooltip);
            let hideTimeout;

            function showTooltip() {
                clearTimeout(hideTimeout);

                const rect = trigger.getBoundingClientRect();
                const tooltipHeight = tooltip.offsetHeight;

                const top = rect.top + window.scrollY + rect.height / 2 - tooltipHeight / 2;
                const left = rect.right / 2 + window.scrollX / 2 + GAP;

                tooltip.style.top = `${top}px`;
                tooltip.style.left = `${left}px`;

                tooltip.classList.add('show');
            }

            function hideTooltip() {
                hideTimeout = setTimeout(() => {
                    tooltip.classList.remove('show');
                }, 50); // small delay to allow cursor move
            }

            // Hover on icon
            trigger.addEventListener('mouseenter', showTooltip);
            trigger.addEventListener('mouseleave', hideTooltip);

            // Keep open when hovering tooltip itself
            tooltip.addEventListener('mouseenter', () => {
                clearTimeout(hideTimeout);
            });

            tooltip.addEventListener('mouseleave', hideTooltip);
        });
    });

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
        initDateRangePicker('#creation_date', "auto");
        initDateRangePicker('#shipping_date', "auto");
        initDateRangePicker('#transition_date', "auto");
    });

    // Copy Order Id function
    document.addEventListener('click', function (e) {
        const iconWrapper = e.target.closest('.copy_name');
        if (!iconWrapper) return;

        // Find the nearest copy_element in the same row
        const row = iconWrapper.closest('.copy-row');
        const textElement = row.querySelector('.copy_element');

        const copyText = textElement.innerText.trim();

        navigator.clipboard.writeText(copyText).then(() => {

            // Change tooltip text
            iconWrapper.setAttribute('data-bs-original-title', 'Copied!');

            // Toggle icon class (NO innerHTML)
            iconWrapper.classList.remove('ti-copy');
            iconWrapper.classList.add('ti-checks');

            setTimeout(() => {
                iconWrapper.setAttribute('data-bs-original-title', 'Copy');
                iconWrapper.classList.remove('ti-checks');
                iconWrapper.classList.add('ti-copy');
            }, 1000);

        }).catch(error => {
            console.error('Copy failed:', error);
        });
    });

    // Copy Customer Number function
    document.addEventListener('click', function (e) {
        const iconWrapper = e.target.closest('.copyIcon');
        if (!iconWrapper) return;

        // Find the nearest copyNumber in the same row
        const row = iconWrapper.closest('.copy-row');
        const textElement = row.querySelector('.copyNumber');

        const copyText = textElement.innerText.trim();

        navigator.clipboard.writeText(copyText).then(() => {

            // Change tooltip text
            iconWrapper.setAttribute('data-bs-original-title', 'Copied!');

            // Toggle icon class (NO innerHTML)
            iconWrapper.classList.remove('ti-copy');
            iconWrapper.classList.add('ti-checks');

            setTimeout(() => {
                iconWrapper.setAttribute('data-bs-original-title', 'Copy');
                iconWrapper.classList.remove('ti-checks');
                iconWrapper.classList.add('ti-copy');
            }, 1000);

        }).catch(error => {
            console.error('Copy failed:', error);
        });
    });

</script>

@endpush