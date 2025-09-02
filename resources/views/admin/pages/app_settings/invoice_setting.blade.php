@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('app-setting', 'subdrop active')
@section('invoice-setting', 'active')


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
						<h4>Invoice Settings</h4>
					</div>
					<div class="card-body ">
						<ul class="logo-company">
							<li>
								<div class="row">
									<div class="col-md-4">
										<div class="logo-info me-0 mb-3 mb-md-0">
											<h6>Invoice Logo</h6>
											<p>Upload Logo of your Company to display in Invoice</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="profile-pic-upload mb-0 me-0">
											<div class="new-employee-field">
												<div class="mb-3 mb-md-0">
													<div class="image-upload mb-0">
														<input type="file">
														<div class="image-uploads">
															<h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>Upload Photo</h4>
														</div>
													</div>
													<span>For better preview recommended size is 450px x 450px. Max size 5mb.</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="new-logo ms-auto">
											<a href="#"><img src="assets/img/logo-small.png" alt="Logo"></a>
										</div>
									</div>
								</div>																								
							</li>
						</ul>
						<div class="localization-info">
							<div class="row align-items-center">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Invoice Prefix</h6>
										<p>Add prefix to your invoice</p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="localization-select">
										<input type="text" class="form-control" value="INV -">
									</div>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Invoice Due</h6>
										<p>Select due date  to display in Invoice</p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="localization-select d-flex align-items-center fixed-width">
										<select class="select select2-hidden-accessible" data-select2-id="select2-data-1-idrq" tabindex="-1" aria-hidden="true">
											<option data-select2-id="select2-data-3-3fax">5</option>
											<option>6</option>
											<option>7</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-x2s6" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-3mqi-container" aria-controls="select2-3mqi-container"><span class="select2-selection__rendered" id="select2-3mqi-container" role="textbox" aria-readonly="true" title="5">5</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										<span class="ms-2">Days</span>
									</div>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Invoice Round Off</h6>
										<p>Value Roundoff in Invoice</p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="localization-select d-flex align-items-center width-custom">
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center me-3">
											<input type="checkbox" id="user3" class="check" checked="">
											<label for="user3" class="checktoggle"></label>
										</div>
										<select class="select select2-hidden-accessible" data-select2-id="select2-data-4-gm0m" tabindex="-1" aria-hidden="true">
											<option data-select2-id="select2-data-6-i2uv">Round Off Up</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-5zbk" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-ovb2-container" aria-controls="select2-ovb2-container"><span class="select2-selection__rendered" id="select2-ovb2-container" role="textbox" aria-readonly="true" title="Round Off Up">Round Off Up</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Show Company Details</h6>
										<p>Show / Hide Company Details in Invoice</p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="localization-select d-flex align-items-center">
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center me-3">
											<input type="checkbox" id="user4" class="check" checked="">
											<label for="user4" class="checktoggle"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Invoice Header Terms</h6>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="mb-3">
										<textarea rows="4" class="form-control" placeholder="Type your message"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="setting-info">
										<h6>Invoice Footer Terms</h6>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="mb-3">
										<textarea rows="4" class="form-control" placeholder="Type your message"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex align-items-center justify-content-end">
							<button type="button" class="btn btn-secondary me-2">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Changes</button>
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
