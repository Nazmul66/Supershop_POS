@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('general-setting', 'subdrop active')
@section('profile-setting', 'active')


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
				<div class="card-header">
					<h4 class="fs-18 fw-bold">Profile</h4>
				</div>
				<div class="card-body">
					<form action="general-settings.html">
						<div class="card-title-head">
							<h6 class="fs-16 fw-bold mb-3">
								<span class="fs-16 me-2"><i class="ti ti-user"></i></span> 
								Basic Information
							</h6>
						</div>
						<div class="profile-pic-upload">
							<div class="profile-pic">
								<span>
									<i class="ti ti-circle-plus mb-1 fs-16"></i> Add Image
								</span>
							</div>
							<div class="new-employee-field">
								<div class="mb-0">
									<div class="image-upload mb-0">
										<input type="file">
										<div class="image-uploads">
											<h4>Upload Image</h4>
										</div>
									</div>
									<span class="fs-13 fw-medium mt-2">
										Upload an image below 2 MB, Accepted File format JPG, PNG
									</span>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-4">
								<div class="mb-3">
									<label class="form-label">
										First Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="form-label">
										Last Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="form-label">
										User Name <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control">
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
										Email <span class="text-danger">*</span>
									</label>
									<input type="email" class="form-control">
								</div>
							</div>
						</div>
						<div class="card-title-head">
							<h6 class="fs-16 fw-bold mb-3">
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
									<input type="email" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										Country <span class="text-danger">*</span>
									</label>
									<select class="select select2-hidden-accessible" data-select2-id="select2-data-1-zt49" tabindex="-1" aria-hidden="true">
										<option data-select2-id="select2-data-3-npp9">Select</option>
										<option>USA</option>
										<option>India</option>
										<option>French</option>
										<option>Australia</option>
									</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-r4e5" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-921y-container" aria-controls="select2-921y-container"><span class="select2-selection__rendered" id="select2-921y-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										State <span class="text-danger">*</span>
									</label>
									<select class="select select2-hidden-accessible" data-select2-id="select2-data-4-x1cg" tabindex="-1" aria-hidden="true">
										<option data-select2-id="select2-data-6-tem2">Select</option>
										<option>Alaska</option>
										<option>Mexico</option>
										<option>Tasmania</option>
									</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-4sq2" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-ytxd-container" aria-controls="select2-ytxd-container"><span class="select2-selection__rendered" id="select2-ytxd-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										City <span class="text-danger">*</span>
									</label>
									<select class="select select2-hidden-accessible" data-select2-id="select2-data-7-uv0y" tabindex="-1" aria-hidden="true">
										<option data-select2-id="select2-data-9-k79l">Select</option>
										<option>Anchorage</option>
										<option>Tijuana</option>
										<option>Hobart</option>
									</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-8-ymv0" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-hcfe-container" aria-controls="select2-hcfe-container"><span class="select2-selection__rendered" id="select2-hcfe-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
