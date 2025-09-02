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
					<a href="javascript:void(0);" class="btn btn-primary">
						Send test email
					</a>
				</div>
				<div class="card-body pb-0">
					<div class="row">
						<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card">
								<div class="card-body">
									<div class="flex-column align-items-start">
										<div class="d-flex align-items-center justify-content-between w-100 mb-3">
											<h5>PHP Mailer</h5>
											<span class="badge bg-outline-success">Connected</span>
										</div>
										<p class="mb-3">Used to send emails safely and easily via PHP code from a web server.</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											<a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#php-mail">
												<i class="ti ti-tool me-2"></i>View Integration
											</a>
										</div>
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
											<input type="checkbox" id="user1" class="check" checked="">
											<label for="user1" class="checktoggle">	</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card">
								<div class="card-body">
									<div class="flex-column align-items-start">
										<div class="d-flex align-items-center justify-content-between w-100 mb-3">
											<h5>SMTP</h5>
											<span class="badge bg-outline-success">Connected</span>
										</div>
										<p class="mb-3">SMTP is used to send, relay or forward messages from a mail client.</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											<a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#smtp-mail">
												<i class="ti ti-tool me-2"></i>View Integration
											</a>
										</div>
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
											<input type="checkbox" id="user2" class="check" checked="">
											<label for="user2" class="checktoggle">	</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6 d-flex">
							<div class="card">
								<div class="card-body">
									<div class="flex-column align-items-start">
										<div class="d-flex align-items-center justify-content-between w-100 mb-3">
											<h5>SendGrid</h5>
											<span class="badge bg-outline-success">Connected</span>
										</div>
										<p class="mb-3">Cloud-based email marketing tool that assists marketers and developers .</p>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<div>
											<a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#test-mail">
												<i class="ti ti-tool me-2"></i>Connect
											</a>
										</div>
										<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
											<input type="checkbox" id="user3" class="check" checked="">
											<label for="user3" class="checktoggle">	</label>
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
</div>


@endsection

@push('add-js')

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@endpush
