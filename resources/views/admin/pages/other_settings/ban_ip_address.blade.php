@extends('admin.layout.master')

@push('add-title')
    Ban Ip Address
@endpush

@push('add-css')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/summernote/summernote-bs4.min.css') }}">
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
							<button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Ban IP Address</button>
						</div>
					</div>
					<div class="card-body">												
						<div class="table-responsive" style="overflow: auto;">
							<table class="table mb-0" id="datatables">
								<thead class="thead-light">
									<tr>
										<th>#SL.</th>
										<th>IP Address</th>
										<th>Reason</th>
										<th>Status</th>
										<th>Created On</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Create Modal -->
	<div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
			style="display: none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Add Banned Ip</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="createForm" enctype="multipart/form-data">
						@csrf

						<div class="mb-3">
							<label for="ip_address" class="form-label">IP Address <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="ip_address" name="ip_address">

							<span id="ip_address_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label for="description" class="form-label">Description <span class="text-danger">*</span></label>

							<textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>

							<span id="description_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" name="status">
								<option value="1" selected>Active</option>
								<option value="0">Deactive</option>
							</select>

							<span id="featured_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="d-flex justify-content-end align-items-center">
							<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close </button>

							<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light"> Save changes</button>
						</div>
					</form>
				</div>


			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>


	<!-- Edit Modal -->
	<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
			style="display: none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Update Brand</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="EditForm" enctype="multipart/form-data">
						@csrf
						@method("PUT")

						<input type="text" name="id" id="id" hidden>

						<div class="mb-3">
							<label for="up_ip_address" class="form-label">IP Address <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="up_ip_address" name="ip_address">

							<span id="up_ip_address_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label for="up_description" class="form-label">Description <span class="text-danger">*</span></label>

							<textarea class="form-control" name="description" id="up_description" cols="30" rows="5"></textarea>

							<span id="up_description_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" id="up_status" name="status">
								<option value="1">Active</option>
								<option value="0">Deactive</option>
							</select>
						</div>

						<div class="d-flex justify-content-end align-items-center">
							<button type="button" class="btn btn-secondary waves-effect me-3"
								data-bs-dismiss="modal">Close</button>

							<button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light"> Update </button>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>


@endsection

@push('add-js')
	<script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

	<!-- Summernote JS -->
	<script src="{{ asset('public/admin/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

	<script>

		// Show Data through Datatable
		let datatables = $('#datatables').DataTable({
			order: [
				[0, 'desc']
			],
			processing: true,
			serverSide: true,

			ajax: "{{ route('admin.other-settings.banIp-data') }}",
			// pageLength: 30,

			columns: [
				{ 
					data: 'DT_RowIndex', 
					name: 'DT_RowIndex', 
					orderable: false, 
					searchable: false 
				},
				{
					data: 'ip_address',
				},
				{
					data: 'description',
				},
				{
					data: 'status',
					orderable: false,
					searchable: false,
				},
				{
					data: 'date_time',
				},
				{
					data: 'action',
					orderable: false,
					searchable: false
				},
			]
		});


		// status updates
		$(document).on('click', '#status', function () {
			var id = $(this).data('id');
			var status = $(this).data('status');

			// console.log(id, status);

			$.ajax({
				type: "POST",
				url: "{{ route('admin.other-settings.banIp.status') }}",
				data: {
					// '_token': token,
					id: id,
					status: status
				},
				success: function (res) {
					datatables.ajax.reload();

					if (res.status == 1) {
						swal.fire(
							{
								title: 'Status Changed to Active',
								icon: 'success'
							})
					} else {
						swal.fire(
							{
								title: 'Status Changed to Inactive',
								icon: 'success'
							})
					}
				},
				error: function (err) {
					console.log(err);
				}

			})
		})


		// Create
		$('#createForm').submit(function (e) {
			e.preventDefault();

			let formData = new FormData(this);

			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{ route('admin.other-settings.banIp.store') }}",
				data: formData,
				processData: false,  // Prevent jQuery from processing the data
				contentType: false,  // Prevent jQuery from setting contentType
				success: function (res) {
					console.log(res);
					if (res.status === true) {
						$('#createModal').modal('hide');
						$('#createForm')[0].reset();
						$('.validation-error').html('');
						datatables.ajax.reload();

						swal.fire({
							title: "Success",
							text: `${res.message}`,
							icon: "success"
						})
					}
				},
				error: function (err) {
					let error = err.responseJSON.errors;

					$('#ip_address_validate').empty().html(error.ip_address);
					$('#description_validate').empty().html(error.description);
					$('#featured_validate').empty().html(error.is_featured);

					swal.fire({
						title: "Failed",
						text: "Something Went Wrong !",
						icon: "error"
					})
				}
			});
		})


		// Edit Data
		$(document).on("click", '#editButton', function (e) {
			let id = $(this).attr('data-id');
			// alert(id);

			$.ajax({
				type: 'GET',
				// headers: {
				//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				// },
				url: "{{ url('admin/other-settings/banIp') }}/" + id + "/edit",
				processData: false,  // Prevent jQuery from processing the data
				contentType: false,  // Prevent jQuery from setting contentType
				success: function (res) {
					let data = res.success;

					$('#id').val(data.id);
					$('#up_ip_address').val(data.ip_address);
					$('#up_description').val(data.description);
					$('#up_status').val(data.status);
				},
				error: function (error) {
					console.log('error');
				}

			});
		})


		// Update Data
		$("#EditForm").submit(function (e) {
			e.preventDefault();

			let id = $('#id').val();
			let formData = new FormData(this);

			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{ url('admin/other-settings/banIp') }}/" + id,
				data: formData,
				processData: false,  // Prevent jQuery from processing the data
				contentType: false,  // Prevent jQuery from setting contentType
				success: function (res) {

					swal.fire({
						title: "Success",
						text: "Brand Updated Successfully",
						icon: "success"
					})

					$('#editModal').modal('hide');
					$('#EditForm')[0].reset();
					$('.validation-error').html('');
					datatables.ajax.reload();
				},
				error: function (err) {
					let error = err.responseJSON.errors;

					$('#up_ip_address_validate').empty().html(error.ip_address);
					$('#up_description_validate').empty().html(error.description);

					swal.fire({
						title: "Failed",
						text: "Something Went Wrong !",
						icon: "error"
					})
				}
			});

		});


		// Delete Data
		$(document).on("click", "#deleteBtn", function () {
			let id = $(this).data('id')

			swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this !",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Yes, delete it!"
			})
			.then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'DELETE',

						url: "{{ url('admin/other-settings/banIp') }}/" + id,
						data: {
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						},
						success: function (res) {
							Swal.fire({
								title: "Deleted!",
								text: `${res.message}`,
								icon: "success"
							});

							datatables.ajax.reload();
						},
						error: function (err) {
							console.log('error')
						}
					})

				} else {
					swal.fire('Your Data is Safe');
				}

			})
		})

	</script>

@endpush
