@extends('admin.layout.master')

@push('add-title')
    Product Search
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

    <style>
        label{
            font-size: 13px;
            cursor: pointer;
        }
        .search_field{
            color: #000;
            font-size: 0.9rem;
            font-weight: 500;
            width: 250px;
            height: 26px;
            border: 1px solid #dfdfdf;
            padding: 0px 9px;
            border-bottom: 1px solid #9b9797;
            border-radius: 4px;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
        }
        .search_field:focus{
            border-bottom: 2px solid #86b7fe;
        }
        .form-check .form-check-input {
            border-color: #86b7fe;
            outline: 0;
        }
        .table thead tr,
        .table tbody tr {
            border-color: #8d8d8d;
        }
        .table thead tr th{
            font-size: 12px;
            font-weight: 700;
            color: #212B36;
        }
        .table tbody tr td{
            font-size: 11px;
            font-weight: 700;
            color: #212B36;
        }
        .table td {
            padding: 6px 20px !important;
        }
        .fs-md{
            font-size: 11px !important;
        }
        .table tbody tr td:nth-child(4) {
            background-color: #C0FFC0;
            color: red;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('product_search', 'active')


@section('body-content')
    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Stock Search</h4>
                <h6 class="fw-bold text-danger fs-md">( Press ESC to close )</h6>
            </div>
        </div>

        <div class="page-btn">
            @if(auth("admin")->user()->can("create.product"))
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Add Product</a>
             @endif
        </div>
    </div>
    
    {{-- Search Content --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-1">
                    <label for="searchByName">Search <span class="text-danger">[F1]</span>:</label>
                    <input type="text" name="searchByName" class="search_field" id="searchByName" >
                </div>
    
                <div class="d-flex align-items-center gap-1">
                    <label for="searchBybarcode">By Barcode <span class="text-danger">[F3]</span>:</label>
                    <input type="text" name="searchBybarcode" class="search_field" id="searchBybarcode" >
                </div>

                <div class="form-check">
                    <input class="form-check-input" name="showZero" type="checkbox" value="" id="showZero">
                    <label class="" for="showZero">
                        Show with zero(0) <span class="text-danger">[F2]</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Show Search Product Data --}}
    <div class="mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 datatables">
                    <thead>
                        <tr>
                            <th>Barcode or SKU</th>
                            <th>User Barcode</th>
                            <th>Name</th>
                            <th>MRP</th>
                            <th>Balance</th>
                            <th>UOM</th>
                            <th>VAT(%)</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>

                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>
                                <div class="price_show">
                                    2500.00
                                </div>
                            </td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>

                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                        <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>

                         <tr>
                            <td>A000025</td>
                            <td>8942240150072</td>
                            <td>African Organic Willd HOney 500gm</td>
                            <td>2500.00</td>
                            <td>5</td>
                            <td>Pcs</td>
                            <td>0.00</td>
                            <td>Honey</td>
                            <td>Organic Honey</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>

    <script>
         // Show Data through Datatable
         let datatables = $('.datatables').DataTable({
                pageLength: 10,
                scrollCollapse: true,
                scrollY: 400,
                layout: {
                    topStart: ['info','pageLength'],   // ✅ clean dropdown only
                    topEnd: ['paging'],         // ✅ pagination on top right

                    bottomStart: null,          // ❌ remove "Showing entries"
                    bottomEnd: null             // ❌ remove bottom pagination
                },

                language: {
                    lengthMenu: "_MENU_Page_Entries"   // 🔥 remove "Entries per page" text
                }
            });

    </script>

    <script>
        $(document).ready(function () {
            $(document).on('keydown', function (e) {
                switch (e.key) {
                    case 'F1':
                        e.preventDefault(); // ❗ stop browser help
                        $('#searchByName').focus();
                        break;

                    case 'F2':
                        e.preventDefault();
                        let checkbox = $('#showZero');

                        checkbox.prop('checked', !checkbox.prop('checked')); // 🔄 toggle
                        checkbox.focus();
                        break;

                    case 'F3':
                        e.preventDefault();
                        $('#searchBybarcode').focus();
                        break;
                    case 'Escape':
                        e.preventDefault();
                        window.history.back();
                        break;
                }
            });
        });
    </script>
@endpush
