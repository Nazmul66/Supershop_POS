@extends('admin.layout.master')

@push('title')
    Create FAQ
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active sidebar --}}
@section('employee', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Employee</h4>
                <h6>Manage your Employees</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.hrm.employee.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.brand"))
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
            @if(auth("admin")->user()->can("create.brand"))
                <a href="{{ route('admin.hrm.employee.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Add Employee</a>
             @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-purple border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white">Total Employee</p>
                        <h4 class="text-white">1007</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-purple-900"><i class="ti ti-users-group"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-teal border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white">Active</p>
                        <h4 class="text-white">1007</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-teal-900"><i class="ti ti-user-star"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white">Inactive</p>
                        <h4 class="text-white">1007</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-secondary-900"><i class="ti ti-user-exclamation"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white">New Joiners</p>
                        <h4 class="text-white">67</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-info-900"><i class="ti ti-user-check"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="overflow: auto;">
                <table class="table table-bordered mb-0" id="datatables">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID.</th>
                            <th>Employee</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Shift</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


        <!-- View Modal -->
        <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
        style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View FAQ List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Question : </label>
                            <span class="text-dark" id="view_question"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Answer : </label>
                            <span class="text-dark" id="view_answer"></span>
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
            let datatables = $('#datatables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.hrm.employee-data') }}",
                // pageLength: 30,

                columns: [
                    { 
                        data: 'employee_code', 
                        name: 'employee_code', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'first_name',
                    },
                    {
                        data: 'designation',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'contact_number',
                    },
                    {
                        data: 'shift',
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
                    url: "{{ route('admin.hrm.employee.status') }}",
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
                    url: "{{ route('admin.faq.store') }}",
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

                        $('#question_validate').empty().html(error.question);
                        $('#answer_validate').empty().html(error.answer);
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
                    url: "{{ url('admin/faq') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_question').val(data.question);
                        $('#up_answer').val(data.answer);
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
                    url: "{{ url('admin/faq') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {

                        swal.fire({
                            title: "Success",
                            text: "Faq Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_question_validate').empty().html(error.question);
                        $('#up_answer_validate').empty().html(error.country_code);

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

                            url: "{{ url('admin/faq') }}/" + id,
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
                    url: "{{ url('admin/faq/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_question').html(data.question);
                        $('#view_answer').html(data.answer);
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

