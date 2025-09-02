@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('other-setting', 'subdrop active')
@section('ban-ip-setting', 'active')


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

			<div class="card flex-fill mb-0 w-50">
				<div class="card-header d-flex align-items-center">
					<h5 class="card-title flex-grow-1 mb-0">Ban IP Address</h5>
					<div class="flex-shrink-0">
						<button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-banip"><i class="ti ti-circle-plus me-1"></i>Add Ban IP Address</button>
					</div>
				</div>
				<div class="card-body p-0">												
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th>IP Address</th>
									<th>Reason</th>
									<th>Created On</th>
									<th class="no-sort text-end"></th>
								</tr>
							</thead>
							<tbody>
								<tr>																	
									<td class="text-gray-9 fw-medium">211.11.0.25</td>
									<td>
										<p>Suspicious Activity</p>
									</td>
									<td>25 Apr 2025</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-banip">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>
								<tr>																	
									<td class="text-gray-9 fw-medium">211.03.0.11</td>
									<td>
										<p>Spam or Abuse</p>
									</td>
									<td>18 Mar 2025</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-banip">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>
								<tr>																	
									<td class="text-gray-9 fw-medium">211.24.0.17</td>
									<td>
										<p>Unauthorized Access</p>
									</td>
									<td>06 Feb 2025</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-banip">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>	
								<tr>																	
									<td class="text-gray-9 fw-medium">211.12.0.34</td>
									<td>
										<p>Violation of Terms</p>
									</td>
									<td>02 Jan 2025</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-banip">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>																		
							</tbody>
						</table>
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
