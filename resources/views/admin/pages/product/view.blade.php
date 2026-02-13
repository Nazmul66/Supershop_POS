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
        .nav-link {
            color: #646B72;
            font-weight: 500 !important;
        }
        .page-wrapper .nav-pills .nav-link.active {
            color: #ffffff !important;
        }
        .nav-link:hover {
            color: #009688 !important;
        }
        .table.table-bordered.border-primary tbody, .table.table-bordered.border-primary td, .table.table-bordered.border-primary tfoot, .table.table-bordered.border-primary th, .table.table-bordered.border-primary thead, .table.table-bordered.border-primary tr {
            border-color: #b7b7b7;
            border-width: 1px;
            border-style: dashed;
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
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

{{-- Active sidebar --}}
@section('Product', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Product</h4>
                <h6>View product Page</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
            </li>
        </ul>

        <div class="page-btn">
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Back to Product</a>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <div class="header_navbar">
                <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-main-tab" data-bs-toggle="pill" data-bs-target="#pills-main" type="button" role="tab" aria-controls="pills-main" aria-selected="true">Main Info</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-long-description-tab" data-bs-toggle="pill" data-bs-target="#pills-long-description" type="button" role="tab" aria-controls="pills-long-description" aria-selected="false">Long Description</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-return-policy-tab" data-bs-toggle="pill" data-bs-target="#pills-return-policy" type="button" role="tab" aria-controls="pills-return-policy" aria-selected="false">Return Policy</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-shipping-return-tab" data-bs-toggle="pill" data-bs-target="#pills-shipping-return" type="button" role="tab" aria-controls="pills-shipping-return" aria-selected="false">Shipping Return</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-video-link-tab" data-bs-toggle="pill" data-bs-target="#pills-video-link" type="button" role="tab" aria-controls="pills-video-link" aria-selected="false">Video Link</button>
                      </li>

                  </ul>
            </div>
        </div>
    </div>


    <div class="tab-content" id="pills-tabContent">
        {{-- Main Product List --}}
        <div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab" tabindex="0">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product Info</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Element Name</th>
                                            <th style="width: 60%">Element Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Slug</td>
                                            <td>{{ $product->slug }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Category Name</td>
                                            <td>{{ $product->cat_name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>SubCategory Name</td>
                                            <td>{{ $product->subCat_name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>ChildCategory Name</td>
                                            <td>
                                                @if ( !empty( $product->childCat_name ) )
                                                    {{ $product->childCat_name }}
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Brand Name</td>
                                            <td>
                                                <span class="text-dark">{{ $product->brand_name }}</span>
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Is Top Product</td>
                                            <td>
                                                @if ( $product->is_top == 1)
                                                    <span class="badge badge-md bg-primary">Yes</span>
                                                @else
                                                   <span class="badge badge-md bg-danger">No</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Is Best Product</td>
                                            <td>
                                                @if ( $product->is_best == 1)
                                                    <span class="badge badge-md bg-primary">Yes</span>
                                                @else
                                                   <span class="badge badge-md bg-danger">No</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Is Featured Product</td>
                                            <td>
                                                @if ( $product->is_featured == 1)
                                                   <span class="badge badge-md bg-primary">Yes</span>
                                                @else
                                                   <span class="badge badge-md bg-danger">No</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Display Ecommerce</td>
                                            <td>
                                                @if ( $product->display_ecommerce == 1)
                                                   <span class="badge badge-md bg-primary">Yes</span>
                                                @else
                                                   <span class="badge badge-md bg-danger">No</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Is Approved</td>
                                            <td>
                                                @if ( $product->is_approved == 1)
                                                    <span class="badge badge-md bg-info">Approved</span>
                                                @else
                                                    <span class="badge badge-md bg-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                @if ( $product->status == 1)
                                                    <span class="badge badge-md bg-primary">Active</span>
                                                @else
                                                    <span class="badge badge-md bg-danger">Deactive</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Offer Date Start</td>
                                            <td>
                                                @if ( !empty($product->offer_start_date) )
                                                    {{ date('d M, Y', strtotime($product->offer_start_date)) }}
                                                @else
                                                   <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Offer Date End</td>
                                            <td>
                                                @if ( !empty($product->offer_end_date) )
                                                    {{ date('d M, Y', strtotime($product->offer_end_date)) }}
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Tags</td>
                                            <td>
                                                @if($product->tags)
                                                    @foreach(explode(',', $product->tags) as $tag)
                                                        <span class="badge badge-md bg-primary mb-1" style="padding: 8px 12px;">{{ trim($tag) }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No Tags</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Short Description</td>
                                            <td>{{ $product->short_description }}</td>
                                        </tr>

                                        <tr>
                                            <td>Created Date</td>
                                            <td>{{ date('M d, Y - h:i:s A', strtotime($product->created_at)) }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Updated Date</td>
                                            <td>{{ date('M d, Y - h:i:s A', strtotime($product->updated_at)) }}</td>
                                        </tr>

                                        <tr>
                                            @php
                                                $adminName = \App\Models\Admin::find($product->created_by)?->name ?? 'Unknown';
                                                $adminEmail = \App\Models\Admin::find($product->created_by)?->email ?? 'Unknown';
                                                $maskMail = Str::mask($adminEmail, '*', -18, 8);
                                                $adminImage = \App\Models\Admin::find($product->created_by)?->image ?? 'Unknown';
                                            @endphp

                                            <td>Created By</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img  class="rounded-circle me-2" width="40"  height="40" src="{{ asset($adminImage)}}" />
                                                    <div>
                                                        <p class="mb-0">{{ $adminName }}</p> 
                                                        <p class="mb-0">{{ $maskMail }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Meta Title</td>
                                            <td>
                                                @if ( !empty($product->seo_title) )
                                                    <span class="text-dark">{{ $product->seo_title }}</span>
                                                @else
                                                   <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Meta Description</td>
                                            <td>
                                                @if ( !empty($product->seo_description) )
                                                    <span class="text-dark">{{ $product->seo_description }}</span>
                                                @else
                                                   <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-4">
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Thumnail Image</h4>
                            <div class="product_image">
                                <a href="{{ asset($product->thumb_image) }}" target="_blank">
                                    <img src="{{ asset($product->thumb_image) }}" alt="" >
                                </a>
                            </div>
                        </div>
                    </div>  
        
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product QRCode</h4>
                            <div class="product_qrcode">
                                <span>{!! DNS2D::getBarcodeHTML($product->barcode, 'QRCODE') !!}</span>
                            </div>
                        </div>
                    </div>    
        
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product Management</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Element Name</th>
                                            <th style="width: 60%">Element Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Barcode</td>
                                            <td>
                                                <span>{!! DNS1D::getBarcodeHTML($product->barcode, 'EAN13', 2, 50, 'black', true) !!}</span>
                                                <p>Code: {{ $product->barcode }}</p>
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>SKU</td>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Quantity</td>
                                            <td>{{ $product->final_qty .' '. Str::title($product->short_name) }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Purchase Price</td>
                                            <td>{{ getSetting()->currency_name }} {{ $product->purchase_price }} </td>
                                        </tr>
        
                                        <tr>
                                            <td>Selling Price</td>
                                            <td>{{ getSetting()->currency_name }} {{ $product->selling_price }} </td>
                                        </tr>
        
                                        <tr>
                                            <td>Discount Type</td>
                                            <td>{{ ucwords($product->discount_type) }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Discount Value</td>
                                            <td>
                                                @if ( $product->discount_type === "amount" )
                                                {{ getSetting()->currency_name }} {{ $product->discount_value }}
                                                @elseif ( $product->discount_type === "percent" )
                                                    {{ $product->discount_value }}%
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Discount Date</td>
                                            <td>
                                                @php
                                                     $dates = explode(' - ', $product->discount_date);
                                                @endphp
                                                @if ( !empty($product->discount_date) )
                                                    <span><strong>Start:</strong> {{ date('M d, Y - h:i:s A', strtotime($dates[0])) }}</span> <br />
                                                    <span><strong>End:</strong> {{ date('M d, Y - h:i:s A', strtotime($dates[1])) }}</span>
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="pills-long-description" role="tabpanel" aria-labelledby="pills-long-description-tab" tabindex="0">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="multi_description">
                            {!! $product->long_description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="pills-return-policy" role="tabpanel" aria-labelledby="pills-return-policy-tab" tabindex="0">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="multi_description">
                            {!! $product->return_policy !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="pills-shipping-return" role="tabpanel" aria-labelledby="pills-shipping-return-tab" tabindex="0">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="multi_description">
                            {!! $product->shipping_return !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-video-link" role="tabpanel" aria-labelledby="pills-video-link-tab" tabindex="0">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="multi_description">
                            {!! $product->video_link !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('add-js')

@endpush