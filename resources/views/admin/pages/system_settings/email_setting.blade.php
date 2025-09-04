@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('system-setting', 'subdrop active')
@section('email-setting', 'active')


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
				<div class="card-header d-flex align-items-center justify-content-between">
					<h4>Email Settings</h4>

				</div>
				<div class="card-body pb-0">
					<form action="{{ route('admin.system-settings.email.update') }}" method="POST">
						@csrf
						@method('PUT')
						
						<div class="row">
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label class="form-label" for="email">
										Email <span class="text-danger">*</span>
									</label>
									<input type="email" name="email" id="email" value="{{ $email_setting->email }}" class="form-control">
								</div>
							</div>
	
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label class="form-label" for="mail_host">
										Mail Host <span class="text-danger">*</span>
									</label>
									<input type="text" value="{{ $email_setting->host }}" id="mail_host" name="host" class="form-control">
								</div>
							</div>
							
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label class="form-label" for="username">
										Username <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" value="{{ $email_setting->username }}" id="username" name="username">
								</div>
							</div>
	
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label class="form-label" for="password">Smtp password <span class="text-danger"> *</span></label>
									<input type="text" class="form-control" value="{{ $email_setting->password }}" id="password" name="password">
								</div>
							</div>
	
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label for="mail_port" class="form-label">Mail Port <span class="text-danger"> *</span></label>
									<input type="text" class="form-control" value="{{ $email_setting->port }}" id="mail_port" name="port">
								</div>
							</div>
	
							<div class="col-12 col-md-6 col-lg-6">
								<div class="mb-3">
									<label class="form-label" for="mail_encryption">Mail Encryption <span class="text-danger"> *</span></label>
									<select name="encryption" class="form-control" id="mail_encryption">
										<option value="tls" @if( $email_setting->encryption === 'tls' ) selected @endif>TLS</option>
										<option value="ssl" @if( $email_setting->encryption === 'ssl' ) selected @endif>SSL</option>
									</select>
								</div>
							</div>
	
							<div class="d-flex align-items-center justify-content-end mb-3">
								<button type="submit" class="btn btn-primary">Save Changes</button>
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
