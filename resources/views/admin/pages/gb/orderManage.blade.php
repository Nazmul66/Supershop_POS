@extends('admin.layout.master')

@push('title')
    Order Manage
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
        }
        .search_box .search_filter{
            border: 1px solid #ebebeb;
            width: 100%;
            height: 40px;
            padding-left: 15px;
            color: #212B36;
        }
        .search_box .search_filter::-webkit-input-placeholder,
        .search_box .search_filter::-moz-placeholder,
        .search_box .search_filter::-ms-input-placeholder{
            color: #CACACA;
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
        th .checkboxs .checkmarks, td .checkboxs .checkmarks {
            width: 18px;
            height: 18px;
            border: 1px solid #8c8686 !important;
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
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h2 class="fw-bold">Orders</h2>
                {{-- <h6>Manage your Faqs</h6> --}}
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" style="">
                    <li><a class="dropdown-item" href="javascript:void(0);">Excel</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">PDF</a></li>
                </ul>
            </div>
            <a href="#" class="btn btn-teal ">Create Order</a>
        </div>
    </div>

    {{-- Search Box --}}
    <div class="d-flex align-items-center gap-2 mb-2">
        <div class="search_box">
            <input type="text" placeholder="Search" name="search_filter" class="search_filter" id="search_filter">
            <i class="ti ti-search"></i>
        </div>

        <button type="button" class="btn btn-square btn-secondary d-flex align-items-center gap-2"><i class="ti ti-filter" style="font-size: 20px;"></i> <span class="filter_name">Filter</span></button>
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

    {{-- Tab Button --}}
    <div class="mb-0 border-1">
        <div class="row">
            <div class="mt-0">
                <div class="table-responsive pb-3">
                    <table class="table table-nowrap mb-0">
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
                                            <i class="ti ti-info-circle cursor-pointer" style="font-size: 18px;"></i>
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
        <div class="tooltip-arrow"></div>
        <div class="tooltip-content">
            <div class="mb-0">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
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
    
@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
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