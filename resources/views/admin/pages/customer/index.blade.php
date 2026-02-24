@extends('admin.layout.master')

@push('title')
    Create Brand
@endpush


@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link href="{{ asset('public/admin/assets/css/select2.min.css') }}" rel="stylesheet" />
@endpush

{{-- Active sidebar --}}
@section('customer', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Customer</h4>
                <h6>Manage your customers</h6>
            </div>
        </div>
        <ul class="table-top-head">
            @if(auth("admin")->user()->can("pdf.brand"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.brand.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Customer</button>
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
                            <th>#Sl No.</th>
                            <th>Customer Id</th>
                            <th>Customer Details</th>
                            <th>Customer Email</th>
                            <th>Customer Address</th>
                            <th>Addtional Note</th>
                            <th>Internal Note</th>
                            <th>Created By</th>
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
                        <h5 class="modal-title" id="myModalLabel">Create Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cus_type" class="form-label">Customer Type</label>
                                        <select class="form-select" id="cus_type" name="cus_type">
                                            <option value="ecom_type_cus" selected>Ecommerce Type Customer</option>
                                        </select>
        
                                        <span id="cus_type_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cus_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cus_name" name="cus_name" placeholder="Customer name">
        
                                        <span id="cus_name_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cus_email" class="form-label">Customer Email (Optional)</label>
                                        <input type="email" class="form-control" id="cus_email" name="cus_email" placeholder="Customer name">
        
                                        <span id="cus_email_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cus_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cus_phone" name="cus_phone" placeholder="Customer name">
        
                                        <span id="cus_phone_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cus_tag" class="form-label">Customer Tag (Optional)</label>
                                        <select class="form-select" id="cus_tag" name="cus_tag">
                                            <option value="regular" selected>Regular</option>
                                            <option value="vip">VIP</option>
                                            <option value="fraud">Fraud</option>
                                            <option value="corporate">Corporate</option>
                                            <option value="employee">Employee</option>
                                            <option value="probashi">Probashi</option>
                                        </select>
        
                                        <span id="cus_tag_validate" class="text-danger validation-error mt-1"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="cus_source">Customer Source <span class="text-danger">*</span></label>
                    
                                        <select name="cus_source" id="cus_source" class="form-control">
                                            <option value="new" data-image-url="{{ asset('public/admin/assets/images/world-wide-web.png') }}">Website</option>
                                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/viber.png') }}">Phone Call</option>
                                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/whatsapp.png') }}">Whatsapp</option>
                                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/facebook.png') }}">Facebook</option>
                                            <option value="regular" data-image-url="{{ asset('public/admin/assets/images/instagram.png') }}">Instagram</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="cus_address" class="form-label">Customer Address <span class="text-danger">*</span></label>
                                    <textarea name="cus_address" class="form-control" id="cus_address" cols="30" rows="2"></textarea>
    
                                    <span id="cus_address_validate" class="text-danger validation-error mt-1"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="additional_note" class="form-label">Additional Note (Optional)</label>
                                    <textarea name="additional_note" class="form-control" id="additional_note" cols="30" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="internal_note" class="form-label">Internal Note (Optional)</label>
                                    <textarea name="internal_note" class="form-control" id="internal_note" cols="30" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="">
                                    <label for="" class="form-label">Save As</label>
                
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="save_as" id="home" value="home" checked>
                                            <label class="form-check-label" for="home">
                                                Home
                                            </label>
                                        </div>
                
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="save_as" id="work" value="work">
                                            <label class="form-check-label" for="work">
                                                Work
                                            </label>
                                        </div>
                
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="save_as" id="other" value="other">
                                            <label class="form-check-label" for="other">
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Deactive</option>
                                </select>

                                <span id="status_validate" class="text-danger validation-error mt-1"></span>
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
                                <label for="up_brand_name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="up_brand_name" name="brand_name" placeholder="Brand Name">

                                <span id="up_name_validate" class="text-danger validation-error mt-1"></span>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Brand Image <sup class="text-danger" style="font-size: 12px;">* resolution(100 x 100)</sup></label>
                                <input type="file" class="form-control" name="image" id="image" accept=".png, .jpeg, .jpg, .webp" onchange="imageShow(event)">

                                <div id="imageShow" class="mt-3"></div>
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
                        <h5 class="modal-title" id="myModalLabel">View Brand List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Name : </label>
                            <span class="text-dark" id="view_brand_name"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Image : </label>
                            <div id="viewImageShow"></div>
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
    <script src="{{ asset('public/admin/assets/js/select2.min.js') }}"></script>


    <script>
        $(document).ready(function () {
            $('#cus_source').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
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
                    '<span><img src="' + imageUrl + '" style="width: 30px; height: 30px; border-radius: 6px; margin-right: 8px;" /> ' + state.text + '</span>'
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

                ajax: "{{ route('admin.customer-data') }}",
                // pageLength: 30,

                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'cus_id',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'customer_details',
                    },
                    {
                        data: 'cus_email',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'cus_address',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'cus_address',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'additional_note',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'internal_note',
                        orderable: false,
                        searchable: false,
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
                    url: "{{ route('admin.brand.status') }}",
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
                    url: "{{ route('admin.customer.store') }}",
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

                        $('#name_validate').empty().html(error.brand_name);
                        $('#image_validate').empty().html(error.image);
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
                    url: "{{ url('admin/brands') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_brand_name').val(data.brand_name);
                        $('#imageShow').html('');
                        $('#imageShow').append(`
                            <a href="{{ asset("`+ data.image +`") }}" target="__blank">
                                 <img src={{ asset("`+ data.image +`") }} alt="" style="width: 75px;">
                            </a>
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
                    url: "{{ url('admin/brands') }}/" + id,
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

                        $('#up_name_validate').empty().html(error.brand_name);

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

                            url: "{{ url('admin/brands') }}/" + id,
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
                    url: "{{ url('admin/brands/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_brand_name').html(data.brand_name);
                        $('#viewImageShow').html('');
                        $('#viewImageShow').append(`
                          <a href="{{ asset("`+ data.image +`") }}" target="__blank">
                            <img src={{ asset("`+ data.image +`") }} alt="" style="width: 75px;">    
                          </a>
                       `);

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

