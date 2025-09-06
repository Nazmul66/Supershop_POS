@extends('admin.layout.master')

@push('add-title')
    Security Profile
@endpush

@push('add-css')
		<!-- Mobile CSS-->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/intltelinput/css/intlTelInput.css') }}">
    	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/intltelinput/css/demo.css') }}">

  <style>   
    .toggle_label {
        width: 34px !important;
        height: 16px !important;
        background: #ccc;
        border-radius: 14px;
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
        transition: background 0.3s;
      }
      
      .toggle_label .toggle-ball {
        width: 12px !important;
        height: 12px !important;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        left: 2px;
        transition: transform 0.3s;
      }
      
      .toggle-checkbox:checked + .toggle_label {
        background: #22c55e;
      }
      
      .toggle-checkbox:checked + .toggle_label .toggle-ball {
        transform: translateX(18px) !important;
      }
  </style>
@endpush

{{-- Active sidebar --}}
@section('general-setting', 'subdrop active')
@section('security-setting', 'active')

@php
	$admin = Auth::guard()->user();
@endphp

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
					<h4 class="fs-18 fw-bold">Security</h4>
				</div>
				<div class="card-body">
					<div>
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-eye-off text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Password</h5>
									<p class="fs-16">Last Changed 22 Dec 2024, 10:30 AM</p>
								</div>
							</div>
							<a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change_password">Change Password</a>
						</div>
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-shield text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Two Factor Authentication</h5>
									<p class="fs-16">Receive codes via SMS or email every time you login</p>
								</div>
							</div>
							<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
								<input type="checkbox" name="status" id="two_factor" class="toggle-checkbox" @if($admin->enable_two_factor == 1) checked @endif hidden>
                                <label for="two_factor" class="toggle_label @if($admin->enable_two_factor == 1) active @endif">
									<span class="toggle-ball"></span>
                                </label>
							</div>
						</div>

						{{-- <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-brand-google text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Google Authentication</h5>
									<p class="fs-16">Connect to Google</p>
								</div>
							</div>
							<div class="d-flex align-items-center">
								<span class="badge bg-outline-success">Connected</span>
								<div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-3">
									<input type="checkbox" id="google_auth" class="toggle-checkbox" checked hidden>
                                    <label for="google_auth" class="toggle_label active">
                                    <span class="toggle-ball"></span>
                                            </label>
								</div>
							</div>
						</div> --}}

						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-tool text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Device Management</h5>
									<p class="fs-16">Manage devices associated with the account</p>
								</div>
							</div>
							<a href="javascript:void(0);" class="btn btn-primary mt-0" data-bs-toggle="modal" data-bs-target="#device_management">Manage</a>
						</div>
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-activity text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Account Activity</h5>
									<p class="fs-16">Manage activities associated with the account</p>
								</div>
							</div>
							<a href="javascript:void(0);" class="btn btn-primary mt-0" data-bs-toggle="modal" data-bs-target="#account_activity">View</a>
						</div>
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-ban text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Deactivate Account</h5>
									<p class="fs-16">This will shutdown your account. Your account will be reactive when you sign in again</p>
								</div>
							</div>
							<a href="javascript:void(0);" class="btn btn-primary mt-0">Deactivate</a>
						</div>
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
							<div class="d-flex align-items-center">
								<span class="avatar avatar-lg border bg-light fs-24 me-2">
									<i class="ti ti-trash text-gray-900 fs-18"></i>
								</span>
								<div>
									<h5 class="fs-16 fw-medium mb-1">Delete Account</h5>
									<p class="fs-16">Your account will be permanently deleted</p>
								</div>
							</div>
							<a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_account">Delete</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Change Password -->
