@extends('admin.layout.master')

@push('add-title')
    Invoice Setting
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
				<form action="{{ route('admin.app-settings.invoice.setting.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    @method('PUT')

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
														<input type="file" name="invoice_logo" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp">
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
											<a href="javascript:void();" data-input="iconInput" data-preview="imagePreview" data-default="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}">
											@if ( !empty($setting->invoice_logo) )
												<img id="imagePreview" src="{{ asset($setting->invoice_logo) }}" alt="Logo">
											@else
												<img id="imagePreview" src="{{ asset('public/admin/assets/images/no_Image_available.jpg') }}" alt="Logo">
											@endif
											</a>
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
										<input type="text" name="inv_prefix" class="form-control" value="{{ old('inv_prefix', $setting->inv_prefix) }}">
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
										<select class="select2 form-control" name="invoice_due">
											<option value="5" @if( $setting->invoice_due == 5 ) selected @endif>5</option>
											<option value="6" @if( $setting->invoice_due == 6 ) selected @endif>6</option>
											<option value="7" @if( $setting->invoice_due == 7 ) selected @endif>7</option>
										</select>
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
											<input type="checkbox" id="round_off" class="toggle-checkbox" name="inv_round_off" @if($setting->inv_round_off == 1) checked @endif hidden>
											<label for="round_off" class="toggle_label @if($setting->inv_round_off == 1) active @endif">
												<span class="toggle-ball"></span>
											</label>
										</div>
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
											<input type="checkbox" id="show_company" class="toggle-checkbox" name="company_details" @if($setting->company_details == 1) checked @endif hidden>
											<label for="show_company" class="toggle_label  @if($setting->company_details == 1) active @endif">
												<span class="toggle-ball"></span>
											</label>
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
										<textarea rows="4" name="inv_header_term" class="form-control" placeholder="Type your message">{{ old('inv_header_term', $setting->inv_header_term) }}</textarea>
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
										<textarea rows="4" name="inv_footer_term" class="form-control" placeholder="Type your message">{{ old('inv_footer_term', $setting->inv_footer_term) }}</textarea>
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex align-items-center justify-content-end">
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


	<!-- Select2 Js -->
	<script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>
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
					preview.src = e.target.result; // set preview image
				}
				reader.readAsDataURL(file);
			}
		}

		// Attach event listeners
		document.getElementById('imageInput').addEventListener('change', function() {
			previewImage(this, 'imagePreview');
		})
	</script>

	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});

		document.querySelectorAll(".toggle-checkbox").forEach((checkbox) => {
			checkbox.addEventListener("change", function () {
				if (this.checked) {
					console.log("✅ Active for", this.id);
					this.setAttribute("checked", "checked");
					this.nextElementSibling.classList.add("active");
				} else {
					console.log("❌ Inactive for", this.id);
					this.removeAttribute("checked", "");
					this.nextElementSibling.classList.remove("active");
				}
			});
		});

;
	</script>

@endpush
