@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('general-setting', 'subdrop active')
@section('profile-setting', 'active')

@php
	$admin = auth()->guard('admin')->user();
@endphp

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
					<form action="{{ route('admin.general-settings.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="card-title-head">
							<h6 class="fs-16 fw-bold mb-3">
								<span class="fs-16 me-2"><i class="ti ti-user"></i></span> 
								Basic Information
							</h6>
						</div>
						<div class="profile-pic-upload">
							<div class="profile-pic">
								@if ( !empty($setting->image) )
									<span id="imagePreview">
										<img src="{{ asset($setting->image) }}" alt="Preview" style="max-width:60px; display:block; border-radius: 50px;">
									</span>
								@else
									<span id="imagePreview">
										<i class="ti ti-circle-plus mb-1 fs-16"></i> Add Image
									</span>
								@endif
								
							</div>
							<div class="new-employee-field">
								<div class="mb-0">
									<div class="image-upload mb-0">
										<input type="file" name="image" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp">
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
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										Full Name <span class="text-danger">*</span>
									</label>
									<input type="text" name="name" value="{{ old('name', $setting->name) }}" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										User Name <span class="text-danger">*</span>
									</label>
									<input type="text" name="username" value="{{ old('username', $setting->username) }}" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										Phone Number <span class="text-danger">*</span>
									</label>
									<input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">
										Email <span class="text-danger">*</span>
									</label>
									<input type="email" name="email" value="{{ old('email', $setting->email) }}" disabled class="form-control">
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
									<input type="number" class="form-control" value="{{ old('postal_code', $setting->postal_code) }}" name="postal_code">
								</div>
							</div>
						</div>

						<div class="text-end settings-bottom-btn mt-0">
							<button type="submit" class="btn btn-primary">Update</button>
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

	<script>
		// Function to handle image preview
		function previewImage(input, previewId) {
			const file = input.files[0];
			const preview = document.getElementById(previewId);

			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:60px; display:block; border-radius: 50px;">`;
				}
				reader.readAsDataURL(file);
			}
		}

		// Attach event listeners
		document.getElementById('imageInput').addEventListener('change', function() {
			previewImage(this, 'imagePreview');
		});
	</script>

@endpush
