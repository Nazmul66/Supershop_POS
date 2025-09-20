@extends('admin.layout.master')

@push('title')
    Create FAQ
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active sidebar --}}
@section('employee', 'active')

@php
    use Carbon\Carbon;
@endphp


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
            @if(auth("admin")->user()->can("pdf.employee"))
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('admin.hrm.employee.pdf') }}" aria-label="Pdf" data-bs-original-title="Pdf"><img src="{{ asset('public/admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                </li>
            @endif

            @if(auth("admin")->user()->can("excel.employee"))
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
            @if(auth("admin")->user()->can("create.employee"))
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
                        <h4 class="text-white">{{ $total_employee }}</h4>
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
                        <h4 class="text-white">{{ $active_employee }}</h4>
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
                        <h4 class="text-white">{{ $inActive_employee }}</h4>
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
                        <h4 class="text-white">{{ $new_employee }}</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-info-900"><i class="ti ti-user-check"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- product list -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div class="search-set mb-0">
                    <div class="search-input">
                        <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        <input type="search" class="form-control" placeholder="Search">
                    </div>
                    
                </div>
                <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                    <div class="dropdown me-2">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            Select Employees 
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Anthony Lewis</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Brian Villalobos</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Harvey Smith</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Stephan Peralt</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            Designation
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">System Admin</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Designer</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Tech Lead</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Database administrator</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- product list -->
<div class="employee-grid-widget">
    <div class="row">

        @if ( !empty($all_employees) && $all_employees->count() > 0 )
        
            @foreach ($all_employees as $row)
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <div class="card ribbone-card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                @if ($row->joining_date && Carbon::parse($row->joining_date)->greaterThanOrEqualTo(now()->subMonths(3)))
                                    <div class="ribbone ribbone-top-left text-dark">
                                        <span class="bg-success">New</span>
                                    </div>
                                @endif
                                

                                <div class="power-ribbone power-ribbone-bottom-right text-success">
                                    <span class="{{ $row->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                    </span>
                                </div>

                                <div class="form-check form-check-md">
                                    {{-- <input class="form-check-input" type="checkbox"> --}}
                                    {{-- <span class="{{ $row->status == 1 ? 'bg-success' : 'bg-danger' }} rounded-circle d-inline-block" style="width: 15px; height: 15px;"></span> --}}
                                </div>

                                <div>
                                    <a href="employee-details.html" class="avatar avatar-xl avatar-rounded border p-1 rounded-circle">
                                        <img src="{{ asset($row->image) }}" class="img-fluid h-auto w-auto" alt="img">
                                    </a>
                                </div>
                                <div class="dropdown">
                                    <a href="#" class="action-icon border-0" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical feather-user"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></a>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        @if(auth("admin")->user()->can("update.employee"))
                                        <li>
                                            <a href="{{ route('admin.hrm.employee.edit', $row->id) }}" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>Edit</a>
                                        </li>
                                        @endif


                                        @if(auth("admin")->user()->can("delete.employee"))
                                        <li>
                                            <a href="javascript:void(0)" data-id="{{ $row->id }}" id="deleteBtn" class="dropdown-item confirm-text mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>Delete</a>
                                        </li>	
                                        @endif							
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="text-primary mb-2">EMP ID : {{ $row->employee_code }}</p>
                            </div>

                            <div class="text-center mb-3">
                                <h6 class="mb-1"><a href="{{ route('admin.hrm.employee.view', $row->id) }}">{{ $row->first_name . ' ' . $row->last_name }}</a></h6>
                                <span class="badge bg-secondary-transparent text-gray-9 fs-10 fw-medium">{{ $row->designation }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between bg-light rounded p-3">
                                <div class="text-start">
                                    <h6 class="mb-1">Joined</h6>
                                    <p>{{ date('d M Y', strtotime($row->joining_date)) }}</p>
                                </div>
                                <div class="text-start">
                                    <h6 class="mb-1">Department</h6>
                                    <p>{{ $row->department }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <div class="card bg-white border-0">
                <div class="alert custom-alert1 alert-secondary">
                    <div class="text-center px-5 pb-0"> 
                        <div class="custom-alert-icon mb-3"> 
                            <i class="ti ti-alert-triangle" style="font-size: 80px;"></i>
                        </div>
                        <h5>Warnings?</h5>
                        <p>There is no employee list here.</p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

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

                            url: "{{ url('admin/hrm/employee') }}/" + id,
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
                                }).then(() => {
                                    // Reload page after alert is closed
                                    location.reload();
                                });
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

