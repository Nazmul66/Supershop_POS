@extends('admin.layout.master')

@push('title')
    Create Payroll
@endpush


@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">

    <style>
        .select2-container {
            display: block !important;
            width: 100% !important;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 37px;
        }
        .select2-selection__arrow {
            height: 37px !important;
        }
        .select2-search--dropdown .select2-search__field {
            outline: none;
        }
        .select2-selection__rendered span{
            display: flex;
            align-items: center;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('payroll-toggle', 'subdrop active')
@section('payroll', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Payroll</h4>
                <h6>Manage your payrolls</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.hrm.payroll.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Payroll</button>
             @endif
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-body">
            <div class="">
                <table class="table table-bordered mb-0" id="datatables">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Salary</th>
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
        <div id="createModal" class="modal fade"  style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Create Payroll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
								<div class="col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="employee_id">Select Employee <span>*</span></label>
										<select class="form-select" name="employee_id" id="employee_id">
                                            <option value="" disabled selected>Select</option>
                                                @foreach ($employees as $row)
                                                    <option value="{{ $row->id }}" data-image-url="{{ asset($row->image) }}">{{ $row->first_name . ' ' . $row->last_name}}</option>
                                                @endforeach
                                        </select>

                                        <span id="employee_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="text-title">
									<h5 class="mb-2">Salary Information</h5>
								</div>
								<div class="mb-3">
									<label class="form-label">Basic Salary <span>*</span></label>
										<input type="number" class="text-form form-control" name="basic_salary">

                                    <span id="basic_salary_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="mb-3 pb-3 border-bottom">
									<p class="fw-semibold text-gray-9 mb-2">Status</p>
									<div class="d-flex align-items-center">
										<div class="form-check me-3">
											<input class="form-check-input" type="radio" value="1" name="status" id="Radio-sm1" checked="">
											<label class="form-check-label" for="Radio-sm1">
												Paid
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="radio" value="0"  name="status" id="Radio-sm2">
											<label class="form-check-label" for="Radio-sm2">
												Unpaid
											</label>
										</div>
									</div>

                                    <span id="status_validate" class="text-danger validation-error mt-1"></span>
								</div>


								<div class="payroll-title">
									<p class="fw-semibold text-gray-9 mb-2">Allowances</p>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="hra_allow">HRA Allowance <span>*</span></label>
										<input type="number" class="form-control" name="hra_allow" id="hra_allow">
									</div>

                                    <span id="hra_allow_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="conveyance">Conveyance <span>*</span></label>
										<input type="number" class="form-control" name="conveyance" id="conveyance">

                                        <span id="conveyance_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="medical_allow">Medical Allowance <span>*</span></label>
										<input type="number" class="form-control" name="medical_allow" id="medical_allow">

                                        <span id="medical_allow_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="bonus">Bonus <span>*</span></label>
										<input type="number" class="form-control" name="bonus" id="bonus">

                                        <span id="bonus_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="payroll-title border-top pt-3">
									<p class="fw-semibold text-gray-9 mb-2">Deductions</p>
								</div>
								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="pf">PF ( Provident Fund ) <span>*</span></label>
										<input type="number" class="form-control"  name="provident_fund" id="pf">

                                        <span id="pf_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="professional_tax">Professional Tax <span>*</span></label>
										<input type="number" class="form-control" name="professional_tax" id="professional_tax">

                                        <span id="professional_tax_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="tds">TDS ( Tax Deducted at Source ) <span>*</span></label>
										<input type="number" class="form-control" name="tds" id="tds">

                                        <span id="tds_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="loan_others">Loans &amp; Others <span>*</span></label>
										<input type="number" class="form-control" name="loan_others" id="loan_others">

                                        <span id="loan_others_validate" class="text-danger validation-error mt-1"></span>
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
        <div id="editModal" class="modal fade"  style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Payroll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <input type="text" name="id" id="id" hidden>

                            <div class="row">
								<div class="col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_employee_id">Select Employee <span>*</span></label>
										<select class="form-select" name="employee_id" id="up_employee_id">
                                            <option value="" disabled selected>Select</option>
                                                @foreach ($employees as $row)
                                                    <option value="{{ $row->id }}" data-image-url="{{ asset($row->image) }}">{{ $row->first_name . ' ' . $row->last_name}}</option>
                                                @endforeach
                                        </select>

                                        <span id="up_employee_id_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>
								<div class="text-title">
									<h5 class="mb-2">Salary Information</h5>
								</div>
								<div class="mb-3">
									<label class="form-label">Basic Salary <span>*</span></label>
										<input type="number" class="text-form form-control" name="basic_salary" id="up_basic_salary">
								</div>
								<div class="mb-3 pb-3 border-bottom">
									<p class="fw-semibold text-gray-9 mb-2">Status</p>
									<div class="d-flex align-items-center">
										<div class="form-check me-3">
											<input class="form-check-input" type="radio" value="1" name="status" id="radio-sm1" checked="">
											<label class="form-check-label" for="radio-sm1">
												Paid
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="radio" value="0"  name="status" id="radio-sm2">
											<label class="form-check-label" for="radio-sm2">
												Unpaid
											</label>
										</div>
									</div>

                                    <span id="up_status_validate" class="text-danger validation-error mt-1"></span>
								</div>


								<div class="payroll-title">
									<p class="fw-semibold text-gray-9 mb-2">Allowances</p>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_hra_allow">HRA Allowance <span>*</span></label>
										<input type="number" class="form-control" name="hra_allow" id="up_hra_allow">
									</div>

                                    <span id="up_hra_allow_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_conveyance">Conveyance <span>*</span></label>
										<input type="number" class="form-control" name="conveyance" id="up_conveyance">

                                        <span id="up_conveyance_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_medical_allow">Medical Allowance <span>*</span></label>
										<input type="number" class="form-control" name="medical_allow" id="up_medical_allow">

                                        <span id="up_medical_allow_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_bonus">Bonus <span>*</span></label>
										<input type="number" class="form-control" name="bonus" id="up_bonus">

                                        <span id="up_bonus_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="payroll-title border-top pt-3">
									<p class="fw-semibold text-gray-9 mb-2">Deductions</p>
								</div>
								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_pf">PF <span>*</span></label>
										<input type="number" class="form-control"  name="provident_fund" id="up_pf">

                                        <span id="up_pf_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_professional_tax">Professional Tax <span>*</span></label>
										<input type="number" class="form-control" name="professional_tax" id="up_professional_tax">

                                        <span id="up_professional_tax_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_tds">TDS <span>*</span></label>
										<input type="number" class="form-control" name="tds" id="up_tds">

                                        <span id="up_tds_validate" class="text-danger validation-error mt-1"></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-12">
									<div class="mb-3">
										<label class="form-label" for="up_loan_others">Loans &amp; Others <span>*</span></label>
										<input type="number" class="form-control" name="loan_others" id="up_loan_others">

                                        <span id="up_loan_others_validate" class="text-danger validation-error mt-1"></span>
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


        <!-- View Modal -->
        <div id="viewModal" class="modal fade"  style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View Payroll List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Employee Code : </label>
                            <span class="text-dark" id="view_employee_code"></span>
                        </div>

                        {{-- <div class="view_modal_content">
                            <label>Image : </label>
                            <div id="viewImageShow"></div>
                        </div> --}}

                        <div class="view_modal_content">
                            <label>Employee : </label>
                            <div id="view_employee"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Email : </label>
                            <div id="view_email"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Salary : </label>
                            <div id="view_salary"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            //____ For Create Modal ____//
            $('#employee_id').select2({
                dropdownParent: $('#createModal'),
                templateResult: formatState, // Only Text content when select, it will be shown 
                templateSelection: formatState,    // When select any option, it will be display image and text both
            });
            
            //____ For Create Modal ____//
            $('#up_employee_id').select2({
                dropdownParent: $('#editModal'),
                templateResult: formatState, // Only Text content when select, it will be shown 
                templateSelection: formatState,    // When select any option, it will be display image and text both
            });

            function formatState (state) {
                if (!state.id) {
                    return state.text; // Return text for disabled option
                }

                var imageUrl = $(state.element).data('image-url'); // Access image URL from data attribute

                if (!imageUrl) {
                    return state.text; // Return text if no image URL is available
                }

                var $state = $(
                    '<span><img src="' + imageUrl + '" style="width: 35px; height: 30px; margin-right: 8px;" /> ' + state.text + '</span>'
                );
                return $state;
            };


            // Show Data through Datatable
            let datatables = $('#datatables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.hrm.payroll-data') }}",
                // pageLength: 30,

                columns: [
                    {
                        data: 'employee_code',
                    },
                    {
                        data: 'employee',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'salary',
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
                    url: "{{ route('admin.hrm.payroll.status') }}",
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
                    url: "{{ route('admin.hrm.payroll.store') }}",
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
                        // console.log(error);

                        $('#employee_id_validate').empty().html(error.employee_id);
                        $('#basic_salary_validate').empty().html(error.basic_salary);
                        $('#status_validate').empty().html(error.status);
                        $('#hra_allow_validate').empty().html(error.hra_allow);
                        $('#conveyance_validate').empty().html(error.conveyance);
                        $('#medical_allow_validate').empty().html(error.medical_allow);
                        $('#bonus_validate').empty().html(error.bonus);
                        $('#pf_validate').empty().html(error.provident_fund);
                        $('#professional_tax_validate').empty().html(error.professional_tax);
                        $('#tds_validate').empty().html(error.tds);
                        $('#loan_others_validate').empty().html(error.loan_others);

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
                    url: "{{ url('admin/hrm/payroll') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_employee_id').val(data.employee_id).trigger('change');
                        $('#up_basic_salary').val(data.basic_salary);
                        // $('#up_status').val(data.status);
                        $('#up_hra_allow').val(data.hra_allow);
                        $('#up_conveyance').val(data.conveyance);
                        $('#up_medical_allow').val(data.medical_allow);
                        $('#up_bonus').val(data.bonus);
                        $('#up_pf').val(data.provident_fund);
                        $('#up_professional_tax').val(data.professional_tax);
                        $('#up_tds').val(data.tds);
                        $('#up_loan_others').val(data.loan_others);

                        // ✅ Select the radio button based on status
                        $('input[name="status"][value="' + data.status + '"]').prop('checked', true);
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
                    url: "{{ url('admin/hrm/payroll') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res.message, "daya")

                        swal.fire({
                            title: "Success",
                            text: "Payroll Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_employee_id_validate').empty().html(error.employee_id);
                        $('#up_basic_salary_validate').empty().html(error.basic_salary);
                        $('#up_status_validate').empty().html(error.status);
                        $('#up_hra_allow_validate').empty().html(error.hra_allow);
                        $('#up_conveyance_validate').empty().html(error.conveyance);
                        $('#up_medical_allow_validate').empty().html(error.medical_allow);
                        $('#up_bonus_validate').empty().html(error.bonus);
                        $('#up_pf_validate').empty().html(error.provident_fund);
                        $('#up_professional_tax_validate').empty().html(error.professional_tax);
                        $('#up_tds_validate').empty().html(error.tds);
                        $('#up_loan_others_validate').empty().html(error.loan_others);

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

                            url: "{{ url('admin/hrm/payroll') }}/" + id,
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
                    url: "{{ url('admin/hrm/payroll/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_employee_code').html(data.employee_code);
                        $('#viewImageShow').html('');
                        $('#viewImageShow').append(`
                          <a href="{{ asset("`+ data.image +`") }}" target="__blank">
                            <img src={{ asset("`+ data.image +`") }} alt="" style="width: 75px;">    
                          </a>
                       `);
                        $('#view_employee').html(res.employee);
                        $('#view_email').html(data.email);
                        $('#view_salary').html(res.net_salary);
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

