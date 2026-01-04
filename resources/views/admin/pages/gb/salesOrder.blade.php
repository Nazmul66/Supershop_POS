@extends('admin.layout.master')

@push('title')
    Order Details
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
        }
        .bar_loader {
            display: flex;
            align-items: flex-end;
            gap: 6px;
            width: 56px;
            height: 40px;
        }

        .bar_loader span {
            width: 5px;
            height: 10px;
            background: #28a745;
            /* border-radius: 4px; */
            animation: barMove 1.2s ease-in-out infinite;
        }

        /* Serial animation delay */
        .bar_loader span:nth-child(1) { animation-delay: 0s; }
        .bar_loader span:nth-child(2) { animation-delay: 0.1s; }
        .bar_loader span:nth-child(3) { animation-delay: 0.2s; }
        .bar_loader span:nth-child(4) { animation-delay: 0.3s; }
        .bar_loader span:nth-child(5) { animation-delay: 0.4s; }
        .bar_loader span:nth-child(6) { animation-delay: 0.5s; }

        /* Up & Down animation */
        @keyframes barMove {
            0%   { height: 10px; opacity: 0.4; }
            50%  { height: 40px; opacity: 1; }
            100% { height: 10px; opacity: 0.4; }
        }
        .tabler_info_circle{
            width: 20px;
            cursor: pointer;
        }
        .flatpickr-input {
            pointer-events: auto !important;
            background-color: #fff !important;
        }
        .order_processing{
            width: 100%;
            max-height: 320px; 
            min-height: 170px;
            overflow-y: auto;
            padding-right: 10px;
        }
        .table thead tr th,
        .table tbody tr td{
            font-size: 11px !important;
            font-weight: 600;
            padding: .5rem .5rem;
        }
        @media (min-width: 1240px) and (max-width: 1560px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
        .delivery_progress{
            position: relative;
        }
        .loading_zone{
            position: absolute; 
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.6);

        }
        .loading_zone .load-position{
            position: absolute;
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%);
        }
        .arrow_loader {
            width: 48px;
            height: 48px;
            display: inline-block;
            position: relative;
            border-width: 3px 2px 3px 2px;
            border-style: solid dotted solid dotted;
            border-color: #de3500 rgba(255, 255, 255,0.3) #3EB780 rgba(151, 107, 93, 0.3);
            border-radius: 50%;
            box-sizing: border-box;
            animation: 1s rotate linear infinite;
        }
        .arrow_loader:before , .arrow_loader:after{
            content: '';
            top: 0;
            left: 0;
            position: absolute;
            border: 10px solid transparent;
            border-bottom-color:#3EB780;
            transform: translate(-10px, 19px) rotate(-35deg);
        }
        .arrow_loader:after {
            border-color: #de3500 #0000 #0000 #0000 ;
            transform: translate(32px, 3px) rotate(-35deg);
        }
        @keyframes rotate {
            100%{    transform: rotate(360deg)}
        }
        .page_intersaction{
            max-height: 70vh;   /* screen height */
            overflow-y: auto;
            padding-right: 12px;
        }
        .product_intersaction{
            max-height: 54vh;   /* screen height */
            overflow-y: auto;
            padding-right: 12px;
        }
        .customer_details{
            position: relative;
        }
        .customer_details .btn_edit{
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .search_box{
            position: relative;
            background: #e6eaed;
            padding: 14px 16px;
            border-radius: 6px;
        }
        .search_box .cus_create_box{
            position: absolute;
            top: 85px;
            left: 8px;
            padding: 28px;
            border-radius: 6px;
            background: #FFF;
            z-index: 50;
            width: 95%;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        }
        /* Show state */
        .search_box .cus_create_box.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .search_box .cus_history_box{
            position: absolute;
            top: 85px;
            left: 8px;
            padding: 20px 28px 12px 28px;
            border-radius: 6px;
            background: #FFF;
            z-index: 50;
            width: 95%;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        }
        .search_box .cus_history_box.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .search_form_box{
           position: relative;
        }
        .search_form_box .form_search{
            border: none;
            width: 100%;
            padding-left: 28px;
            background: transparent;
            height: 35px;
            font-size: 16px;
            border-radius: 4px;
            color: #212B36;
            font-weight: 500;
        }
        .search_form_box .ti-search{
           position: absolute;
           top: 50%;
           left: 0;
           transform: translateY(-50%);
           font-size: 22px;
        }
        .form-check-input {
            border: 1px solid #706666 !important;
        }
        .pageWrapper,
        .productSearchWrapper,
        .productWrapper{
            padding-right: 10px;
        }
        .scroll-box{
            overflow-y: hidden;
            transition: max-height 0.2s ease;
        }
        .card_empty{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wg-quantity {
            display: inline-flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            background: #fff;
            height: 38px;
        }
        .form-select,
        .form-control{
            font-weight: 600;
        }

        .btn-quantity {
            width: 38px;
            height: 38px;
            border: none;
            background: #0b2545; /* match Add to Cart button */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            user-select: none;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
        }

        .btn-quantity:hover {
            background: #163a6b;
        }

        .btn-quantity:active {
            transform: scale(0.95);
        }

        .quantity-product {
            width: 50px;
            height: 38px;
            text-align: center;
            border: none;
            outline: none;
            font-size: 14px;
            font-weight: 600;
            color: #0b2545;
            background: #f8fafc;
        }

        .order_calculation{
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 250px;
            background: #fff;
        }
        .copyright-footer {
            padding: 12px 24px;
            display: none !important;
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
                <h4 class="fw-bold">Sales Order</h4>
                {{-- <h6>Manage your Faqs</h6> --}}
            </div>
        </div>

        <div class="page-btn">
            <a href="#" class="btn btn-primary">Back</a>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-3">
            <div class="pageWrapper scroll-box">
                {{-- Customer Search Option --}}
                <div class="search_box mb-3">
                    <div class="">
                        <h3 class="mb-1">Customer Search</h3>
                        <div class="search_form_box">
                            <input type="text" id="cus_name" name="cus_name" class="form_search" placeholder="Search by Name or Phone Number" />
                            <i class="ti ti-search"></i>
                        </div>
                    </div>

                    <div class="cus_create_box ">
                        <div class="user_icon">
                            <i class="ti ti-user"></i>
                        </div>
                        <p class="text-center mb-2">Sorry! Customer not found.</p>
                        <div class="text-center">
                            <button type="button" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#create_customer" class="btn btn-secondary">Add Customer</button>
                        </div>
                    </div>

                    
                    <div class="cus_history_box">
                        <div class="border-bottom pb-1 mb-3">
                            <a href="" class="d-block">
                                <h4 class="mb-1">Kabir Hassan</h4>
                                <span class="badge badge-sm bg-primary">New</span>
                                <p class="mt-1">01765201685</p>
                            </a>
                        </div>

                        <div class="border-bottom pb-1 mb-3">
                            <a href="" class="d-block">
                                <h4 class="mb-1">Kabir Hassan</h4>
                                <span class="badge badge-sm bg-primary">Regular</span>
                                <p class="mt-1">01765201685</p>
                            </a>
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
                                        <a href="#" class="text-secondary"><strong>GB-4658</strong></a>
                                        <div >
                                            <svg  data-tooltip="tip1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark tooltip-trigger icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                        </div>

                                    </div>
        
                                    <div class="dropdown">
                                        <a class="btn btn-secondary" href="#" role="button" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#orderModal">
                                            Pending
                                        </a>
                                    </div>
                                </div>
        
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>BDT 2250.00</span>
                                    <span>Sep 22,2025 9:45 P.M</span>
                                </div>
                            </div>
        
                            {{-- 2nd Order History --}}
                            <div class="border-bottom pb-2 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="#" class="text-secondary"><strong>GB-4885</strong></a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                    </div>
        
                                    <div class="dropdown">
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#orderModal">
                                            On Hold
                                        </a>
                                    </div>
                                </div>
        
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>BDT 2075.50</span>
                                    <span>Sep 29,2025, 11:45 P.M</span>
                                </div>
                            </div>
        
                            {{-- 3rd Order History --}}
                            <div class="border-bottom pb-2" >
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="#" class="text-secondary"><strong>GB-4985</strong></a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                    </div>
        
                                    <div class="dropdown">
                                        <a class="btn btn-info" href="#" role="button" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#orderModal">
                                            In Transit
                                        </a>
                                    </div>
                                </div>
        
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>BDT 2075.50</span>
                                    <span>Sep 29,2025, 11:45 P.M</span>
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
                                            <th>Courier</th>
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

                {{-- Customer Details --}}
                <div class="card customer_details">
                    <button type="button" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#editModal" class="btn_edit btn btn-outline-secondary">Edit</button>

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
        </div>

        <div class="col-lg-4">
            <div class="">
                {{-- Product Search Option --}}
                <div class="mb-4">
                    <div class="search_box">
                        <h3 class="mb-1" for="product_search">Product Search</h3>
                        <div class="search_form_box">
                            <input type="text" id="product_search" name="product_search" class="form_search" placeholder="Search by Product Name or Sku" />
                            <i class="ti ti-search"></i>
                        </div>
                    </div>

                    <div id="search_msg_show" class="mt-2 d-none d-flex align-items-center justify-content-between gap-3">
                        <strong><span>0 Item founds in "<span id="rt_input"></span>"</span></strong>
                        <button type="button" id="clear_search" class="text-danger border-0 bg-transparent">Clear Search</button>
                    </div>
                </div>


                {{-- All Product List --}}
                <div class="product_box productSearchWrapper scroll-box">
                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                               <img src="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}" alt="" width="85">
                               <div class="">
                                  <h4 class="mb-2">লিচু ফুলের মধু/Lichu Flower Honey</h4>
                                  <p><strong>SKU:</strong> A000121</p>
                               </div>
                           </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <h5>BDT 600.00</h5>
                                </div>
                                <button type="button" class="btn btn-secondary"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"></path></svg>
                                    Add To Cart</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 0.5 kg</button>
                                <div class="d-flex align-items-center gap-2">
                                    <h6> Check Availibities</h6> <i class="ti ti-info-circle text-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                               <img src="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" alt="" width="85">
                               <div class="">
                                  <h4 class="mb-2">সুন্দরবনের মধু/Sundarban Honey</h4>
                                  <p><strong>SKU:</strong> A000251</p>
                               </div>
                           </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <h5>BDT 1550.00</h5>
                                    <del>
                                       <h5>BDT 1700.00</h5>
                                    </del>
                                </div>
                                <button type="button" class="btn btn-secondary"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"></path></svg>
                                    Add To Cart</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 1 kg</button>
                                <div class="d-flex align-items-center gap-2">
                                    <h6> Check Availibities</h6> <i class="ti ti-info-circle text-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card mb-2">
                <div class="card-header">
                    <h2>Cart (0)</h2>
                </div>
            </div>

            <div class="productWrapper scroll-box">
                {{-- <div class="card">
                    <div class="card-body scroll_box">   
                        <div class="mt-5">
                            <div class="user_icon">
                                <i class="ti ti-basket"></i>
                            </div>
                            <h4 class="text-center mb-2">Cart Empty</h4>
                        </div>
                    </div>
                </div> --}}
                
                <div class="">
                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                               <img src="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}" alt="" width="85">
                               <div class="">
                                  <h4 class="mb-2">লিচু ফুলের মধু/Lichu Flower Honey</h4>
                                  <p class="mb-2"><strong>SKU:</strong> A000121</p>
                                  <div class="d-flex align-items-center gap-2">
                                      <h5>BDT 600.00</h5>
                                  </div>
                               </div>
                           </div>
    
                           <div class="mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 0.5 kg</button>
                           </div>
                        </div>
    
                        <div class="card-body">
                            <div class="p-3 bg-secondary-transparent">
                                <h4>Unit Price</h4>
                                <p>BDT 600.00</p>
                            </div>
    
                            <div class="d-flex align-items-center justify-content-between gap-2 mt-4">
                                <p class="text-success mb-0"><strong>( No Discount )</strong></p>
                                <div class="d-flex align-items-center gap-4">
                                    <h5>BDT 600.00</h5>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="qty" value="1">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                               <img src="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" alt="" width="85">
                               <div class="">
                                  <h4 class="mb-2">সুন্দরবনের মধু/Sundarban Honey</h4>
                                  <p class="mb-2"><strong>SKU:</strong> A000251</p>
                                  <div class="d-flex align-items-center gap-2">
                                      <h5>BDT 1550.00</h5>
                                      <del>
                                        <h5>BDT 1700.00</h5>
                                      </del>
                                  </div>
                               </div>
                           </div>
    
                           <div class="mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 1 kg</button>
                           </div>
                        </div>
    
                        <div class="card-body">
                            <div class="p-3 bg-secondary-transparent">
                                <h4>Unit Price</h4>
                                <p>BDT 1700.00</p>
                            </div>
    
                            <div class="d-flex align-items-center justify-content-between gap-2 mt-4">
                                <p class="text-danger mb-0"><strong>( BDT 150 Taka Discount )</strong></p>
                                <div class="d-flex align-items-center gap-4">
                                    <h5>BDT 1550.00</h5>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="qty" value="1">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="text-end mt-2 mb-5">
                        <button class="btn btn-square btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Next</button>
                   </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Customer Details Update Modal -->
    <div id="editModal" class="modal fade effect-flip-vertical" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Update Customer Details</h5>
                    <button type="button" class="btn-close" id="btn_cross" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_tag">Customer Tag <span class="text-danger"> *</span></label>

                                <select name="cus_tag" id="cus_tag" class="form-control">
                                    <option value="new" selected>New</option>
                                    <option value="regular">Regular</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_name">Customer Name <span class="text-danger"> *</span></label>

                                <input type="text" id="cus_name" name="cus_name" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3 mt-3">
                                <label class="form-label">Phone Number <span class="text-danger"> *</span></label>

                                <input type="text" id="cus_number" name="cus_number" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_address">Customer Address </label>
                                <div class="input-addon-right position-relative">
                                    <textarea name="cus_address" class="form-control" id="cus_address" cols="30" rows="5"></textarea>
                                </div>

                                <span id="cus_address_validate" class="text-danger validation-error mt-1"></span>
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


    <!-- Customer Create -->
    <div id="create_customer" class="modal fade effect-flip-vertical" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
    style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create Customer</h5>
                    <button type="button" class="btn-close" id="btn_cross" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_type">Customer Type</label>

                                <select name="cus_type" id="cus_type" class="form-select">
                                    <option value="" selected>Ecommerce Type Customer</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_name">Customer Name <span class="text-danger"> *</span></label>

                                <input type="text" id="cus_name" name="cus_name" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="cus_number">Phone Number <span class="text-danger"> *</span></label>
                                <input type="text" id="cus_number" name="cus_number" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="cus_email">Customer Email (optional)</label>
                                <input type="text" id="cus_email" name="cus_email" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_address">Customer Address</label>
                                <div class="input-addon-right position-relative">
                                    <textarea name="cus_address" class="form-control" id="cus_address" cols="30" rows="3"></textarea>
                                </div>

                                <span id="cus_address_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="additional_note">Additional Note (optional)</label>
                                <div class="input-addon-right position-relative">
                                    <textarea name="additional_note" class="form-control" id="additional_note" cols="30" rows="3"></textarea>
                                </div>

                                <span id="additional_note_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="internal_note">Internal Note (optional)</label>
                                <div class="input-addon-right position-relative">
                                    <textarea name="internal_note" class="form-control" id="internal_note" cols="30" rows="3"></textarea>
                                </div>

                                <span id="internal_note_validate" class="text-danger validation-error mt-1"></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="" class="form-label">Save As</label>

                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="saveAs" id="home" value="home" checked>
                                    <label class="form-check-label" for="home">
                                        Home
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="saveAs" id="work" value="work">
                                    <label class="form-check-label" for="work">
                                        Work
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="saveAs" id="other" value="other">
                                    <label class="form-check-label" for="other">
                                        Other
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mt-3 mb-3">
                                <label class="form-label" for="cus_tag">Customer Tag (Optional)</label>

                                <select name="cus_tag" id="cus_tag" class="form-control">
                                    <option value="new" selected>New</option>
                                    <option value="regular">Regular</option>
                                    <option value="vip">VIP</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="employee">Employee</option>
                                    <option value="probashi">Probashi</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="cus_source">Customer Source</label>

                                <select name="cus_source" id="cus_source" class="form-control">
                                    <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                                    <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                                    <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                                    <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                                    <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                                </select>
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


    {{-- Order Processing --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Order Details</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_type"><strong>Customer Type </strong></label>

                        <select name="cus_type" id="cus_type" class="form-select">
                            <option value="" selected>Ecommerce Type Customer</option>
                        </select>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_name"><strong>Customer Name </strong> <span class="text-danger"> *</span></label>
                        <input type="text" id="cus_name" name="cus_name" class="form-control" />
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_phone"><strong>Phone Number </strong> <span class="text-danger"> *</span></label>
                        <input type="text" id="cus_phone" name="cus_phone" class="form-control" />
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_email"><strong>Email ( Optional ) </strong> </label>
                        <input type="text" id="cus_email" name="cus_email" class="form-control" />
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_address"><strong>Customer Address </strong> <span class="text-danger"> *</span></label>

                        <div class="input-addon-right">
                            <textarea name="cus_address" class="form-control" id="cus_address" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="map_location"><strong>Map Location </strong> <span class="text-danger"> *</span></label>

                        <div class="input-addon-right">
                            <textarea name="map_location" class="form-control" id="map_location" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label"><strong>Save As</strong></label>

                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="home" value="home" checked>
                                <label class="form-check-label" for="home">
                                    Home
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="work" value="work">
                                <label class="form-check-label" for="work">
                                    Work
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="other" value="other">
                                <label class="form-check-label" for="other">
                                    Other
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="additional"><strong>Additional Note </strong> <span class="text-danger"> *</span></label>

                        <div class="input-addon-right">
                            <textarea name="additional" class="form-control" id="additional" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="pickup_location"><strong>Pickup Location </strong></label>

                        <select name="pickup_location" id="pickup_location" class="form-select" required>
                            <option value="" selected disabled>Select Warehouse</option>
                            <option >Banasree Warehouse</option>
                        </select>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="courier_agent"><strong>Assign Delivery Partner </strong></label>

                        <select name="courier_agent" id="courier_agent" class="form-select" required>
                            <option value="" selected disabled>Select Courier Agent</option>
                            <option value="dd" data-image-url="{{ asset('public/admin/assets/images/steadfast.png') }}">SteadFast</option>
                        </select>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="shipping_date"><strong>Shipping Date </strong> </label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr_date">
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="cus_email"><strong>Transaction ID ( Optional ) </strong> </label>
                        <input type="text" id="cus_email" name="cus_email" class="form-control" />
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="amount"><strong>Advance Payment Amount </strong> </label>
                        <input type="text" id="amount" name="advance_amount" class="form-control" />
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="saveAs" id="home" value="home" checked>
                            <label class="form-check-label" for="home">
                                <strong>Flat</strong>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="saveAs" id="work" value="work">
                            <label class="form-check-label" for="work">
                                <strong>Percentage</strong>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="discount"><strong>Discount (Optional) </strong> </label>
                        <input type="number" id="discount" name="discount" class="form-control" />
                    </div>

                    <div class="mb-3 bg-secondary-transparent p-3 rounded-2">
                        <label class="form-label" for="delivery_type"><strong>Delivery Type </strong> </label>
                        <select name="delivery_type" id="delivery_type" class="form-select" required>
                            <option value="" selected>ঢাকার ভিতরে ডেলিভারি ৮০ টাকা</option>
                            <option value="">চট্টগ্রাম ভিতরে ডেলিভারি ৮০ টাকা</option>
                            <option value="">ঢাকার বাহিরে ডেলিভারি ১৩০ টাকা</option>
                        </select>
                    </div>

                    <div class="free_delivery mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" id="free_delivery">
                            <span><strong>Free Delivery</strong></span>
                        </div>
                    </div>

                    <div class="bg-secondary-transparent p-3 rounded-2" style="margin-bottom: 240px;">
                        <label class="form-label" for="cus_source">Customer Source</label>

                        <select name="cus_source" id="cus_source" class="form-control cus_source">
                            <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="order_calculation">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span><strong>SubTotal</strong></span>
                        <span><strong>BDT 2150.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span><strong>(-) Discount</strong></span>
                        <span class="text-danger">- <strong>BDT 200.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span><strong>Delivery Fee</strong></span>
                        <span class="text-success"><strong>BDT 130.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span><strong>(-) Advance Payment</strong></span>
                        <span class="text-danger">- <strong>BDT 200.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><strong>Total Received</strong></span>
                        <span><strong>BDT 1620.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button class="btn btn-square btn-outline-secondary" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <button class="btn btn-square btn-secondary" type="button">Checkout & Proceed</button>
                    </div>
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
                                <td>BDT 750</td>
                                <td>3 kg</td>
                                <td>BDT 2058.75 <del class="ms-1">BDT 2250</del></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('add-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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


    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('cus_name');
        const createBox = document.querySelector('.cus_create_box');
        const historyBox = document.querySelector('.cus_history_box');
    
        searchInput.addEventListener('input', function () {
            if (this.value.trim() === '01833220886') {
                historyBox.classList.add('show');
                createBox.classList.remove('show');
            } 
            else {
                historyBox.classList.remove('show');
                createBox.classList.add('show');
            }
        });

        searchInput.addEventListener('focus', function () {
            if (this.value.trim() === '01833220886') {
                historyBox.classList.add('show');
                createBox.classList.remove('show');
            } 
            else {
                historyBox.classList.remove('show');
                createBox.classList.add('show');
            }
        });
    
        // Optional: hide box when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.search_box')) {
                createBox.classList.remove('show');
                historyBox.classList.remove('show');
            }
        });
    });

    // Product Search
    document.addEventListener('DOMContentLoaded', function () {
        const product_search = document.getElementById('product_search');
        const rt_input = document.getElementById('rt_input');
        const search_msg_show = document.getElementById('search_msg_show');
    
        product_search.addEventListener('input', function () {
            const value = this.value.trim();

            if (this.value.trim() !== '') {
                search_msg_show.classList.remove('d-none');
                rt_input.innerText = value;
            } else {
                search_msg_show.classList.add('d-none');
            }
        });
    });


    // Clear Product Search
    document.addEventListener('DOMContentLoaded', function () {
        const clear_search = document.getElementById('clear_search');
        const product_search = document.getElementById('product_search');
        const search_msg_show = document.getElementById('search_msg_show');
    
        clear_search.addEventListener('click', function () {
            product_search.value = "";
            search_msg_show.classList.add('d-none');
        });
    });

    // Window div scroll
    document.addEventListener('DOMContentLoaded', function () {
        const wrappers = document.querySelectorAll('.scroll-box');

        function adjustHeight() {
            const viewportHeight = window.innerHeight;

            wrappers.forEach(wrapper => {
                const rect = wrapper.getBoundingClientRect();
                const availableHeight = viewportHeight - rect.top - 20;

                if (availableHeight > 0) {
                    wrapper.style.maxHeight = availableHeight + 'px';

                    // Enable scroll only if content exceeds height
                    if (wrapper.scrollHeight > availableHeight) {
                        wrapper.style.overflowY = 'auto';
                    } else {
                        wrapper.style.overflowY = 'hidden';
                    }
                }
            });
        }

        adjustHeight();
        window.addEventListener('resize', adjustHeight);
    });

    // Product increase & increase
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.wg-quantity').forEach(wrapper => {
            const input = wrapper.querySelector('.quantity-product');
            const increaseBtn = wrapper.querySelector('.btn-increase');
            const decreaseBtn = wrapper.querySelector('.btn-decrease');

            increaseBtn.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
            });

            decreaseBtn.addEventListener('click', () => {
                let current = parseInt(input.value);
                if (current > 1) {
                    input.value = current - 1;
                }
            });
        });
    });
</script>

<script>
    $(function() {
        $('#flatpickr_date').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'YYYY/MM/DD hh:mm A'
            }
        });
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


    //____ warranties_id Select2 ____//
    $('.cus_source').select2({
        templateResult: formatState,       
        templateSelection: formatState, 
    });

    $('#courier_agent').select2({
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
            '<span><img src="' + imageUrl + '" style="width: 30px; height: 30px; border-radius: 6px; margin-right: 8px;" /> ' + state.text + '</span>'
        );
        return $state;
    };
</script>
@endpush