@extends('admin.layout.master')

@push('add-title')
    Create Warranty
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active sidebar --}}
@section('warranty', 'active')


@section('body-content')

    {{-- Breadcrumb --}}
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Warranty</h4>
                <h6>Manage your warranties</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.warranty"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.warranties.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.warranty"))
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
            @if(auth("admin")->user()->can("create.warranty"))
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Warranty</button>
             @endif
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" >
                <table class="table table-bordered mb-0" id="dataTables">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#SL.</th>
                            <th>Warranty</th>
                            <th>Description</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
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
                        <h5 class="modal-title" id="myModalLabel">Create Warranty</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="warranty" class="form-label">Warranty <span class="text-danger">*</span></label>
                                        <input class="form-control" id="warranty" type="text" name="warranty">
        
                                        <span id="warranty_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>

								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="duration">Duration<span class="text-danger ms-1">*</span></label>
										<input class="form-control" id="duration" type="number" name="duration">

                                        <span id="duration_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-6" >
									<div class="mb-3">
										<label class="form-label" for="period">Period<span class="text-danger ms-1">*</span></label>
										<select class="select form-control" id="period" name="period">
											<option value="" selected disabled>Select</option>
											<option value="day">Day</option>
											<option value="month">Month</option>
											<option value="year">Year</option>
										</select>

                                        <span id="period_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
                                
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="description">Description<span class="text-danger ms-1">*</span></label>
										<textarea class="form-control" id="description" name="description"></textarea>

                                        <span id="description_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
							</div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>

                                <span id="status_validate" class="text-danger mt-1"></span>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-secondary waves-effect me-3" data-bs-dismiss="modal">Close
                                </button>

                                <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
                                    Save Changes
                                </button>
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
                        <h5 class="modal-title" id="myModalLabel">Update Warranty</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <input type="text" name="id" id="id" hidden>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="up_warranty" class="form-label">Warranty <span class="text-danger">*</span></label>
                                        <input class="form-control" id="up_warranty" type="text" name="warranty">
        
                                        <span id="up_warranty_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>

								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label" for="up_duration">Duration<span class="text-danger ms-1">*</span></label>
										<input class="form-control" id="up_duration" type="number" name="duration">

                                        <span id="up_duration_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-6" >
									<div class="mb-3">
										<label class="form-label" for="up_period">Period<span class="text-danger ms-1">*</span></label>
										<select class="select form-control" id="up_period" name="period">
											<option value="" selected disabled>Select</option>
											<option value="day">Day</option>
											<option value="month">Month</option>
											<option value="year">Year</option>
										</select>

                                        <span id="up_period_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
                                
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="up_description">Description<span class="text-danger ms-1">*</span></label>
										<textarea class="form-control" id="up_description" name="description"></textarea>

                                        <span id="up_description_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
							</div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="up_status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-secondary waves-effect me-3"  data-bs-dismiss="modal">Close
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


        <!-- View Modal -->
        <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View Warranty List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Warranty : </label>
                            <span class="text-dark" id="view_warranty"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Period : </label>
                            <span class="text-dark" id="view_period"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Duration : </label>
                            <span class="text-dark" id="view_duration"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Description : </label>
                            <span class="text-dark" id="view_description"></span>
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
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('#dataTables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.warranties-data') }}",
                // pageLength: 30,

                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'warranty',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'duration',
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
                    url: "{{ route('admin.warranties.status') }}",
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

            // Create Data
            $('#createForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.warranties.store') }}",
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

                        $('#warranty_validate').empty().html(error.warranty);
                        $('#duration_validate').empty().html(error.duration);
                        $('#period_validate').empty().html(error.period);
                        $('#description_validate').empty().html(error.description);
                        $('#status_validate').empty().html(error.status);

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
                    url: "{{ url('admin/warranties') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_warranty').val(data.warranty);
                        $('#up_duration').val(data.duration);
                        $('#up_period').val(data.period);
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
                    url: "{{ url('admin/warranties') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {

                        swal.fire({
                            title: "Success",
                            text: "Warranty Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_warranty_validate').empty().html(error.warranty);
                        $('#up_duration_validate').empty().html(error.duration);
                        $('#up_period_validate').empty().html(error.period);
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
                            url: "{{ url('admin/warranties') }}/" + id,
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
                        swal.fire('Your Image is Safe');
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
                    url: "{{ url('admin/warranties/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_warranty').html(data.warranty);
                        $('#view_duration').html(data.duration);
                        $('#view_period').html(data.period);
                        $('#view_description').html(data.description);
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

