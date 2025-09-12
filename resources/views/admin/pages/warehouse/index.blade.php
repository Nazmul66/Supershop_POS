@extends('admin.layout.master')

@push('title')
    Create Warehouse
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

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
@section('peoples', 'active subdrop')
@section('warehouse', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">State</h4>
                <h6>Manage your states</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.warehouse"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.warehouse.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.warehouse"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel"><img src="{{ asset('public/admin/assets/img/icons/excel.svg') }}" alt="img"></a>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
        <div class="page-btn">
            @if(auth("admin")->user()->can("create.warehouse"))
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Warehouse</button>
             @endif
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="overflow: auto;">
                <table class="table table-bordered mb-0" id="datatables">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#SL.</th>
                            <th>Warehouse</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Phone Work</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Create Warehouse</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row" >
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="warehouse">Warehouse <span class="text-danger">*</span></label>
										<input type="text" name="warehouse" id="warehouse" class="form-control">

                                        <span id="warehouse_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3" >
										<label class="form-label" for="employee_id">Contact Person <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="employee_id" id="employee_id">
											<option value="" disabled selected>Select</option>
											<option value="1">Herver</option>
											<option value="2">Steven</option3>
											<option value="3">Gravely</option>
										</select>

                                        <span id="employee_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>	
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="email">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" id="email" name="email">

                                        <span id="email_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>		

								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="phones">Phone <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="phones" name="phone">

                                        <span id="phone_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>	
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="phone_work">Phone(Work)</label>
										<input type="text" class="form-control" id="phone_work" name="phone_work">

                                        <span id="phone_work_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>								
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="address">Address <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="address" name="address">

                                        <span id="address_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10">
									<div class="mb-3">
										<label class="form-label" for="city">City <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="city_id" id="city">
											<option value="" disabled selected>Select</option>

                                            @foreach ($cities as $row)
                                                <option value="{{ $row->id }}">{{ $row->city_name }}</option>	
                                            @endforeach
									
										</select>

                                        <span id="city_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10">
									<div class="mb-3">
										<label class="form-label" for="state">State <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="state_id" id="state">
											<option value="" disabled selected>Select</option>
											@foreach ($states as $row)
                                                <option value="{{ $row->id }}">{{ $row->state_name }}</option>	
                                            @endforeach										
										</select>

                                        <span id="state_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10" data-select2-id="40">
									<div class="mb-3" data-select2-id="39">
										<label class="form-label" for="country">Country <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="country_id" id="country">
											<option value="" disabled selected>Select</option>
											@foreach ($countries as $row)
                                                <option value="{{ $row->id }}">{{ $row->country_name }}</option>	
                                            @endforeach											
										</select>

                                        <span id="country_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="postal_code">Postal Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="postal_code" name="postal_code">

                                        <span id="postal_code_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
							</div>

                            <div class="mb-3">
                                <label class="form-label" for="">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" >
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
                        <h5 class="modal-title" id="myModalLabel">Update Warehouse</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <input type="text" name="id" id="id" hidden>

                            <div class="row" >
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="up_warehouse">Warehouse <span class="text-danger">*</span></label>
										<input type="text" name="warehouse" id="up_warehouse" class="form-control">

                                        <span id="up_warehouse_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3" >
										<label class="form-label" for="up_employee_id">Contact Person <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="employee_id" id="up_employee_id">
											<option value="" disabled selected>Select</option>
											<option value="1">Herver</option>
											<option value="2">Steven</option3>
											<option value="3">Gravely</option>
										</select>

                                        <span id="up_employee_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>	
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="up_email">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" id="up_email" name="email">

                                        <span id="up_email_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>								
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="up_phone">Phone <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="up_phone" name="phone">

                                        <span id="up_phone_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>	
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="up_phone_work">Phone(Work)</label>
										<input type="text" class="form-control" id="up_phone_work" name="phone_work">

                                        <span id="up_phone_work_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>								
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="up_address">Address <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="up_address" name="address">

                                        <span id="up_address_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10">
									<div class="mb-3">
										<label class="form-label" for="up_city">City <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="city_id" id="up_city">
											<option value="" disabled selected>Select</option>

                                            @foreach ($cities as $row)
                                                <option value="{{ $row->id }}">{{ $row->city_name }}</option>	
                                            @endforeach
									
										</select>

                                        <span id="up_city_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10">
									<div class="mb-3">
										<label class="form-label" for="up_state">State <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="state_id" id="up_state">
											<option value="" disabled selected>Select</option>
											@foreach ($states as $row)
                                                <option value="{{ $row->id }}">{{ $row->state_name }}</option>	
                                            @endforeach										
										</select>

                                        <span id="up_state_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6 col-sm-10 col-10" data-select2-id="40">
									<div class="mb-3" data-select2-id="39">
										<label class="form-label" for="up_country">Country <span class="text-danger">*</span></label>
										<select class="select2 form-control" name="country_id" id="up_country">
											<option value="" disabled selected>Select</option>
											@foreach ($countries as $row)
                                                <option value="{{ $row->id }}">{{ $row->country_name }}</option>	
                                            @endforeach											
										</select>

                                        <span id="up_country_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="up_postal_code">Postal Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="up_postal_code" name="postal_code">

                                        <span id="up_postal_code_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
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


        <!-- View Modal -->
        <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View Warehouse List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Warehouse : </label>
                            <span class="text-dark" id="view_warehouse"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Contact Person : </label>
                            <span class="text-dark" id="view_contact_person"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Email : </label>
                            <span class="text-dark" id="view_email"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Phone : </label>
                            <span class="text-dark" id="view_phone"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Phone Work : </label>
                            <span class="text-dark" id="view_phone_work"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Country : </label>
                            <span class="text-dark" id="view_country"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>State : </label>
                            <span class="text-dark" id="view_state"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>City : </label>
                            <span class="text-dark" id="view_city"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Postal Code : </label>
                            <span class="text-dark" id="view_postal_code"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Address : </label>
                            <span class="text-dark" id="view_address"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Created Date : </label>
                            <div id="created_date"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Updated Date : </label>
                            <div id="updated_date"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Status : </label>
                            <div id="view_status"></div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>

@endsection

@push('add-js')
    <!-- Select2 Js -->
    <script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).ready(function() {
                $('.select2').select2();
            });

            // Show Data through Datatable
            let datatables = $('#datatables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.warehouse-data') }}",
                // pageLength: 30,

                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'warehouse',
                    },
                    {
                        data: 'employee_id',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: 'phone_work',
                    },
                    {
                        data: 'country_name',
                    },
                    {
                        data: 'state_name',
                    },
                    {
                        data: 'city_name',
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
                    url: "{{ route('admin.warehouse.status') }}",
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
                    url: "{{ route('admin.warehouse.store') }}",
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

                        $('#warehouse_validate').empty().html(error.warehouse);
                        $('#employee_id_validate').empty().html(error.employee_id);
                        $('#email_validate').empty().html(error.email);
                        $('#phone_validate').empty().html(error.phone);
                        $('#phone_work_validate').empty().html(error.phone_work);
                        $('#address_validate').empty().html(error.address);
                        $('#city_id_validate').empty().html(error.city_id);
                        $('#state_id_validate').empty().html(error.state_id);
                        $('#country_id_validate').empty().html(error.country_id);
                        $('#postal_code_validate').empty().html(error.postal_code);
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
                    url: "{{ url('admin/warehouse') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_warehouse').empty().html(data.warehouse);
                        $('#up_employee_id').empty().html(data.employee_id);
                        $('#up_email').empty().html(data.email);
                        $('#up_phone').empty().html(data.phone);
                        $('#up_phone_work').empty().html(data.phone_work);
                        $('#up_address').empty().html(data.address);
                        $('#up_city_id').empty().html(data.city_id);
                        $('#up_state_id').empty().html(data.state_id);
                        $('#up_country_id').empty().html(data.country_id);
                        $('#up_postal_code').empty().html(data.postal_code);
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
                    url: "{{ url('admin/warehouse') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {

                        swal.fire({
                            title: "Success",
                            text: "Warehouse Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_warehouse_validate').empty().html(error.warehouse);
                        $('#up_employee_id_validate').empty().html(error.employee_id);
                        $('#up_email_validate').empty().html(error.email);
                        $('#up_phone_validate').empty().html(error.phone);
                        $('#up_phone_work_validate').empty().html(error.phone_work);
                        $('#up_address_validate').empty().html(error.address);
                        $('#up_city_id_validate').empty().html(error.city_id);
                        $('#up_state_id_validate').empty().html(error.state_id);
                        $('#up_country_id_validate').empty().html(error.country_id);
                        $('#up_postal_code_validate').empty().html(error.postal_code);
                        $('#up_state_name_validate').empty().html(error.state_name);

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

                            url: "{{ url('admin/warehouse') }}/" + id,
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

            // View Data
            $(document).on("click", '#viewButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/warehouse/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_warehouse').html(data.warehouse);
                        $('#view_contact_person').html(data.employee_id);
                        $('#view_email').html(data.email);
                        $('#view_phone').html(data.phone);
                        $('#view_phone_work').html(data.phone_work);
                        $('#view_country').html(data.country_name);
                        $('#view_state').html(data.state_name);
                        $('#view_city').html(data.city_name);
                        $('#view_postal_code').html(data.postal_code);
                        $('#view_address').html(data.address);
                        $('#created_date').html(res.created_date);
                        $('#updated_date').html(res.updated_date);
                        $('#view_status').html(res.statusHtml);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })
        })

    </script>
@endpush

