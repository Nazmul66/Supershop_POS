@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('app-setting', 'subdrop active')
@section('invoice-template', 'active')


@section('body-content')


<div class="page-header">
	<div class="add-item d-flex">
		<div class="page-title">
			<h4 class="fw-bold">Settings</h4>
			<h6>Manage your settings on portal</h6>
		</div>
	</div>
	<ul class="table-top-head">
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
				<i class="ti ti-refresh"></i>
			</a>
		</li>
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse">
				<i class="ti ti-chevron-up"></i>
			</a>
		</li>
	</ul>
</div>


<div class="row">
    <div class="col-xl-12">
         <div class="settings-wrapper d-flex">
            @include('admin.include.mini-sidebar')

            
            <div class="card flex-fill mb-0">
                <form action="invoice-settings.html">
                    <div class="card-header">
                        <h4>Invoice Templates</h4>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <ul class="nav nav-pills low-stock-tab d-flex me-2 mb-0" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Invoices</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Purchases</button>
                                </li>							
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-profile-tab2" data-bs-toggle="pill" data-bs-target="#pills-profile2" type="button" role="tab" aria-controls="pills-profile2" aria-selected="false" tabindex="-1">Receipts</button>
                                </li>							
                            </ul>	
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row gx-3">
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 1</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 2</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 3</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 4</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 5</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row gx-3">
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 1</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 2</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 3</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 4</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-01.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">General Invoice 5</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile2" role="tabpanel" aria-labelledby="pills-profile-tab2">
                                <div class="row gx-3">
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-02.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Receipt Invoice 1</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-02.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Receipt Invoice 2</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-02.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Receipt Invoice 3</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-mg-6">
                                        <div class="card bg-light invoice-card">
                                            <div class="card-body p-2">
                                                <span class="d-block mb-2"><img src="assets/img/invoice/invoice-02.svg" class="w-100" alt="Img"></span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="mb-0">Receipt Invoice 4</p>
                                                    <a href="#" class="avatar avatar-sm rounded-circle bg-secondary-transparent"><i class="ti ti-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>


@endsection

@push('add-js')

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@endpush