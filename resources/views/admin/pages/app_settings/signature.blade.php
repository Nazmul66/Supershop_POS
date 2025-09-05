@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active sidebar --}}
@section('app-setting', 'subdrop active')
@section('signature-setting', 'active')


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
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Signatures</h4>

                    @if(auth("admin")->user()->can("create.banip"))
                        <div class="page-btn">
                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Signature</a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow: auto;">
                        <table class="table mb-0" id="datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th>#SL.</th>
                                    <th>Signature Name</th>
                                    <th>Signature</th>
                                    <th>Status</th>
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
			style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Add Signature</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="createForm" enctype="multipart/form-data">
						@csrf

                        <div class="row new-employee-field">
                            <div class="col-lg-12">
                                <div class="profile-pic-upload">
                                    <div class="profile-pic me-3">
                                        <span id="imagePreview"><i data-feather="plus-circle"></i>Add Image</span>
                                    </div>
                                    <div class="mb-0">
                                        <div class="image-upload mb-0">
                                            <input type="file" name="image" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp">
                                            <div class="image-uploads">
                                                <h4>Upload Image</h4>
                                            </div>
                                        </div>
                                        <p class="mt-2">Image format should be png and jpg</p>
                                    </div>
                                </div>

                                <span id="image_validate" class="text-danger validation-error mt-1"></span>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Signature Name<span> *</span></label>
                                    <input type="text" name="name" class="form-control">

                                    <span id="name_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="statuss">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="statuss" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

						<div class="d-flex justify-content-end align-items-center mt-5">
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
			style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Update Signature</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="EditForm" enctype="multipart/form-data">
						@csrf
						@method("PUT")

						<input type="text" name="id" id="id" hidden>

                        <div class="row new-employee-field">
                            <div class="col-lg-12">
                                <div class="profile-pic-upload">
                                    <div class="profile-pic me-3">
                                        <span id="up_imagePreview"><i data-feather="plus-circle"></i>Add Image</span>
                                    </div>
                                    <div class="mb-0">
                                        <div class="image-upload mb-0">
                                            <input type="file" name="image" id="up_imageInput" accept="image/png, image/jpeg, image/jpg, image/webp">
                                            <div class="image-uploads">
                                                <h4>Upload Image</h4>
                                            </div>
                                        </div>
                                        <p class="mt-2">Image format should be png and jpg</p>
                                    </div>
                                </div>

                                <span id="up_image_validate" class="text-danger validation-error mt-1"></span>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="up_name">Signature Name<span> *</span></label>
                                    <input type="text" name="name" id="up_name" class="form-control">

                                    <span id="up_name_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="up_status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="up_status" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
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

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

    <script>
        function previewImage(input, previewId) {
			const file = input.files[0];
			const preview = document.getElementById(previewId);

			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:100px; display:block; border-radius: 50px;">`;
				}
				reader.readAsDataURL(file);
			}
		}

		// Attach event listeners
		document.getElementById('imageInput').addEventListener('change', function() {
			previewImage(this, 'imagePreview');
		});

		// Attach event listeners
		document.getElementById('up_imageInput').addEventListener('change', function() {
			previewImage(this, 'up_imagePreview');
		});
	</script>

    <script>
		// Show Data through Datatable
		let datatables = $('#datatables').DataTable({
			order: [
				[0, 'desc']
			],
			processing: true,
			serverSide: true,

			ajax: "{{ route('admin.app-settings.signature-data') }}",
			// pageLength: 30,

			columns: [
				{ 
					data: 'DT_RowIndex', 
					name: 'DT_RowIndex', 
					orderable: false, 
					searchable: false 
				},
				{
					data: 'name',
				},
				{
					data: 'image',
				},
				{
					data: 'status',
					orderable: false,
					searchable: false,
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
				url: "{{ route('admin.app-settings.signature.status') }}",
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
				url: "{{ route('admin.app-settings.signature.store') }}",
				data: formData,
				processData: false,  // Prevent jQuery from processing the data
				contentType: false,  // Prevent jQuery from setting contentType
				success: function (res) {
					console.log(res);
					if (res.status === true) {
						$('#createModal').modal('hide');
						$('#createForm')[0].reset();
						$('.validation-error').html('');
						$('#imagePreview').html('<i data-feather="plus-circle"></i> Add Image');
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

					$('#name_validate').empty().html(error.name);
					$('#image_validate').empty().html(error.image);

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
				url: "{{ url('admin/app-settings/signature') }}/" + id + "/edit",
				processData: false,  // Prevent jQuery from processing the data
				contentType: false,  // Prevent jQuery from setting contentType
				success: function (res) {
					let data = res.success;

					$('#id').val(data.id);
					$('#up_name').val(data.name);
					$('#up_imagePreview').html('');
                        $('#up_imagePreview').append(`
                            <img src="{{ asset("`+ data.image +`") }}" alt="Preview" style="max-width:100px; display:block; border-radius: 50px;">
                        `);
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
				url: "{{ url('admin/app-settings/signature') }}/" + id,
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

						url: "{{ url('admin/app-settings/signature') }}/" + id,
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