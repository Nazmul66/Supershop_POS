@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('website-setting', 'subdrop active')
@section('localization-setting', 'active')


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
					<h4 class="fs-18 fw-bold">Localization</h4>
				</div>
				<div class="card-body">
					<form action="localization-settings.html">
						<div class="border-bottom mb-3">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-3">
									<span class="fs-18 me-2"><i class="ti ti-list"></i></span> 
									Basic Information
								</h6>
							</div>
							<div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Language</h6>
											<p>Select Language of the Website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-1-hedw" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-3-7crp">English</option>
												<option>Spanish</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-2q2k" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-xwnm-container" aria-controls="select2-xwnm-container"><span class="select2-selection__rendered" id="select2-xwnm-container" role="textbox" aria-readonly="true" title="English">English</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Language Switcher</h6>
											<p>To display in all the pages</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<div class="status-toggle modal-status d-flex justify-content-between align-items-center">
												<input type="checkbox" id="user3" class="check" checked="">
												<label for="user3" class="checktoggle"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Timezone</h6>
											<p>Select Time zone in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-4-ahl1" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-6-dr1j">UTC 5:30</option>
												<option>(UTC+11:00) INR</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-4gq6" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-bs6l-container" aria-controls="select2-bs6l-container"><span class="select2-selection__rendered" id="select2-bs6l-container" role="textbox" aria-readonly="true" title="UTC 5:30">UTC 5:30</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Date format</h6>
											<p>Select date format to display in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-7-yc0x" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-9-a3wr">01 Jan 2025</option>
												<option>Jul 22 2025</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-8-04d1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-43kq-container" aria-controls="select2-43kq-container"><span class="select2-selection__rendered" id="select2-43kq-container" role="textbox" aria-readonly="true" title="01 Jan 2025">01 Jan 2025</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Time Format</h6>
											<p>Select time format to display in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-10-4jhb" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-12-othz">12 Hours</option>
												<option>24 Hours</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-11-fiij" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-w3i8-container" aria-controls="select2-w3i8-container"><span class="select2-selection__rendered" id="select2-w3i8-container" role="textbox" aria-readonly="true" title="12 Hours">12 Hours</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Financial Year</h6>
											<p>Select year for finance </p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-13-bq61" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-15-4vb5">2025</option>
												<option>2026</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-14-l32k" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-sh32-container" aria-controls="select2-sh32-container"><span class="select2-selection__rendered" id="select2-sh32-container" role="textbox" aria-readonly="true" title="2025">2025</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Starting Month</h6>
											<p>Select starting month to display  </p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-16-h28n" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-18-qy86">January</option>
												<option>February</option>
												<option>March</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-17-c8we" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-yt59-container" aria-controls="select2-yt59-container"><span class="select2-selection__rendered" id="select2-yt59-container" role="textbox" aria-readonly="true" title="January">January</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="border-bottom mb-3">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-3">
									<span class="fs-18 me-2"><i class="ti ti-credit-card"></i></span> 
									Currency Settings
								</h6>
							</div>
							<div class="localization-info">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Currency</h6>
											<p>Select Time zone in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-19-hxbp" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-21-lzyp">USA</option>
												<option>India</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-20-9jy5" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-zgoz-container" aria-controls="select2-zgoz-container"><span class="select2-selection__rendered" id="select2-zgoz-container" role="textbox" aria-readonly="true" title="USA">USA</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Currency Symbol</h6>
											<p>Select date format to display in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-22-y4xu" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-24-n0gy">$</option>
												<option>€</option>
												<option>¥</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-23-yt23" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-68zm-container" aria-controls="select2-68zm-container"><span class="select2-selection__rendered" id="select2-68zm-container" role="textbox" aria-readonly="true" title="$">$</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Currency Position</h6>
											<p>Select time format to display in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-25-qqxo" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-27-wzwg">$100</option>
												<option>$400</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-26-crjm" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-yd7y-container" aria-controls="select2-yd7y-container"><span class="select2-selection__rendered" id="select2-yd7y-container" role="textbox" aria-readonly="true" title="$100">$100</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Decimal Separator</h6>
											<p>Select year for finance</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-28-2j5o" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-30-x0zu">.</option>
												<option>.</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-29-2ogq" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-a29s-container" aria-controls="select2-a29s-container"><span class="select2-selection__rendered" id="select2-a29s-container" role="textbox" aria-readonly="true" title=".">.</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Thousand Separator</h6>
											<p>Select starting month to display</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-31-38c1" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-33-zsa9">,</option>
												<option>,</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-32-2a0e" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-sg4q-container" aria-controls="select2-sg4q-container"><span class="select2-selection__rendered" id="select2-sg4q-container" role="textbox" aria-readonly="true" title=",">,</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="border-bottom mb-3">
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-3">
									<span class="fs-18 me-2"><i class="ti ti-map"></i></span> 
									Country Settings
								</h6>
							</div>
							<div class="localization-info">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="mb-1 fw-medium">Countries Restriction</h6>
											<p>Select countries restriction</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="select select2-hidden-accessible" data-select2-id="select2-data-34-pgqo" tabindex="-1" aria-hidden="true">
												<option data-select2-id="select2-data-36-utmr">Allow All Countries</option>
												<option>Deny All Countries</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-35-0rra" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-38t8-container" aria-controls="select2-38t8-container"><span class="select2-selection__rendered" id="select2-38t8-container" role="textbox" aria-readonly="true" title="Allow All Countries">Allow All Countries</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div>
							<div class="card-title-head">
								<h6 class="fs-16 fw-bold mb-3">
									<span class="fs-18 me-2"><i class="ti ti-map"></i></span> 
									File Settings
								</h6>
							</div>
							<div class="localization-info">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3">
											<h6 class="fw-medium mb-1">Allowed Files</h6>
											<p>Select files</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3 w-100">
											<div class="mb-3">
												<div class="bootstrap-tagsinput"><span class="tag label label-info">JPG<span data-role="remove"></span></span> <span class="tag label label-info">GIF<span data-role="remove"></span></span> <span class="tag label label-info">PNG<span data-role="remove"></span></span> <input type="text" placeholder=""></div><input class="input-tags form-control" type="text" data-role="tagsinput" name="specialist" value="JPG,GIF,PNG" style="display: none;">
											</div>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-3 mb-sm-0">
											<h6 class="fw-medium mb-1">Max File Size</h6>
											<p>File size</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3 d-flex align-items-center mb-sm-0">
											<input type="text" class="form-control" value="5000">
											<span class="ms-2 text-gray-9">MB</span>
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
	</div>


@endsection

@push('add-js')

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@endpush