<div id="change_password" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Change Password</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<form id="passwordChangeForm" enctype="multipart/form-data">
					@csrf

					<div class="row">
							<div class="col-lg-12">
								<div class="input-blocks">
									<label class="fw-medium">Current Password <span class="text-danger">*</span></label>
									<div class="pass-group">
									   <input type="password form-control" name="current_pass" id="current_pass" class="form-control settings-pass-input">
									   <span class="toggle-password ti ti-eye-off"></span>
								   </div>

								   <span id="current_pass_validate" class="text-danger validation-error mt-1"></span>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="input-blocks">
									<label class="fw-medium">New Password <span class="text-danger">*</span></label>
									<div class="pass-group" id="passwordInput">
										<input type="password" class="form-control settings-pass-inputs" name="new_pass" id="new_pass">
										<span class="toggle-passwords ti ti-eye-off"></span>
										<span class="pass-checked"></span>
									</div>
									<div class="password-strength" id="passwordStrength">
										<span id="poor"></span>
										<span id="weak"></span>
										<span id="strong"></span>
										<span id="heavy"></span>
									</div>
									<div id="passwordInfo"></div>

									<span id="new_pass_validate" class="text-danger validation-error mt-1"></span>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="input-blocks mb-0">
									<label class="fw-medium">Confirm Password <span class="text-danger">*</span></label>
									<div class="pass-group">
									   <input type="password" class="form-control settings-pass-inputa" name="confirm_pass" id="confirm_pass">
									   <span class="toggle-passworda ti ti-eye-off"></span>
								   </div>

								   <span id="confirm_pass_validate" class="text-danger validation-error mt-1"></span>
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


<!-- Device Management -->
<div id="device_management" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Device Management</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
							<div class="device-management-table">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Device</th>
												<th>Date</th>
												<th>Location</th>
												<th>IP Address</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Chrome - Windows</td>
												<td>15 May 2025, 10:30 AM</td>
												<td>Newyork / USA</td>
												<td>232.222.12.72</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-trash"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>Safari Macos</td>
												<td>10 Apr 2025, 05:15 PM</td>
												<td>Newyork / USA</td>
												<td>224.111.12.75</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-trash"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>Firefox Windows</td>
												<td>15 Mar 2025, 02:40 PM</td>
												<td>Newyork / USA</td>
												<td>111.222.13.28</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-trash"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>Safari Macos</td>
												<td>15 Jan 2025, 08:00 AM</td>
												<td>Newyork / USA</td>
												<td>333.555.10.54</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-trash"></i>
													</a>	
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Account Activity -->
<div id="account_activity" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Account Activity</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
							<div class="device-management-table">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Date</th>
												<th>Device</th>
												<th>Location</th>
												<th>IP Address</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>15 May 2025, 10:30 AM</td>
												<td>Chrome - Windows</td>
												<td>Newyork / USA</td>
												<td>232.222.12.72</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-logout"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>10 Apr 2025, 05:15 PM</td>
												<td>Safari Macos</td>
												<td>Newyork / USA</td>
												<td>224.111.12.75</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-logout"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>15 Mar 2025, 02:40 PM</td>
												<td>Firefox Windows</td>
												<td>Newyork / USA</td>
												<td>111.222.13.28</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-logout"></i>
													</a>	
												</td>
											</tr>
											<tr>
												<td>15 Jan 2025, 08:00 AM</td>
												<td>Safari Macos</td>
												<td>Newyork / USA</td>
												<td>333.555.10.54</td>
												<td>
													<a href="javascript:void(0);" class="btn">
														<i class="ti ti-logout"></i>
													</a>	
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Delete Account -->
<div id="delete_account" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Delete Account</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
			</div>

			<div class="modal-body">
    			<div class="delete-header">
    				<h4 class="fs-16 fw-medium mb-1">Why Are You Deleting Your Account?</h4>
    				<p class="fs-16">We're sorry to see you go! To help us improve, please let us know your reason for deleting your account</p>
    			</div>
    			<div class="form-check d-flex mb-2">
    				<input class="form-check-input" type="radio" name="delete" id="del-acc1">
    				<label class="form-check-label fs-14 ms-2" for="del-acc1">
    					<span class="text-gray-9 fw-medium">No longer using the service</span> 
    					<span class="d-block text-default">I no longer need this service and won’t be using it in the future.</span>
    				</label>
    			</div>
    			<div class="form-check d-flex mb-2">
    				<input class="form-check-input" type="radio" name="delete" id="del-acc2">
    				<label class="form-check-label fs-14 ms-2" for="del-acc2">
    					<span class="text-gray-9 fw-medium">Privacy concerns</span> 
    					<span class="d-block text-default">I am concerned about how my data is handled and want to remove my information.</span>
    				</label>
    			</div>
    			<div class="form-check d-flex mb-2">
    				<input class="form-check-input" type="radio" name="delete" id="del-acc3">
    				<label class="form-check-label fs-14 ms-2" for="del-acc3">
    					<span class="text-gray-9 fw-medium">Too many notifications/emails</span> 
    					<span class="d-block text-default">I’m overwhelmed by the volume of notifications or emails and would like to reduce them.</span>
    				</label>
    			</div>
    			<div class="form-check d-flex mb-2">
    				<input class="form-check-input" type="radio" name="delete" id="del-acc4">
    				<label class="form-check-label fs-14 ms-2" for="del-acc4">
    					<span class="text-gray-9 fw-medium">Poor user experience</span> 
    					<span class="d-block text-default">I’ve had difficulty using the platform, and it didn’t meet my expectations.</span>
    				</label>
    			</div>
    			<div class="form-check d-flex mb-2">
    				<input class="form-check-input" type="radio" name="delete" id="del-acc5" checked="">
    				<label class="form-check-label fs-14 ms-2" for="del-acc5">
    					<span class="text-gray-9 fw-medium">Other (Please specify)</span> 
    				</label>
    			</div>
    			<div class="ms-4">                        
    				<textarea class="form-control" rows="3"></textarea>
    			</div>
    		</div>
    		
    		<div class="modal-footer pt-3">
	           <button type="button" class="btn btn-secondary waves-effect me-3"
						data-bs-dismiss="modal">Close
				</button>

				<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
					Update
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


