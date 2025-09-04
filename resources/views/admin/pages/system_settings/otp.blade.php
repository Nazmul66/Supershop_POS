@extends('admin.layout.master')

@push('add-title')
    OTP Setting
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
@section('system-setting', 'subdrop active')
@section('otp-setting', 'active')


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
                <form action="{{ route('admin.system-settings.otp.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>OTP</h4>
                    </div>

                    <div class="card-body">
                        <div class="localization-info">
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>OTP Type</h6>
                                        <p>Your can configure the type</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="localization-select">
                                        <select class="form-control select2" name="otp_type">
											<option value="" disabled selected>Select</option>
											<option value="sms" {{ old('otp_type', $setting->otp_type) === 'sms' ? 'selected' : '' }}>SMS</option>
											<option value="email" {{ old('otp_type', $setting->otp_type) === 'email' ? 'selected' : '' }}>Email</option>
										</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>OTP Digit Limit</h6>
                                        <p>Select size of the format </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="localization-select">
                                        <select class="form-control select2" name="otp_digit_limit">
											<option value="" disabled selected>Select</option>
											<option value="4" {{ old('otp_digit_limit', $setting->otp_digit_limit) == 4 ? 'selected' : '' }}>4</option>
											<option value="5" {{ old('otp_digit_limit', $setting->otp_digit_limit) == 5 ? 'selected' : '' }}>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>OTP Expire Time</h6>
                                        <p>Select expire time of OTP </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="localization-select">
                                        <select class="form-control select2" name="otp_exp_time">
											<option value="" disabled selected>Select</option>
											<option value="5" {{ old('otp_exp_time', $setting->otp_exp_time) == 5 ? 'selected' : '' }}>5 Minutes</option>
											<option value="10" {{ old('otp_exp_time', $setting->otp_exp_time) == 10 ? 'selected' : '' }}>10 Minutes</option>
                                        </select>
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
    <!-- Select2 Js -->
	<script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script> 
	
    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.select2').select2(); 
        });
  </script>

@endpush