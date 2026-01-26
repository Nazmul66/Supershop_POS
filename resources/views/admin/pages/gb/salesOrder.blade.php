@extends('admin.layout.master')

@push('title')
    Order Details
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <link href="{{ asset('public/admin/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/admin/assets/css/lightbox.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/daterangepicker.css') }}" />

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
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
        .form-select,
        .form-control{
            font-weight: 600;
        }
        .order_calculation{
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 250px;
            background: #fff;
        }
        #create_customer{
            max-width: 100%;
            width: 500px !important;
        }
        #orderDetails{
            width: 520px !important;
        }
        .or_text_field{
            font-size: 12px;
        }
        .copyright-footer{
            padding: 40px 24px 40px;
        }
        .customer_address .ti-chevron-down{
            position: absolute;
            top: 50%;
            right: 0;
            font-size: 30px;
            transform: translateY(-50%);
        }
        .cus_address_list{
            position: absolute;
            top: 50px;
            left: 0;
            width: 100%;
            background: #FFF;
            z-index: 111;
            box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.25);
            border-radius: 6PX;
            padding: 20px 16px;
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
            transition: all 0.3s ease-in-out;
        }
        .cus_address_list.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        .lb-data .lb-details {
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
            <div class="pageWrapper">
                {{-- Customer Search Option --}}
                <div class="search_box mb-3">
                    <div class="">
                        <h5 class="mb-1">Customer Search</h5>
                        <div class="customer_form_box">
                            <span>+880</span>
                            <input type="text" id="cus_name" name="cus_name" class="customer_search" maxlength="11" minlength="11"/>
                        </div>
                    </div>

                    <div class="cus_create_box ">
                        <div class="user_icon">
                            <i class="ti ti-user"></i>
                        </div>
                        <p class="text-center mb-2">Sorry! Customer not found.</p>
                        <div class="text-center">
                            <button type="button" data-bs-toggle="offcanvas"  data-bs-target="#create_customer" aria-controls="offcanvasRight" class="btn btn-secondary">Add Customer</button>
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

                <div class="scroll-box">
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
                        <button type="button" data-bs-toggle="offcanvas"  data-bs-target="#update_customer" aria-controls="offcanvasRight" class="btn_edit btn btn-outline-secondary">Edit</button>

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
        </div>

        <div class="col-lg-4">
            <div class="">
                {{-- Product Search Option --}}
                <div class="mb-4">
                    <div class="search_box">
                        <h5 class="mb-1" for="product_search">Product Search</h5>
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
                                <a class="image_overflow" href="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}" data-lightbox="image-1">
                                    <img src="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}" alt="" width="85">

                                    <i class="ti ti-adjustments-alt"></i>
                                </a>

                               <div class="">
                                  <h4 class="mb-2">লিচু ফুলের মধু/Lichu Flower Honey</h4>
                                  <p><strong>SKU:</strong> A000121</p>
                               </div>
                           </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-dark fw-bold">Regular</span>
                                    <h5>BDT 600.00</h5>
                                </div>
                                <button type="button" class="btn btn-secondary"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"></path></svg>
                                    Add To Cart</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#warehouse_modal" style="cursor: pointer;">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 0.5 kg</button>
                                <div class="d-flex align-items-center gap-2">
                                    <h6> Check Availibities</h6> <i class="ti ti-info-circle text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                               <a class="image_overflow" href="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" data-lightbox="image-1">
                                    <img src="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" alt="" width="85">

                                    <i class="ti ti-adjustments-alt"></i>
                                </a>

                               <div class="">
                                  <h4 class="mb-2">সুন্দরবনের মধু/Sundarban Honey</h4>
                                  <p><strong>SKU:</strong> A000251</p>
                               </div>
                           </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-dark fw-bold">Regular</span>
                                        <h5>BDT 1700.00</h5>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-dark fw-bold">Sale</span>
                                        <h5>BDT 1550.00</h5>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"></path></svg>
                                    Add To Cart</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-between"  data-bs-effect="effect-scale" data-bs-toggle="modal" href="#warehouse_modal" style="cursor: pointer;">
                                <button type="button" class="btn btn-outline-secondary btn-w-xs">Weight: 1 kg</button>
                                <div class="d-flex align-items-center gap-2">
                                    <h6> Check Availibities</h6> <i class="ti ti-info-circle text-success"></i>
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
                               <a class="image_overflow" href="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}" data-lightbox="image-1">
                                    <img src="{{ asset('public/admin/assets/images/Lichu-Modhu-500g_with-box_v2.webp') }}"  alt="" width="85">

                                    <i class="ti ti-adjustments-alt"></i>
                               </a>

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
    
                            <div class="d-flex align-items-center justify-content-between gap-4 mt-4">
                                <div class="">
                                    <input type="number" class="discount_form form-control d-none" name="discount">
                                    <div class="btn_discount">
                                        <button class="btn btn-outline-success mb-0">Add Discount</button>
                                    </div>
                                </div>


                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-nowrap">BDT 600.00</h6>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="qty" value="1">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                    <i class="ti ti-trash cart_trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="card border border-2 mb-3">
                        <div class="card-header">
                           <div class="d-flex align-items-center gap-2">
                                <a class="image_overflow" href="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" data-lightbox="image-1">
                                   <img src="{{ asset('public/admin/assets/images/WhatsApp_Image_2025-11-04_at_18.51.14_1.webp') }}" alt="" width="85">

                                     <i class="ti ti-adjustments-alt"></i>
                                </a>

                               <div class="">
                                  <h4 class="mb-2">সুন্দরবনের মধু/Sundarban Honey</h4>
                                  <p class="mb-2"><strong>SKU:</strong> A000251</p>
                                  <div class="d-flex align-items-center gap-2">
                                      <h5>BDT 1550.00</h5>
                                      <del>
                                        <h5 style="font-size: 12px;">BDT 1700.00</h5>
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
    
                            <div class="d-flex align-items-center justify-content-between gap-5 mt-4">
                                <div class="">
                                    <p class="text-success mb-0 "><strong>( - 8.82% Discount Applied )</strong></p>
                                    <a href="#" class="text-danger mb-0 text-decoration-underline"><strong>Remove</strong></a>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-nowrap">BDT 1550.00</h6>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="qty" value="1">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                    <i class="ti ti-trash cart_trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="p-3 bg-secondary-transparent text-end">
                        <h4>BDT 2150.00</h4>
                    </div>

                    <div class="text-end mt-2 mb-5">
                        <button class="btn btn-square btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#orderDetails" aria-controls="orderDetails">Next</button>
                   </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Customer Details Update Modal -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="update_customer" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Update Customer</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_type" class="form_labels">Customer Type</label>
                            <select name="cus_type" id="cus_type" class="form-select select_form mt-2">
                                <option value="ecommerce_type" selected>Ecommerce Type Customer</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="mb-4">
                        <div class="bg-input-field">
                            <label for="cus_name" class="form_labels">Customer Name <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_name" name="cus_name" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3 mt-3">
                        <div class="bg-input-field">
                            <label for="cus_phone" class="form_labels">Phone Number <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_phone" name="cus_phone" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3 mt-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Email (optional) </label>
                            <input type="email" id="cus_email" name="cus_email" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Address <span class="text-danger"> *</span></label>

                            <div class="customer_address input-addon-right position-relative">
                                <textarea name="cus_address" class="form-control form_inputs" id="cus_address" cols="30" rows="2" readonly></textarea>

                                <i class="ti ti-chevron-down address_chevron" style="cursor: pointer;"></i>

                                <div class="cus_address_list">
                                    <ul>
                                        <li>
                                            <a href="#" class="d-flex align-items-center justify-content-between mb-2 gap-3">
                                                <p class="mb-0 fw-bold" style="width: 95%; white-space: nowrap; overflow:hidden;">কে-৩৯/৫, ১২২৯ কুড়িল - এনএসইউ রোড</p>

                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-edit" style="font-size: 20px; cursor: pointer;" data-bs-toggle="offcanvas"  data-bs-target="#update_customer_address" aria-controls="offcanvasRight"></i>
                                                    <i class="ti ti-trash ms-1" style="font-size: 20px; cursor: pointer;"></i>
                                                </div>
                                            </a>
                                        </li>

                                        <li >
                                           <a href="#" class="d-flex align-items-center justify-content-between gap-3">
                                                <p class="mb-0 fw-bold" style="width: 95%; white-space: nowrap; overflow:hidden;">k-39/5, 1229 Kuril - NSU Rd k-39/5, 1229 Kuril - NSU Rd k-39/5, 1229 Kuril - NSU Rd</p>
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-edit" style="font-size: 20px; cursor: pointer;" data-bs-toggle="offcanvas"  data-bs-target="#update_customer_address" aria-controls="offcanvasRight"></i>
                                                    <i class="ti ti-trash ms-1" style="font-size: 20px; cursor: pointer;"></i>
                                                </div>
                                           </a>
                                        </li>
                                    </ul>

                                    <div class="text-center mt-3">
                                        <button type="button"  data-bs-toggle="offcanvas"  data-bs-target="#create_customer_address" aria-controls="offcanvasRight" class="btn btn-secondary"><i class="ti ti-user-plus"></i> Add New Address</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="additional_note" class="form_labels">Additional Note (optional)</label>

                            <div class="input-addon-right position-relative">
                                <textarea name="additional_note" class="form-control form_inputs" id="additional_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="internal_note" class="form_labels">Internal Note (optional)</label>

                            <div class="input-addon-right position-relative">
                                <textarea name="internal_note" class="form-control form_inputs" id="internal_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="">
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
    
                    <div class="mt-3 mb-3">
                        <label class="form-label" for="cus_tag">Customer Tag (Optional)</label>
    
                        <select name="cus_tag" id="cus_tag" class="form-control">
                            <option value="new" selected>New</option>
                            <option value="regular">Regular</option>
                            <option value="vip">VIP</option>
                            <option value="fraud">Fraud</option>
                            <option value="corporate">Corporate</option>
                            <option value="employee">Employee</option>
                            <option value="probashi">Probashi</option>
                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label" for="create_cus_source">Customer Source</label>
    
                        <select name="cus_source" id="create_cus_source" class="form-control">
                            <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                        </select>
                    </div>
    
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="offcanvas">Close </button>
    
                        <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Customer Address Create Modal -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="create_customer_address" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Create Customer Address</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Address <span class="text-danger"> *</span></label>

                            <div class="customer_address input-addon-right position-relative">
                                <textarea name="cus_address" class="form-control form_inputs" id="cus_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="map_location" class="form_labels">Map Location <span class="text-danger"> *</span></label>

                            <div class="input-addon-right">
                                <textarea name="map_location" class="form-control form_inputs" id="map_location" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-4">
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
    
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="offcanvas">Close </button>
    
                        <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Customer Address Update Modal -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="update_customer_address" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Update Customer Address</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Address <span class="text-danger"> *</span></label>

                            <div class="customer_address input-addon-right position-relative">
                                <textarea name="cus_address" class="form-control form_inputs" id="cus_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="map_location" class="form_labels">Map Location <span class="text-danger"> *</span></label>

                            <div class="input-addon-right">
                                <textarea name="map_location" class="form-control form_inputs" id="map_location" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-4">
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
    
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="offcanvas">Close </button>
    
                        <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Create Customer --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="create_customer" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Create Customer</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_type" class="form_labels">Customer Type</label>
                            <select name="cus_type" id="cus_type" class="form-select select_form mt-2">
                                <option value="" selected>Ecommerce Type Customer</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="mb-4">
                        <div class="bg-input-field">
                            <label for="cus_name" class="form_labels">Customer Name <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_name" name="cus_name" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3 mt-3">
                        <div class="bg-input-field">
                            <label for="cus_phone" class="form_labels">Phone Number <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_phone" name="cus_phone" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3 mt-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Email (optional) </label>
                            <input type="email" id="cus_email" name="cus_email" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Address <span class="text-danger"> *</span></label>

                            <div class="input-addon-right position-relative">
                                <textarea name="cus_address" class="form-control form_inputs" id="cus_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="additional_note" class="form_labels">Additional Note (optional)</label>

                            <div class="input-addon-right position-relative">
                                <textarea name="additional_note" class="form-control form_inputs" id="additional_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="bg-input-field">
                            <label for="internal_note" class="form_labels">Internal Note (optional)</label>

                            <div class="input-addon-right position-relative">
                                <textarea name="internal_note" class="form-control form_inputs" id="internal_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="">
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
    
                    <div class="mt-3 mb-3">
                        <label class="form-label" for="cus_tag">Customer Tag (Optional)</label>
    
                        <select name="cus_tag" id="cus_tag" class="form-control">
                            <option value="new" selected>New</option>
                            <option value="regular">Regular</option>
                            <option value="vip">VIP</option>
                            <option value="fraud">Fraud</option>
                            <option value="corporate">Corporate</option>
                            <option value="employee">Employee</option>
                            <option value="probashi">Probashi</option>
                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label" for="create_cus_source">Customer Source</label>
    
                        <select name="cus_source" id="create_cus_source" class="form-control">
                            <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                        </select>
                    </div>
    
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" id="btn_close" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="offcanvas">Close </button>
    
                        <button type="submit" id="btn_saves" class="btn btn-success waves-effect waves-light"> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Order Processing --}}
    <div class="offcanvas offcanvas-end"  tabindex="-1" id="orderDetails" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Order Details</h3>
            {{-- <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button> --}}
        </div>

        <div class="offcanvas-body">
            <div class="row">
                <div class="col-lg-12"  style="margin-bottom: 270px;">
                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_type" class="form_labels">Customer Type</label>
                            <select name="cus_type" id="cus_type" class="form-select select_form mt-2">
                                <option value="ecom_type_customer" selected>Ecommerce Type Customer</option>
                                <option value="distributor">Distributor</option>
                                <option value="retialer">Retailer</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_phone" class="form_labels">Phone Number <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_phone" name="cus_phone" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_email" class="form_labels">Customer Email (optional) </label>
                            <input type="email" id="cus_email" name="cus_email" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_name" class="form_labels">Customer Name <span class="text-danger"> *</span></label>
                            <input type="text" id="cus_name" name="cus_name" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_address" class="form_labels">Customer Address <span class="text-danger"> *</span></label>

                            <div class="input-addon-right position-relative">
                                <textarea name="cus_address" class="form-control form_inputs" id="cus_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="map_address" class="form_labels">Map Location <span class="text-danger"> *</span></label>

                            <div class="input-addon-right position-relative">
                                <textarea name="map_address" class="form-control form_inputs" id="map_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label"><strong>Save As</strong></label>

                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="home" value="home" >
                                <label class="form-check-label" for="home">
                                    Home
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="saveAs" id="work" value="work" checked>
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

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="pickup_location" class="form_labels"><strong>Pickup Location </strong></label>
                            <select name="pickup_location" id="pickup_location" class="form-select select_form mt-2">
                                <option value="" selected disabled>Select Warehouse</option>
                                <option >Banasree Warehouse</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="courier_agent" class="form_labels mb-2"><strong>Prefered Delivery Partner </strong></label>
                            <select name="courier_agent" id="courier_agent" class="form-select select_form">
                                <option value="" selected disabled>Select Courier Agent</option>
                                <option value="dd" data-image-url="{{ asset('public/admin/assets/images/steadfast.png') }}">SteadFast</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_source" class="form_labels mb-2"><strong>Customer Source </strong></label>
                            <select name="cus_source" id="cus_source" class="form-select select_form">
                                <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                                <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                                <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                                <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                                <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="cus_type" class="form_labels">Payment Method</label>
                            <select name="cus_type" id="cus_type" class="form-select select_form mt-2">
                                <option value="cod" selected>Cash On Delivery</option>
                                <option value="bkash_agent">Bkash Mercent</option>
                                <option value="nagad">Nagad</option>
                                <option value="pubali_bank">Pubali Bank</option>
                                <option value="ebl">Eastern Bank</option>
                                <option value="bank_asia">Bank Asia</option>
                                <option value="dhaka_bank">Dhaka Bank</option>
                                <option value="ssl_commercez">SSL Commercez</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="shipping_date" class="form_labels"><strong>Shipping Date </strong> <span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_date" name="shipping_date" class="form-control form_inputs" placeholder="YYYY-MM-DD" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="transaction_id" class="form_labels"><strong>Transaction ID ( Optional ) </strong></label>
                            <input type="text" id="transaction_id" name="transaction_id" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="advance_amount" class="form_labels"><strong>Advance Payment Amount </strong></label>
                            <input type="number" id="advance_amount" name="advance_amount" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="discountAs" id="homes" value="homes" checked>
                            <label class="form-check-label" for="homes">
                                <strong>Flat</strong>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="discountAs" id="works" value="works">
                            <label class="form-check-label" for="works">
                                <strong>Percentage</strong>
                            </label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="discount" class="form_labels"><strong>Discount (Optional) </strong></label>
                            <input type="number" id="discount" name="discount" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="additional_note" class="form_labels">Additional Note </label>

                            <div class="input-addon-right position-relative">
                                <textarea name="additional_note" class="form-control form_inputs" id="additional_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="internal_note" class="form_labels">Internal Note </label>

                            <div class="input-addon-right position-relative">
                                <textarea name="internal_note" class="form-control form_inputs" id="internal_note" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="bg-input-field">
                            <label for="delivery_fee" class="form_labels"><strong>Delivery Fee </strong></label>
                            <input type="number" id="delivery_fee" name="delivery_fee" class="form-control form_inputs" placeholder="" />
                        </div>
                    </div>

                    <div class="free_delivery">
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" id="free_delivery">
                            <span><strong>Free Delivery</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order_calculation">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <p class="or_text_field m-0"><strong>SubTotal</strong></p>
                        <span class="or_text_field"><strong>BDT 2150.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <p class="or_text_field m-0"><strong>(-) Discount</strong></p>
                        <span class="or_text_field text-danger">- <strong>BDT 200.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <p class="or_text_field m-0"><strong>Delivery Fee <span class="text-success">(Steadfast)</span> </strong></p>
                        <span class="or_text_field text-success"><strong>BDT 130.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <p class="or_text_field m-0"><strong>(-) Advance Payment</strong></p>
                        <span class="or_text_field text-danger">- <strong>BDT 200.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="or_text_field"><strong>Total Received</strong></span>
                        <span class="or_text_field"><strong>BDT 1620.00</strong></span>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button class="btn btn-square btn-outline-secondary" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Back</button>
                        <button class="btn btn-square btn-secondary" type="button">Proceed to checkout</button>
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

    {{-- Check Warehouse Modal --}}
    <div class="modal effect-scale fade" id="warehouse_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title">Warehouse Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body text-start">
                    <div class="table-responsive pb-3">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>#SL.</th>
                                    <th>Warehouse Name</th>
                                    <th>Warehouse Location</th>
                                    <th>Total Stock Qty</th>
                                    <th>Total Processing Stock</th>
                                    <th>Total In-transit Stock</th>
                                    <th>Total Product Return</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Banasree Warehouse</td>
                                    <td>Banasree B Block</td>
                                    <td>235</td>
                                    <td>120</td>
                                    <td>1036</td>
                                    <td>36</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('add-js')
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

    <script>
        window.onbeforeunload = function () {
            window.scrollTo(0, 0);
        };

        lightbox.option({
            'maxWidth': 500,
            'maxHeight': 500
            'fitImagesInViewport': true,
            'imageFadeDuration': 700,
            'fadeDuration': 700,
            'resizeDuration': 700,
        })
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


    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('cus_name');
        const createBox = document.querySelector('.cus_create_box');
        const historyBox = document.querySelector('.cus_history_box');
    
        searchInput.addEventListener('input', function () {
            if (this.value.trim() === '01833220886') {
                historyBox.classList.add('show');
                createBox.classList.remove('show');
            } 
            else if(this.value.trim() === ''){
                historyBox.classList.remove('show');
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
            else if(this.value.trim() === ''){
                historyBox.classList.remove('show');
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
                const availableHeight = viewportHeight - rect.top;

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

    // Customer address dropdown show
    const chevron = document.querySelector('.address_chevron');
    const addressBox = document.querySelector('.cus_address_list');
    const wrapper = document.querySelector('.customer_address');

    chevron.addEventListener('click', function (e) {
        e.stopPropagation();
        addressBox.classList.toggle('active');
    });

    // click outside to close
    document.addEventListener('click', function (e) {
        if (!wrapper.contains(e.target)) {
            addressBox.classList.remove('active');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const discount_form = document.querySelector('.discount_form');
        const btnContainer = document.querySelector('.btn_discount');

        // Initial Add Note click
        btnContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-outline-success')) {
                enableNote();
            }

            if (e.target.closest('.btn-danger')) {
                cancelNote();
            }

            if (e.target.closest('.btn-success')) {
                saveNote();
            }
        });

        function enableNote() {
            discount_form.classList.remove('d-none');
            discount_form.classList.add('mb-2');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                <button type="button" class="btn btn-sm btn-success ms-1">Save</button>
            `;
        }

        function cancelNote() {
            discount_form.value = '';
            discount_form.classList.add('d-none');
            discount_form.classList.remove('mb-2');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-outline-success mb-0">Add Discount</button>
            `;
        }

        function saveNote() {
            discount_form.classList.add('d-none');
            discount_form.classList.add('mb-2');
            // 🔹 Add AJAX / form submit here if needed
            btnContainer.innerHTML = `
                <button type="button" class="btn btn-outline-success mb-0">Add Discount</button>
            `;
        }
    });
</script>

<script>
    $(function() {
        $('#shipping_date').daterangepicker({
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


    //____ Create Customer Source Select2 ____//
    $('#create_cus_source').select2({
        templateResult: formatState,       
        templateSelection: formatState, 
    });

    //____ Customer Source Select2 ____//
    $('#cus_source').select2({
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