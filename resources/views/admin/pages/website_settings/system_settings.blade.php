@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')

@endpush

{{-- Active sidebar --}}
@section('website-setting', 'subdrop active')
@section('system-setting', 'active')


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

{{-- <input type="checkbox" id="google_map" class="toggle-checkbox" hidden>
<label for="google_map" class="toggle_label">
<span class="toggle-ball"></span>
</label> --}}

<div class="row">
	<div class="col-xl-12">
		 <div class="settings-wrapper d-flex">
			   @include('admin.include.mini-sidebar')
			
			
			<div class="card flex-fill mb-0">
				<div class="card-header">
					<h4 class="fs-18 fw-bold">System Settings</h4>
				</div>
				<div class="card-body pb-0">
					<div class="row">
						<div class="col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<div class="d-flex align-items-center">
											<span class="system-app-icon">
												<img src="{{ asset('public/admin/assets/img/icons/app-icon-07.svg') }}" alt="Img">
											</span>
											<div class="security-title">
												<h5 class="fs-16 fw-medium">Google Captcha</h5>
											</div>
										</div>
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
											
										</div>
									</div>
									<p class="fs-14 mb-3">Captcha helps protect you from spam and password decryption</p>
									<div>
										<a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#google-captcha"><i class="ti ti-tool me-1"></i>View Integration</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<div class="d-flex align-items-center">
											<span class="system-app-icon">
												<img src="{{ asset('public/admin/assets/img/icons/tag.png') }}" alt="Img">
											</span>
											<div class="security-title">
												<h5 class="fs-16 fw-medium">Google Tag Manager</h5>
											</div>
										</div>
									</div>
									<p class="fs-14 mb-3">Provides statistics and basic analytical tools for SEO and marketing purposes.</p>
									<div>
										<a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#google-tag-Manager"><i class="ti ti-tool me-1"></i>View Integration</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<div class="d-flex align-items-center">
											<span class="system-app-icon">
												<img src="{{ asset('public/admin/assets/img/icons/facebook.png') }}" alt="Img">
											</span>
											<div class="security-title">
												<h5 class="fs-16 fw-medium">Facebook Pixel</h5>
											</div>
										</div>
									</div>
									<p class="fs-14 mb-3">Provides a way for publishers to earn money from their online content.</p>
									<div>
										<a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#facebook_pixel_id"><i class="ti ti-tool me-1"></i>View Integration</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<div class="d-flex align-items-center">
											<span class="system-app-icon">
												<img src="{{ asset('public/admin/assets/img/icons/app-icon-10.svg') }}" alt="Img">
											</span>
											<div class="security-title">
												<h5 class="fs-16 fw-medium">Google Map</h5>
											</div>
										</div>
									</div>
									<p class="fs-14 mb-3">Provides detailed information about geographical regions and sites worldwide.</p>
									<div>
										<a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#google_map_id"><i class="ti ti-tool me-1"></i>View Integration</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Configure Google Captcha -->
<div id="google-captcha" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Configure Google Captcha</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.website-settings.system.update') }}" method="POST">
					@csrf
					@method("PUT")

					<div class="row">
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Google Rechaptcha Site Key <span> *</span></label>
								<input type="text" name="rechaptcha_secrect_key" value="{{ $setting->rechaptcha_secrect_key }}" class="form-control">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="mb-0">
								<label class="form-label">Google Rechaptcha Secret Key <span> *</span></label>
								<input type="text" name="rechaptcha_site_key"
								value="{{ $setting->rechaptcha_site_key }}" class="form-control">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end align-items-center mt-3">
						<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close
						</button>

						<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
							Update
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Configure Google Tag Manager -->
<div id="google-tag-Manager" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Configure Google Captcha</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.website-settings.system.update') }}" method="POST">
					@csrf
					@method("PUT")

					<div class="row">
						<div class="col-lg-12">
							<div class="mb-0">
								<label class="form-label">Google Tag Manager <span> *</span></label>
								<input type="text" name="google_tag_manager"
								value="{{ $setting->google_tag_manager }}" class="form-control">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end align-items-center mt-3">
						<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close
						</button>

						<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
							Update
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Configure Google Tag Manager -->
<div id="facebook_pixel_id" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Configure Google Captcha</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.website-settings.system.update') }}" method="POST">
					@csrf
					@method("PUT")

					<div class="row">
						<div class="col-lg-12">
							<div class="mb-0">
								<label class="form-label">Facebook Pixel ID <span> *</span></label>
								<input type="text" name="facebook_pixel_id"
								value="{{ $setting->facebook_pixel_id }}" class="form-control">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end align-items-center mt-3">
						<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close
						</button>

						<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
							Update
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Configure Google Tag Manager -->
<div id="google_map_id" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Configure Google Captcha</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.website-settings.system.update') }}" method="POST">
					@csrf
					@method("PUT")

					<div class="row">
						<div class="col-lg-12">
							<div class="mb-0">
								<label class="form-label">Google Map ID <span> *</span></label>
								<input type="text" name="google_map_id"
								value="{{ $setting->google_map_id }}" class="form-control">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end align-items-center mt-3">
						<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close
						</button>

						<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
							Update
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


@endsection

@push('add-js')

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>


	<script>

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
	</script>
@endpush

