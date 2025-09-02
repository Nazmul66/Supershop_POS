@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
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
                <form action="otp-settings.html">
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
                                        <select class="select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="3">SMS</option>
                                            <option>Email</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-4cba-container"><span class="select2-selection__rendered" id="select2-4cba-container" role="textbox" aria-readonly="true" title="SMS">SMS</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
                                        <select class="select select2-hidden-accessible" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="6">4</option>
                                            <option>5</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="5" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-pdgv-container"><span class="select2-selection__rendered" id="select2-pdgv-container" role="textbox" aria-readonly="true" title="4">4</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
                                        <select class="select select2-hidden-accessible" data-select2-id="7" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="9">5 Mins</option>
                                            <option>10 Mins</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="8" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-jkqv-container"><span class="select2-selection__rendered" id="select2-jkqv-container" role="textbox" aria-readonly="true" title="5 Mins">5 Mins</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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