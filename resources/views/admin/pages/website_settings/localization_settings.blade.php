@extends('admin.layout.master')

@push('add-title')
    Localization Setting
@endpush

@push('add-css')
    	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/select2/css/select2.min.css') }}">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

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
					<form action="{{ route('admin.website-settings.localization.update') }}"  method="POST">
						@csrf
						@method('PUT')

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
											<h6 class="mb-1 fw-medium">Timezone</h6>
											<p>Select Time zone in website</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="localization-select ms-sm-auto mb-3">
											<select class="form-control select2" name="timeZone">
											    <option value="" disabled selected>Select</option>
												@foreach (config('setting.time_zone') as $key => $item)
													<option value="{{ $key }}" @if(!empty($setting->timeZone)) @selected($key == $setting->timeZone) @endif>{{ $key }} {{ $item }}</option>
												@endforeach
											</select>
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
											<select class="form-control select2" name="date_format">
											    <option value="" disabled selected>Select</option>
												<option value="numeric_format" {{ old('date_format', $setting->date_format) === 'numeric_format' ? 'selected' : '' }}>01 Jan 2025</option>

												<option value="name_format" {{ old('date_format', $setting->date_format) === 'name_format' ? 'selected' : '' }}>Jul 22 2025</option>
											</select>
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
										<select class="form-control select2" name="time_format">
											    <option value="" disabled selected>Select</option>
												<option value="12_hour" {{ old('time_format', $setting->time_format) === '12_hour' ? 'selected' : '' }}>12 Hours</option>
												<option value="24_hour" {{ old('time_format', $setting->time_format) === '24_hour' ? 'selected' : '' }}>24 Hours</option>
											</select>
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
											<select class="form-control select2" name="month_format">
												<option value="" disabled selected>Select</option>
												<option value="january" @if( $setting->month_format === "january" ) selected @endif>January</option>
												<option value="february" @if( $setting->month_format === "february" ) selected @endif>February</option>
												<option value="march" @if( $setting->month_format === "march" ) selected @endif>March</option>
												<option value="april" @if( $setting->month_format === "april" ) selected @endif>April</option>
												<option value="may" @if( $setting->month_format === "may" ) selected @endif>May</option>
												<option value="june" @if( $setting->month_format === "june" ) selected @endif>June</option>
												<option value="july" @if( $setting->month_format === "july" ) selected @endif>July</option>
												<option value="august" @if( $setting->month_format === "august" ) selected @endif>August</option>
												<option value="september" @if( $setting->month_format === "september" ) selected @endif>September</option>
												<option value="october" @if( $setting->month_format === "october" ) selected @endif>October</option>
												<option value="november" @if( $setting->month_format === "november" ) selected @endif>November</option>
												<option value="december" @if( $setting->month_format === "december" ) selected @endif>December</option>
											</select>
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
											<select class="form-control select2" name="currency_name">
											   <option value="" disabled selected>Select</option>
												@foreach (config('setting.currency_list') as $key => $item)
													<option value="{{ $item }}" @if(!empty($setting->currency_name)) @selected($item == $setting->currency_name) @endif>{{ $item }} ({{ $key }})</option>
												@endforeach
											</select>
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
											<select class="form-control select2" name="currency_symbol">
											    <option value="" disabled selected>Select</option>
												@foreach (config('setting.currencySymbols') as $key => $symbol)
													<option value="{{ $symbol }}"
														@if (!empty($setting) && $setting->currency_symbol == $symbol)
															selected
														@elseif (old('currency_symbol') == $symbol)
															selected
														@endif>
														{{ $symbol }} ({{ $key }})
													</option>
												@endforeach
											</select>
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
										<select class="form-control select2" name="restrict_country">
											<option value="" disabled selected>Select</option>
											<option value="1" {{ old('restrict_country', $setting->restrict_country) == 1 ? 'selected' : '' }}>Allow All Countries</option>
											<option value="0" {{ old('restrict_country', $setting->restrict_country) == 0 ? 'selected' : '' }}>Deny All Countries</option>
										</select>
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
										<div class="localization-select ms-sm-auto mb-3">
											<input type="text" class="form-control allow-files" name="allow_files" value="{{ old('allow_files', $setting->allow_files) }}">
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
											<input type="text" class="form-control" name="file_size" value="{{ old('file_size', $setting->file_size) }}">
											<span class="ms-2 text-gray-9">MB</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="text-end settings-bottom-btn mt-5">
							<button type="submit" class="btn btn-secondary">Update</button>
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
	
	<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>    
	
    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.select2').select2(); 
        });


        const allow_files = new Choices('.allow-files',{
            removeItems: true,
            duplicateItemsAllowed: false,
            removeItemButton: true,
            delimiter: ',',
        });
  </script>

@endpush

