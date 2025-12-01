@extends('admin.layout.master')

@push('add-title')
    Tax Rate
@endpush

@push('add-css')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active sidebar --}}
@section('financial-setting', 'subdrop active')
@section('taxRate-setting', 'active')


@section('body-content')


<div class="page-header">
	<div class="add-item d-flex">
		<div class="page-title">
			<h4 class="fw-bold">Settings</h4>
			<h6>Manage your settings on portal</h6>
		</div>
	</div>
	<ul class="table-top-head">
		@if(auth("admin")->user()->can("pdf.tax"))
			<li>
				<a data-bs-toggle="tooltip" data-bs-placement="top" href="" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
			</li>
		@endif

		@if(auth("admin")->user()->can("excel.tax"))
			<li>
				<a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel"><img src="{{ asset('public/admin/assets/img/icons/excel.svg') }}" alt="img"></a>
			</li>
		@endif

		<li>
			<a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
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
					<h4>Tax Rates</h4>
					@if(auth("admin")->user()->can("create.tax"))
						<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add New Tax Rate</button>
					@endif
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered mb-0" id="datatables">
							<thead class="g-primary text-white">
								<tr>
									<th>Tax Name</th>
									<th>Tax rates</th>
									<th>Status</th>
									<th>Created On</th>
									<th class="no-sort">Actions</th>
								</tr>
							</thead>
							<tbody>
								{{-- <tr>
									<td>
										VAT
									</td>
									<td>
										10%
									</td>
									<td>
										12 Jan 2025
									</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-tax">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a class="p-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>
								<tr>
									<td>
										CGST
									</td>
									<td>
										08%
									</td>
									<td>
										10 Jan 2025		
									</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-tax">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a class="p-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
										
									</td>
								</tr>
								<tr>
									<td>
										SGST
									</td>
									<td>
										10%
									</td>
									<td>
										06 Jan 2025	
									</td>
									<td class="action-table-data justify-content-end">
										<div class="edit-delete-action">
											<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-tax">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											<a class="p-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
											</a>
										</div>
									</td>
								</tr>																	 --}}
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
					<h5 class="modal-title" id="myModalLabel">Create Tax Rate</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="createForm" enctype="multipart/form-data">
						@csrf

						<div class="mb-3">
							<label for="tax_name" class="form-label">Tax Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="tax_name" name="tax_name" placeholder="Tax name">

							<span id="tax_name_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label for="percentage" class="form-label">Tax Percentage <span class="text-danger">*</span></label>
							<input type="number" class="form-control" id="percentage" name="percentage" placeholder="Tax Percentage">

							<span id="percentage_validate" class="text-danger validation-error mt-1"></span>
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
					<h5 class="modal-title" id="myModalLabel">Update Tax Rate</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
				</div>

				<div class="modal-body">
					<form id="EditForm" enctype="multipart/form-data">
						@csrf
						@method("PUT")

						<input type="text" name="id" id="id" hidden>

						<div class="mb-3">
							<label for="up_tax_name" class="form-label">Tax Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="up_tax_name" name="tax_name" placeholder="Tax name">

							<span id="up_tax_name_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label for="up_percentage" class="form-label">Tax Percentage <span class="text-danger">*</span></label>
							<input type="number" class="form-control" id="up_percentage" name="percentage" placeholder="Tax Percentage">

							<span id="up_percentage_validate" class="text-danger validation-error mt-1"></span>
						</div>

						<div class="mb-3">
							<label class="form-label">Status <span class="text-danger">*</span></label>
							<select class="form-select" id="up_status" name="status">
								<option value="1" selected>Active</option>
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

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
	<script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

	<script>
        $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('#datatables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.financial-settings.taxRate-data') }}",
                // pageLength: 30,

                columns: [
                    {
                        data: 'tax_name',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'percentage',
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'created_by',
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
                    url: "{{ route('admin.financial-settings.taxRate.status') }}",
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
                    url: "{{ route('admin.financial-settings.taxRate.store') }}",
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
						console.log(err);
                        let error = err.responseJSON.errors;

                        $('#tax_name_validate').empty().html(error.tax_name);
                        $('#percentage_validate').empty().html(error.percentage);
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
                    url: "{{ url('admin/financial-settings/taxRate/') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_tax_name').val(data.tax_name);
                        $('#up_percentage').val(data.percentage);
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
                    url: "{{ url('admin/financial-settings/taxRate/') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {

                        swal.fire({
                            title: "Success",
                            text: "Tax Rate Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_tax_name_validate').empty().html(error.tax_name);
                        $('#up_percentage_validate').empty().html(error.percentage);

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

                            url: "{{ url('admin/financial-settings/taxRate/') }}/" + id,
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
        })

    </script>

@endpush
