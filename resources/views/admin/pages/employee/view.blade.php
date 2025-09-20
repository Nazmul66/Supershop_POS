@extends('admin.layout.master')

@push('title')
    View Employee
@endpush


@push('add-css')

@endpush

{{-- Active sidebar --}}
@section('employee', 'active')


@section('body-content')


<div class="page-header">
    <div>
        <a href="{{ route('admin.hrm.employee.index') }}" class="d-inline-flex align-items-center"><i class="ti ti-chevron-left me-2"></i>Back to List</a>
    </div>
    <ul class="table-top-head">
        <li class="me-2">
            <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
</div>


<div class="row" style="transform: none;">
    <div class="col-xl-4 theiaStickySidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
        
    <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;"><div class="card rounded-0 border-0">
            <div class="card-header rounded-0 bg-primary d-flex align-items-center">

                <span class="avatar avatar-xl avatar-rounded flex-shrink-0 border border-white border-3 me-3">
                    <img src="{{ asset($employee->image) }}" alt="Img">
                </span>
                
                <div class="me-3">
                    <h6 class="text-white mb-1">{{ $employee->first_name . ' ' . $employee->last_name }}</h6>
                    <span class="badge bg-purple-transparent text-purple">{{ $employee->designation }}</span>
                </div>

                @if(auth("admin")->user()->can("update.employee"))
                    <div>
                        <a href="{{ route('admin.hrm.employee.edit', $employee->id) }}" class="btn btn-white">Edit Profile</a>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="d-inline-flex align-items-center">
                        <i class="ti ti-id me-2"></i>
                        Employee ID
                    </span>
                    <p class="text-dark">EMP-0001</p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="d-inline-flex align-items-center">
                        <i class="ti ti-star me-2"></i>
                        Team
                    </span>
                    <p class="text-dark">{{ $employee->department }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="d-inline-flex align-items-center">
                        <i class="ti ti-calendar-check me-2"></i>
                        Date Of Join
                    </span>
                    <p class="text-dark">{{ date('dS M Y', strtotime($employee->joining_date)) }}</p>
                </div>
            </div>
        </div><div class="resize-sensor" style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;"><div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0px; top: 0px; transition: all; width: 372px; height: 790px;"></div></div><div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div></div></div></div></div>
    <div class="col-xl-8">
        <div class="card rounded-0 border-0">
            <div class="card-header border-0 rounded-0 bg-light d-flex align-items-center">
                <h6>Basic information</h6>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Phone</p>
                            <span class="text-gray-900 fs-13">{{ $employee->contact_number }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Email</p>
                            <span class="text-gray-900 fs-13">{{ $employee->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Gender</p>
                            <span class="text-gray-900 fs-13">{{ $employee->gender }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Birdthday</p>
                            <span class="text-gray-900 fs-13">{{ date('dS M Y', strtotime($employee->date_of_birth)) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Address</p>
                            <span class="text-gray-900 fs-13">{{ $employee->address }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Nationality</p>
                            <span class="text-gray-900 fs-13">{{ $employee->country_name }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Blood Group</p>
                            <span class="text-gray-900 fs-13">{{ $employee->blood_group }}</span>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Shift</p>
                            <span class="text-gray-900 fs-13">Mid Shift</span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>


        @if ( !is_null($employee->about) )
            <div class="card rounded-0 border-0">
                <div class="card-header border-0 rounded-0 bg-light d-flex align-items-center">
                    <h6>About Employee</h6>
                </div>
                <div class="card-body pb-0">
                    <p>{{ $employee->about }}</p>
                </div>
            </div>
        @endif


        <div class="card rounded-0 border-0">
            <div class="card-header border-0 rounded-0 bg-light d-flex align-items-center">
                <h6>Bank Information</h6>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Bank Name</p>
                            <span class="text-gray-900 fs-13">{{ $employee->bank_name }}</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Bank account No</p>
                            <span class="text-gray-900 fs-13">{{ $employee->account_number }}</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">IFSC</p>
                            <span class="text-gray-900 fs-13">{{ $employee->routing_number }}</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Branch</p>
                            <span class="text-gray-900 fs-13">{{ $employee->branch_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card rounded-0 border-0">
            <div class="card-header border-0 rounded-0 bg-light d-flex align-items-center">
                <h6>Emergency Contact Number</h6>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Name</p>
                            <span class="d-block text-gray-900 fs-13 mb-3">{{ $employee->relation_name_1 }}</span>
                            <span class="text-gray-900 fs-13">{{ $employee->relation_name_2 }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Relation</p>
                            <span class="d-block text-gray-900 fs-13 mb-3">{{ $employee->emergency_relation_1 }}</span>
                            <span class="text-gray-900 fs-13">{{ $employee->emergency_relation_2 }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="fs-13 mb-2">Phone Number</p>
                            <span class="d-block text-gray-900 fs-13 mb-3">{{ $employee->emergency_number_1 }}</span>
                            <span class="text-gray-900 fs-13"> {{ $employee->emergency_number_2 }}</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


@endsection


@push('add-js')

		<!-- Sticky Sidebar JS -->
		<script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
		<script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@endpush