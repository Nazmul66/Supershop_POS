@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')
  	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/select2/css/select2.min.css') }}">

	<style>
		.select2-container .select2-selection--single {
			height: calc(2.25rem + 2px); /* Same as .form-control */
			padding: 0.375rem 0.75rem;   /* Same as input padding */
			border: 1px solid #ced4da;   /* Bootstrap border */
			border-radius: 0.375rem;     /* Bootstrap rounded corners */
		}

		/* Fix the arrow alignment */
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 100%;
			right: 10px;
		}
	</style>
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
					<form action="{{ route('admin.website-settings.company.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						
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
										<input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="form-control">
									</div>
								</div>
								<div class="col-xl-4 col-lg-6 col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Company Email Address  <span class="text-danger">*</span>
										</label>
										<input type="email" name="email" value="{{ old('email', $setting->email) }}" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Phone Number <span class="text-danger">*</span>
										</label>
										<input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Fax <span class="text-danger">*</span>
										</label>
										<input type="text" name="fax" value="{{ old('fax', $setting->fax) }}" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">
											Website <span class="text-danger">*</span>
										</label>
										<input type="link" name="website" value="{{ old('website', $setting->website) }}" class="form-control">
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
															<input type="file" name="icon" id="iconInput" accept="image/png, image/jpeg, image/jpg, image/webp">
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
										<a  href="javascript:void();" data-input="iconInput" data-preview="iconPreview" data-default="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}">
											@if ( !empty($setting->icon) )
												<img id="iconPreview" src="{{ asset($setting->icon) }}" alt="Logo">

												
											@else
												<img id="iconPreview" src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" alt="Logo">
											@endif
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
															<input type="file" name="favicon" id="faviconInput"  accept="image/png, image/jpeg, image/jpg, image/webp">
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
										<a href="javascript:void(0);" data-input="faviconInput" data-preview="faviconPreview" data-default="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}">
											@if ( !empty($setting->favicon) )
												<img id="faviconPreview" src="{{ asset($setting->favicon) }}" alt="Logo">
												
											@else
												<img id="faviconPreview" src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" alt="Logo">
											@endif
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
															<input type="file" name="logo" id="logoIcon"  accept="image/png, image/jpeg, image/jpg, image/webp">
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
										<a href="javascript:void(0);" class="remove-image" data-input="logoIcon" data-preview="logoPreview" data-default="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}">
											@if ( !empty($setting->logo) )
												<img id="logoPreview" src="{{ asset($setting->logo) }}" alt="Logo">
												
										    @else
												<img id="logoPreview" src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" alt="Logo">
											@endif
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
															<input type="file" name="dark_logo" id="darkLogoIcon"  accept="image/png, image/jpeg, image/jpg, image/webp">
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
										<a href="javascript:void(0);" class="remove-image" data-input="darkLogoIcon" data-preview="darkLogoPreview" data-default="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}">
											@if ( !empty($setting->dark_logo) )
												<img id="darkLogoPreview" src="{{ asset($setting->dark_logo) }}" alt="Logo">
												
										    @else
												<img id="darkLogoPreview" src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" alt="Logo">
											@endif
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
										<input type="text" name="address" value="{{ old('address', $setting->address) }}" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											Country <span class="text-danger">*</span>
										</label>
										<select class="form-control select2" name="country">
											<option value="" disabled selected>Select</option>
											<option value="usa">USA</option>
											<option value="bangladesh">Bangladesh</option>
											<option value="french">French</option>
											<option value="australia">Australia</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											State <span class="text-danger">*</span>
										</label>
										<select class="form-control select2" name="state">
											<option value="" disabled selected>Select</option>
											<option>Alaska</option>
											<option>Mexico</option>
											<option>Tasmania</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											City <span class="text-danger">*</span>
										</label>
										<select class="form-control select2" name="city">
											<option value="" disabled selected>Select</option>
											<option>Anchorage</option>
											<option>Tijuana</option>
											<option>Hobart</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">
											Postal Code <span class="text-danger">*</span>
										</label>
										<input type="text" class="form-control" value="{{ old('postal_code', $setting->postal_code) }}" name="postal_code">
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
	<!-- Select2 Js -->
	<script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>


	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});

		// Function to handle image preview
		function previewImage(input, previewId) {
			const file = input.files[0];
			const preview = document.getElementById(previewId);

			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result; // set preview image
				}
				reader.readAsDataURL(file);
			}
		}

		// Attach event listeners
		document.getElementById('iconInput').addEventListener('change', function() {
			previewImage(this, 'iconPreview');
		});

		document.getElementById('faviconInput').addEventListener('change', function() {
			previewImage(this, 'faviconPreview');
		});

		document.getElementById('logoIcon').addEventListener('change', function() {
			previewImage(this, 'logoPreview');
		});

		document.getElementById('darkLogoIcon').addEventListener('change', function() {
			previewImage(this, 'darkLogoPreview');
		});


		// Reset image when cross button clicked
		document.querySelectorAll('.remove-image').forEach(function(el) {
			el.addEventListener('click', function() {
				const inputId = this.dataset.input;       // id of file input
				const previewId = this.dataset.preview;   // id of preview image
				const defaultSrc = this.dataset.default;  // default image path

				// Reset the input
				const input = document.getElementById(inputId);
				input.value = ''; 

				// Set the preview image to default
				const preview = document.getElementById(previewId);
				preview.src = defaultSrc;
			});
		});
		
	</script>

@endpush

