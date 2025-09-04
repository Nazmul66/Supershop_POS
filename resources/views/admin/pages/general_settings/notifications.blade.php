@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
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
@section('notification-setting', 'active')


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
					<h4 class="fs-18 fw-bold">Notification</h4>
				</div>
				<div class="card-body">
					<div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<h6 class="fw-medium">Desktop Notifications</h6>
							</div>
							<div class="status-toggle modal-status">
								<input type="checkbox" id="desktop_push" class="toggle-checkbox" checked hidden>
                                <label for="desktop_push" class="toggle_label active">
									<span class="toggle-ball"></span>
								</label>
							</div>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<h6 class="fw-medium">Email Notifications</h6>
							</div>
							<div class="status-toggle modal-status">
								<input type="checkbox" id="email_notification" class="toggle-checkbox" checked hidden>
                                <label for="email_notification" class="toggle_label active">
									<span class="toggle-ball"></span>
								</label>
							</div>
						</div>
						<div class="table-responsive notification-table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>General Notification</th>
										<th>Push</th>
										<th>SMS</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											Payment
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="payment_push" class="toggle-checkbox" checked hidden>
												<label for="payment_push" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="payment_sms" class="toggle-checkbox" checked hidden>
												<label for="payment_sms" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="payment_email" class="toggle-checkbox" checked hidden>
												<label for="payment_email" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
									</tr>	

									<tr>
										<td>
											Transaction
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="transaction_push" class="toggle-checkbox" checked hidden>
												<label for="transaction_push" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="transaction_sms" class="toggle-checkbox" checked hidden>
												<label for="transaction_sms" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="transaction_email" class="toggle-checkbox" checked hidden>
												<label for="transaction_email" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
									</tr>	

									<tr>
										<td>
											Email Verification
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="email_verify_push" class="toggle-checkbox" checked hidden>
												<label for="email_verify_push" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="email_verify_sms" class="toggle-checkbox" checked hidden>
												<label for="email_verify_sms" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="email_verify" class="toggle-checkbox" checked hidden>
												<label for="email_verify" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											OTP
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="otp_push" class="toggle-checkbox" checked hidden>
												<label for="otp_push" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="otp_sms" class="toggle-checkbox" checked hidden>
												<label for="otp_sms" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="otp_email" class="toggle-checkbox" checked hidden>
												<label for="otp_email" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											Account
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="account_push" class="toggle-checkbox" checked hidden>
												<label for="account_push" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="account_sms" class="toggle-checkbox" checked hidden>
												<label for="account_sms" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
											</div>
										</td>
										<td>
											<div class="status-toggle modal-status">
												<input type="checkbox" id="account_email" class="toggle-checkbox" checked hidden>
												<label for="account_email" class="toggle_label active">
													<span class="toggle-ball"></span>
												</label>
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