@endsection

@push('add-js')
		<!-- Validation-->
	<script src="{{ asset('public/admin/assets/js/validation.js') }}"></script>
		
    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

	<!-- Mobile Input -->
	<script src="{{ asset('public/admin/assets/plugins/intltelinput/js/intlTelInput.js') }}"></script>
		
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

		$(document).ready(function () {
			// Password Change
			$('#passwordChangeForm').submit(function (e) {
				e.preventDefault();
				let formData = new FormData(this);

				$.ajax({
					type: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{ route('admin.general-settings.password-change') }}",
					data: formData,
					processData: false,  // Prevent jQuery from processing the data
					contentType: false,  // Prevent jQuery from setting contentType
					success: function (res) {
						console.log(res);
						if (res.status == 1) {
							$('#change_password').modal('hide');
							$('#passwordChangeForm')[0].reset();
							$('.validation-error').html('');

							swal.fire({
								title: "Success",
								text: `${res.message}`,
								icon: "success"
							})
						}
						else if(res.status == 2){
							$('#new_pass_validate').empty().html('Your New password not matched');
							$('#confirm_pass_validate').empty().html('Your Confirm password not matched');

							swal.fire({
								title: "Error",
								text: `${res.message}`,
								icon: "error"
							})
						}
						else{
							$('#current_pass_validate').empty().html(res.message);

							swal.fire({
								title: "Error",
								text: `${res.message}`,
								icon: "error"
							})
						}
					},
					error: function (err) {
						console.log(err);
						let error = err.responseJSON.errors;

						$('#current_pass_validate').empty().html(error.current_pass);
						$('#new_pass_validate').empty().html(error.new_pass);
						$('#confirm_pass_validate').empty().html(error.confirm_pass);

						swal.fire({
							title: "Failed",
							text: "Something Went Wrong !",
							icon: "error"
						})
					}
				});
			})

			// Current Change Check
			$('#current_pass').on('input', function(e){
				var currentPassword = $(this).val();
				// console.log($(this).val());

				$.ajax({
					type: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{ route('admin.general-settings.current.password.check') }}",
					data: { current_password: currentPassword },
					success: function (res) {
						console.log(res);
						if (res.match === true) {
						$('#current_pass_validate').html(`
							<span class="text-success"><strong>Current Password is Correct</strong><i class='bx bx-check'></i></span> 
						`);
						}
						else{
							$('#current_pass_validate').html(`
							<span class="text-danger"><strong>Current Password is Incorrect</strong><i class='bx bx-x'></i></span> 
						`); 
						}
					},
					error: function (err) {
						console.log(err)
					}
				});
			});

			// Get Two factor	
			$('#two_factor').on('change', function () {
				let twoFactor = $(this).is(':checked') ? 1 : 0;
				console.log("Two Factor:", twoFactor);

				$.ajax({
					type: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{ route('admin.general-settings.two.factor.status') }}",
					data: { twoFactor: twoFactor },
					success: function (res) {
						console.log(res);

						if( res.status === true ){
							swal.fire({
								title: "Enable",
								text: `${res.message}`,
								icon: "success"
							})
						}
						else{
							swal.fire({
								title: "Disable",
								text: `${res.message}`,
								icon: "info"
							})
						}
					},
					error: function (err) {
						console.log(err)
					}
				});
			});
		})
	</script>

@endpush
