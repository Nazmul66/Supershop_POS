@extends('admin.layout.master')

@push('title')
    Create Product
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add FAQ</button>
             @endif
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">

            <div class="row ">
                <div class="col-md-6">
                    <div class="input-group">
                        <label class="col-4"><b>Product Name</b> <span class="text-danger">*</span></label>
                        <div class="col-8">
                            <input required="" type="text" name="name" class="form-control" id="name" data-next="code" placeholder="Product Name" value="">
                            <span class="error error_name"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <label class="col-4 text-end me-3"><b>Product Code
                                <i data-bs-toggle="tooltip" data-bs-placement="top" title="" class="fas fa-info-circle tp" data-bs-original-title="Also known as SKU. If you leave this field empty, it will be generated automatically." aria-label="Also known as SKU. If you leave this field empty, it will be generated automatically."></i></b>
                        </label>
                        <div class="col-8">
                            <input type="text" name="code" class="form-control" autocomplete="off" id="code" data-next="unit_id" placeholder="Product Code">
                            <input type="hidden" name="auto_generated_code" id="auto_generated_code" value="57330">
                            <span class="error error_code"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('add-js')


@endpush

