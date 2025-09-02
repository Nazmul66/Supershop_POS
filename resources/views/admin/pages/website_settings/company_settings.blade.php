@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('website-setting', 'subdrop active')
@section('company-setting', 'active')


@section('body-content')

<div class="page-header settings-pg-header">
	<div class="add-item d-flex">
		<div class="page-title">
			<h4>Settings</h4>
			<h6>Manage your settings on portal</h6>
		</div>
	</div>
	<ul class="table-top-head">
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
		</li>
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
		</li>
	</ul>
</div>



<div class="row">
	<div class="col-xl-12">
		 <div class="settings-wrapper d-flex">
			 @include('admin.include.mini-sidebar')
			
			<div class="card flex-fill mb-0">
				<div class="card-header">
					<h4 class="fs-18 fw-bold">Company Settings</h4>
				</div>
				<div class="card-body">
					<form action="company-settings.html">
						<div class="border-bottom mb-3">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-2">
									<span class="fs-16 me-2"><i class="ti ti-building"></i></span> 
									Company Information
								</h6>
							</div>
							<div class="row">
								<div class="col-xl-4 col-lg-6 col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Company Name  <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-xl-4 col-lg-6 col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Company Email Address  <span class="text-danger">*</span>
										</label>
										<input type="email" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Phone Number <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Fax <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Website <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="border-bottom mb-3 pb-3">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-2">
									<span class="fs-16 me-2"><i class="ti ti-photo"></i></span> 
									Company Images
								</h6>
							</div>
							<div class="row align-items-center gy-3">
								<div class="col-xl-9">
									<div class="row gy-3 align-items-center">
										<div class="col-lg-4">
											<div class="logo-info">
												<h6 class="fw-medium">Company Icon</h6>
												<p>Upload Icon of your Company</p>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="profile-pic-upload mb-0 justify-content-lg-end">
												<div class="new-employee-field">
													<div class="mb-0">
														<div class="image-upload mb-0">
															<input type="file">
															<div class="image-uploads">
																<h4><i class="ti ti-upload me-1"></i>Upload Image</h4>
															</div>
														</div>
														<span class="mt-1">Recommended size is 450px x 450px. Max size 5mb.</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="new-logo ms-xl-auto">
										<a href="#">
											<img src="assets/img/logo-small.png" alt="Logo">
											<span><i class="ti ti-x"></i></span>
										</a>
									</div>
								</div>
								<div class="col-xl-9">
									<div class="row gy-3 align-items-center">
										<div class="col-lg-4">
											<div class="logo-info">
												<h6 class="fw-medium">Favicon</h6>
												<p>Upload Favicon of your Company</p>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="profile-pic-upload mb-0 justify-content-lg-end">
												<div class="new-employee-field">
													<div class="mb-0">
														<div class="image-upload mb-0">
															<input type="file">
															<div class="image-uploads">
																<h4><i class="ti ti-upload me-1"></i>Upload Image</h4>
															</div>
														</div>
														<span class="mt-1">Recommended size is 450px x 450px. Max size 5mb.</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="new-logo ms-xl-auto">
										<a href="#">
											<img src="assets/img/logo-small.png" alt="Logo">
											<span><i class="ti ti-x"></i></span>
										</a>
									</div>
								</div>
								<div class="col-xl-9">
									<div class="row gy-3 align-items-center">
										<div class="col-lg-4">
											<div class="logo-info">
												<h6 class="fw-medium">Company Logo</h6>
												<p>Upload Logo of your Company</p>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="profile-pic-upload mb-0 justify-content-lg-end">
												<div class="new-employee-field">
													<div class="mb-0">
														<div class="image-upload mb-0">
															<input type="file">
															<div class="image-uploads">
																<h4><i class="ti ti-upload me-1"></i>Upload Image</h4>
															</div>
														</div>
														<span class="mt-1">Recommended size is 450px x 450px. Max size 5mb.</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-xl-3">
									<div class="new-logo ms-xl-auto">
										<a href="#">
											<img src="assets/img/products/company-logo.svg" alt="Logo">
											<span><i class="ti ti-x"></i></span>
										</a>
									</div>
								</div>
								<div class="col-xl-9">
									<div class="row gy-3 align-items-center">
										<div class="col-lg-4">
											<div class="logo-info">
												<h6 class="fw-medium">Company Dark Logo</h6>
												<p>Upload Logo of your Company</p>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="profile-pic-upload mb-0 justify-content-lg-end">
												<div class="new-employee-field">
													<div class="mb-0">
														<div class="image-upload mb-0">
															<input type="file">
															<div class="image-uploads">
																<h4><i class="ti ti-upload me-1"></i>Upload Image</h4>
															</div>
														</div>
														<span class="mt-1">Recommended size is 450px x 450px. Max size 5mb.</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-xl-3">
									<div class="new-logo ms-xl-auto">
										<a href="#" class="bg-secondary">
											<img src="assets/img/products/white-logo.svg" alt="Logo">
											<span><i class="ti ti-x"></i></span>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="company-address">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-2">
									<span class="fs-16 me-2"><i class="ti ti-map-pin"></i></span> 
									Address Information
								</h6>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">
											Address <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											Country <span class="text-danger">*</span>
										</label>
										<select class="select select2-hidden-accessible" data-select2-id="select2-data-1-aqku" tabindex="-1" aria-hidden="true">
											<option data-select2-id="select2-data-3-qbh7">Select</option>
											<option>USA</option>
											<option>India</option>
											<option>French</option>
											<option>Australia</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-7umj" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-7ma2-container" aria-controls="select2-7ma2-container"><span class="select2-selection__rendered" id="select2-7ma2-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											State <span class="text-danger">*</span>
										</label>
										<select class="select select2-hidden-accessible" data-select2-id="select2-data-4-fv91" tabindex="-1" aria-hidden="true">
											<option data-select2-id="select2-data-6-3m74">Select</option>
											<option>Alaska</option>
											<option>Mexico</option>
											<option>Tasmania</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-au57" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-llbl-container" aria-controls="select2-llbl-container"><span class="select2-selection__rendered" id="select2-llbl-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											City <span class="text-danger">*</span>
										</label>
										<select class="select select2-hidden-accessible" data-select2-id="select2-data-7-h92z" tabindex="-1" aria-hidden="true">
											<option data-select2-id="select2-data-9-8siz">Select</option>
											<option>Anchorage</option>
											<option>Tijuana</option>
											<option>Hobart</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-8-4p4m" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-1fxd-container" aria-controls="select2-1fxd-container"><span class="select2-selection__rendered" id="select2-1fxd-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											Postal Code <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="text-end settings-bottom-btn mt-0">
							<button type="button" class="btn btn-secondary me-2">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
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

