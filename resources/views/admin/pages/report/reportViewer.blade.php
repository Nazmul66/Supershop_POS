<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
	<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">

    <title>Report Viewer</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/assets/img/favicon.png') }}">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/img/apple-touch-icon.png') }}">
    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">
    <!-- animation CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/css/animate.css') }}">
    <!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/tabler-icons/tabler-icons.css') }}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('public/admin/assets/css/main.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: "Inter", sans-serif;
            background: #F0F0F0;
        }
        .nav_border {
            border-bottom: 2px solid #0000003d;
            padding: 2px 0;
        }
        .imp_image{
            width: 18px;
            height: 18px;
            object-fit: cover;
        }
        .play_reverse{
            display: inline-block;
            transform: rotate(180deg);
            margin-top: 2px;
        }
        nav ul{
            display: flex;
            align-items: center;
        }
        nav ul li{    
            border-right: 2px solid #b7b7b7;
        }
        .cursor-pointer{
            cursor: pointer;
        }
        .form_control{
            background: #F0F0F0;
            border: 2px solid #bbbbbb;
            width: 70px;
            padding: 0 4px;
            caret-color: #bbbbbb;
            color: #8d8a8a;
        }
        .dropdown-item {
            padding: 0.25rem 0.9375rem !important;
        }
        .btn-group .btn {
            padding: 0;
            border: none !important;
        }
        .btn-check:checked + .btn, 
        .btn.active, .btn.show, 
        .btn:first-child:active, 
        :not(.btn-check) + .btn:active {
            background-color: transparent !important;
            border-color: none !important;
            color: #000 !important;
        }
        .btn-outline-secondary:hover, 
        .btn-outline-secondary:focus, 
        .btn-outline-secondary.focus, 
        .btn-outline-secondary:active, 
        .btn-outline-secondary.active {
            background-color: transparent !important;
            border: 1px solid transparent !important;
            box-shadow: none;
            color: #000 !important;
        }
        .footer_end{
            background: #F0F0F0;
        }
        .footer_content{
            font-family: "Arimo", sans-serif !important;
            color: #000;
            font-size: 12px;
            font-weight: 500;
        }
        .fs-12{
            font-size: 12px;
        }
        .pr-3{
            padding-right: 15px !important;
        }
        .card_content {
            border: 2px solid #000;
            background: #FFF;
            padding: 20px 10px;
            width: 100%;
            height: 100vh;
            box-shadow: 4px 6px 0px rgba(0, 0, 0, 1);
        }
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .datatables thead tr th,
        .datatables tbody tr td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: break-spaces !important;
        }
        .datatables thead tr th{
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            background: transparent;
            padding: 0 2px 4px !important;
            border-bottom: 2px solid #000;
        }
        .datatables tbody tr td{
           font-size: 9px;
           font-weight: 700;
           color: #000;
           padding: 2px 0;
        }
        .datatables thead th:nth-child(1),
        .datatables tbody td:nth-child(1) {
            width: 120px;
            padding-left: 0 !important;
        }
        .datatables thead th:nth-child(2),
        .datatables tbody td:nth-child(2) {
            width: 40px;
            text-align: start;
            
        }
        .datatables thead th:nth-child(3),
        .datatables tbody td:nth-child(3) {
            width: 90px;
            text-align: start;
        }
        .datatables tbody td:nth-child(4) {
            width: 50px;
            text-align: end;
        }
        .datatables thead th:nth-child(4) .dt-column-title{
            justify-content: end;
        }
    </style>

</head>
<body>
    
    <div class="nav_border" style="background-color: #EEF4F9;">
        <nav class="d-flex justify-content-between align-items-center mx-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('public/admin/assets/images/reportViewer.png') }}" alt="" style="width: 15px;">
                <h4 class="fw-bold text-dark mb-0" style="font-size: 14px;">ReportViewerForm</h4>
            </div>

            <div class="">
                <i class="ti ti-x text-dark fw-bold cursor-pointer" style="font-size: 20px;"></i>
            </div>
        </nav>
    </div>

    <div class="nav_border" style="background-color: #F2F2F2;">
        <nav class="d-flex justify-content-between align-items-center mx-3">
            <ul>
                <li style="padding-right: 15px">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('public/admin/assets/images/Export.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Export PDF">

                        <img src="{{ asset('public/admin/assets/images/Printer.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Print">

                        <img src="{{ asset('public/admin/assets/images/refresh.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Refresh">

                        <img src="{{ asset('public/admin/assets/images/togglePanel.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Toggle Panel">
                    </div>
                </li>

                <li>
                    <div class="d-flex align-items-center gap-3 px-3">
                        <i class="ti ti-player-skip-back cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Prev Skip"></i>

                        <i class="ti ti-player-play play_reverse cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Prev"></i>

                        <i class="ti ti-player-play cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Next"></i>

                        <i class="ti ti-player-skip-forward cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Next Skip"></i>
                    </div>
                </li>

                <li>
                    <div class="d-flex align-items-center gap-3 px-3">
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" class="form_control" name="" id="paging_number" />
                            <p>/ <span class="total_page">1</span></p>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('public/admin/assets/images/product.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Search">

                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('public/admin/assets/images/search.png') }}" alt="" class="imp_image cursor-pointer" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Zoom In/Out">
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" href="javascript:void(0);">50%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">75%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">100%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">150%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">200%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">250%</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Custom</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <div class="sidebar_column">

            </div>
        </div>

        <div class="col-lg-10 px-0 pr-3">
            <div class="main_column">
                <p class="fs-12 mb-0">Main Report</p>

                <div class="inside_table_row">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="card_content">
                                <div class="table-responsive">
                                    <table class="table mb-0 datatables">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>T ID</th>
                                                <th>Barcode</th>
                                                <th>MRP</th>
                                                <th>SAL QTY</th>
                                                <th>VALUE</th>
                                                <th>DISC. AMT</th>
                                                <th>VAT</th>
                                                <th>SPEC. DISC</th>
                                                <th>ADJ. AMT</th>
                                                <th>NET AMT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Discovery Organic Apple Cider Vinegar 500 ml</td>
                                                <td>04</td>
                                                <td>8941140180226</td>
                                                <td>1100.00</td>
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
    </div>


    {{-- Footer End --}}
    <div class="footer_end">
        <div class="row">
            <div class="col-lg-4">
                <p class="footer_content">Current Page No: <span id="current_page">1</span></p>
            </div>

            <div class="col-lg-4">
                <p class="footer_content">Total Page No: <span id="total_page">1</span></p>
            </div>

            <div class="col-lg-4">
                <p class="footer_content">Zoom Factor: <span id="zoom_factor">100%</span></p>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('/public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('public/admin/assets/js/jquery.slimscroll.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/daterangepicker.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('public/admin/assets/js/theme-colorpicker.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/script.js') }}"></script>
    
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Product Search option
            let table = $('.datatables').DataTable({
                pageLength: 20,
                // scrollCollapse: true,
                // scrollY: 420,
                ordering: false,
                lengthChange: false,
                searching: false,
                paging: true,
                info: false,
                layout: {
                    topStart: null,   // ✅ clean dropdown only
                    topEnd: null,         // ✅ pagination on top right
                    bottomStart: null,          // ❌ remove "Showing entries"
                    bottomEnd: null             // ❌ remove bottom pagination
                },
                columnDefs: [
                    { targets: '_all', defaultContent: '' }
                ],
                createdRow: function (row) {
                    if ($(row).hasClass('payment-summary-row')) {
                        $(row).addClass('not-data');
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{!! $error !!}");
            @endforeach
        @endif
    
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </>

</body>
</html>



    

