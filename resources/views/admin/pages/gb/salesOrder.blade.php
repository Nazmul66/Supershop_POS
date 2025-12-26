@extends('admin.layout.master')

@push('title')
    Order Details
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

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
    </style>
@endpush

{{-- Active sidebar --}}
@section('faq', 'active')


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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    {{-- OnGoing Order PArt --}}
                    <div class="order_processing mb-5">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-dark icon-tabler icons-tabler-filled tabler_info_circle icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                                </div>
    
                                <div class="dropdown">
                                    <a class="btn btn-secondary" href="#" role="button" aria-expanded="false" data-bs-toggle="modal" data-bs-effect="effect-flip-vertical" data-bs-target="#orderModal">
                                      Pending
                                    </a>
                                </div>
                            </div>
    
                            <div class="d-flex align-items-center justify-content-between">
                                <span>BDT 2250.00</span>
                                <span>Sep 22,2025, 9:45 P.M</span>
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

                    {{-- Delivery Partner --}}
                    <div class="">
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
            </div>
        </div>
    </div>



@endsection


@push('add-js')
<script>
    document.querySelector('.btn_refresh').addEventListener('click', function () {
        const loader = document.querySelector('.loading_zone');
    
        // show loader
        loader.classList.remove('d-none');
    
        // optional: hide again after loading (example)
        setTimeout(() => {
            loader.classList.add('d-none');
        }, 2000);
    });
    </script>
@endpush