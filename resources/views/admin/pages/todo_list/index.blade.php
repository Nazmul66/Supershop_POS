@extends('admin.layout.master')

@push('add-title')
    Notes
@endpush

@push('add-css')

@endpush

{{-- Active sidebar --}}
@section('application', 'subdrop active')
@section('todo', 'active')


@section('body-content')

    <div class="page-header page-add-notes border-0 flex-sm-row flex-column">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Todo</h4>
                <h6 class="mb-0">Manage Your Todo</h6>
            </div>
        </div>

        <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-start">
            <ul class="table-top-head me-2">
                <li>
                    <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
                </li>
            </ul>

            @if(auth("admin")->user()->can("create.note"))
                <div class="page-btn">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Create New</a>
                </div>
            @endif
        </div>
    </div>


    <!-- Create Note Modal -->
    <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"  data-bs-scroll="true" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Todo</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="createForm" enctype="multipart/form-data">
                        @csrf

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Note Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control">

                                <span id="title_validate" class="text-danger mt-1"></span>
                            </div>											
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">User <span class="text-danger">*</span></label>
                                    <select class="form-select" name="assign_user_id">
                                        <option value="" disabled selected>selected</option>
                                        @foreach ($admin_list as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
        
                                    <span id="user_id_validate" class="text-danger mt-1"></span>
                                </div>
                            </div> 

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Importants <span class="text-danger">*</span></label>
                                    <select class="form-select" name="important">
                                        <option value="" disabled selected>selected</option>
                                        <option value="1">High</option>
                                        <option value="0">Low</option>
                                    </select>
        
                                    <span id="important_validate" class="text-danger mt-1"></span>
                                </div>
                            </div> 
                        </div>
                        
                       <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tag <span class="text-danger">*</span></label>
                                    <select class="form-select" name="tag">
                                        <option value="" disabled selected>selected</option>
                                        <option value="personal">Personal</option>
                                        <option value="work">Work</option>
                                        <option value="social">Social</option>
                                    </select>

                                    <span id="tag_validate" class="text-danger mt-1"></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select" name="priority">
                                        <option value="" disabled selected>selected</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="low">Low</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                    </select>

                                    <span id="priority_validate" class="text-danger mt-1"></span>
                                </div>
                            </div>
                       </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="description">Descriptions<span class="text-danger ms-1">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>

                                <span id="description_validate" class="text-danger mt-1"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Priority Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="priority_status">
                                <option value="" disabled selected>selected</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="3">Onhold</option>
                                <option value="4">Inprogress</option>
                            </select>

                            <span id="priority_status_validate" class="text-danger mt-1"></span>
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
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                    data-bs-dismiss="modal">Close
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
    <!-- /Create Note Modal -->


    <!-- Edit Note Modal -->
    <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"  data-bs-scroll="true" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Update Todo</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent;"></button>
                </div>

                <div class="modal-body">
                    <form id="EditForm" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <input type="text" name="id" id="id" hidden>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label" for="up_title">Note Title <span class="text-danger">*</span></label>
                                <input type="text" id="up_title" name="title" class="form-control">

                                <span id="up_title_validate" class="text-danger mt-1"></span>
                            </div>											
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="up_assign_user_id">User <span class="text-danger">*</span></label>
                                    <select class="form-select" id="up_assign_user_id" name="assign_user_id">
                                        <option value="" disabled selected>selected</option>
                                        @foreach ($admin_list as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
        
                                    <span id="up_user_id_validate" class="text-danger mt-1"></span>
                                </div>
                            </div> 

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="up_important">Importants <span class="text-danger">*</span></label>
                                    <select class="form-select" id="up_important" name="important">
                                        <option value="" disabled selected>selected</option>
                                        <option value="1">High</option>
                                        <option value="0">Low</option>
                                    </select>
        
                                    <span id="up_important_validate" class="text-danger mt-1"></span>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="up_tag">Tag <span class="text-danger">*</span></label>
                                    <select class="form-select" id="up_tag" name="tag">
                                        <option value="" disabled selected>selected</option>
                                        <option value="personal">Personal</option>
                                        <option value="work">Work</option>
                                        <option value="social">Social</option>
                                    </select>

                                    <span id="up_tag_validate" class="text-danger mt-1"></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="up_priority">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select" id="up_priority" name="priority">
                                        <option value="" disabled selected>selected</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="low">Low</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                    </select>

                                    <span id="up_priority_validate" class="text-danger mt-1"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="up_description">Descriptions<span class="text-danger ms-1">*</span></label>
                                <textarea class="form-control" id="up_description" name="description" rows="3"></textarea>

                                <span id="up_description_validate" class="text-danger mt-1"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="up_priority_status">Priority Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="up_priority_status" name="priority_status">
                                <option value="" disabled selected>selected</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="3">Onhold</option>
                                <option value="4">Inprogress</option>
                            </select>

                            <span id="up_priority_status_validate" class="text-danger mt-1"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="up_status">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="up_status" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <span id="up_status_validate" class="text-danger mt-1"></span>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-secondary waves-effect me-3"
                                    data-bs-dismiss="modal">Close
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
    <!-- /Edit Note Modal -->


    <!-- View Note Modal -->
    <div id="viewModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="modal-header">
                        <div class="page-title edit-page-title">
                            <h4>Notes</h4>
                            <p id="view_tag">Personal</p>
                        </div>
                        <div class="edit-noted-head d-flex align-items-center">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form action="notes.html">
                            <div class="row">
                                <div class="col-12">
                                    <div class="edit-head-view">
                                        <h6 id="view_title">Take a hike at a local park</h6>
                                        <p id="view_description">Hiking is a long, vigorous walk, usually on trails or footpaths in the countryside.
                                            Walking for pleasure developed in Europe during the eighteenth century.
                                            Religious pilgrimages have existed much longer but they involve walking long
                                            distances for a spiritual purpose associated with specific religions and also
                                            we achieve inner peace while we hike at a local park.</p>

                                        <div id="view_priority">
                                            <p class="badged low"><i class="fas fa-circle"></i> Low</p>
                                        </div>
                                        
                                    </div>	
                                    <div class="modal-footer-btn edit-footer-menu">
                                        <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>	
                        </form>							
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /View Note Modal -->

   
    <div class="card">
        <div class="card-body">
            <div class="row gy-3 mb-3">
                <div class="col-sm-4">
                    <div class="d-flex align-items-center">
                        <h4>Total Todo</h4>
                        <span class="badge badge-dark rounded-pill badge-xs ms-2">+1</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex align-items-center justify-content-end">
                        <p class="mb-0 me-3 pe-3 border-end fs-14">Total Task : <span class="text-dark"> 55 </span></p>
                        <p class="mb-0 me-3 pe-3 border-end fs-14">Pending : <span class="text-dark"> 15 </span></p>
                        <p class="mb-0 fs-14">Completed : <span class="text-dark"> 40 </span></p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn bg-primary-transparent border-dashed border-primary w-100 text-start" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus me-2"></i>New task
                </button>
            </div>

            {{-- Priority Tab list --}}
            <div class="row border-bottom mb-3">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center flex-wrap row-gap-3 mb-3">
                        <h6 class="me-2">Priority</h6>
                        <ul class="nav nav-pills border d-inline-flex p-1 rounded bg-light todo-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-icon py-3 d-flex align-items-center justify-content-center w-auto active" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-icon py-3 d-flex align-items-center justify-content-center w-auto" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-selected="false">High</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-icon py-3 d-flex align-items-center justify-content-center w-auto" data-bs-toggle="pill" data-bs-target="#pills-medium" type="button" role="tab" aria-selected="false">Medium</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-icon py-3 d-flex align-items-center justify-content-center w-auto" data-bs-toggle="pill" data-bs-target="#pills-low" type="button" role="tab" aria-selected="false">Low</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex align-items-center justify-content-lg-end flex-wrap row-gap-3 mb-3">
                       
                        <div class="d-flex align-items-center">
                            <span class="d-inline-flex me-2">Sort By : </span>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center border-0 bg-transparent p-0 text-dark" data-bs-toggle="dropdown">
                                    Created Date
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Created Date</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Priority</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Due Date</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Priority Category Tab list --}}
            <div class="tab-content" id="pills-tabContent">

                {{-- All Priority --}}
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                    <div class="accordion todo-accordion" id="accordionExample">
                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingTwo">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseUrgent" aria-controls="collapseUrgent">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-danger me-2"></i></span>
                                                    <h5 class="fw-semibold">Urgent</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">32</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                    </div>
                                </div>
                            </div>


                            <div id="collapseUrgent" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush border-bottom pb-2">

                                    @foreach ($urgent_todo as $row)
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 d-flex align-items-center rating-select"><i class="ti ti-star-filled filled"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Update calendar and schedule</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>15 Jan 2025</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-info me-3">Social</span>
                                                        <span class="badge badge-soft-pink badge-xs shadow-none d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Onhold</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-13.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-15.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="heading3">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-purple me-2"></i></span>
                                                    <h5 class="fw-semibold">High</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">15</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush border-bottom pb-2">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 d-flex align-items-center rating-select"><i class="ti ti-star-filled filled"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Finalize project proposal</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>15 Jan 2025</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-success me-3">Projects</span>
                                                        <span class="badge badge-soft-pink shadow-none badge-xs d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Onhold</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-13.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-15.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Submit to supervisor by EOD</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>25 May 2024</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-danger me-3">Internal</span>
                                                        <span class="badge badge-soft-indigo shadow-none badge-xs d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-20.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-21.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-22.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3 todo-strike-content">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Prepare presentation slides</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>15 Jan 2025</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-secondary me-3">Reminder</span>
                                                        <span class="badge badge-soft-secondary badge-xs shadow-none d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Pending</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-23.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-25.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingThree">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-warning me-2"></i></span>
                                                    <h5 class="fw-semibold">Medium</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">05</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush border-bottom pb-2">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Check and respond to emails</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>Tomorrow</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-secondary me-3">Reminder</span>
                                                        <span class="badge badge-soft-success badge-xs shadow-none d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Completed</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-7 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Coordinate with department head on progress</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>25 May 2024</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-danger me-3">Internal</span>
                                                        <span class="badge badge-soft-danger badge-xs shadow-none d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-06.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-09.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingFour">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-controls="collapseFour">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-success me-2"></i></span>
                                                    <h5 class="fw-semibold">Low</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Plan tasks for the next day</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>Today</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-info me-3">Social</span>
                                                        <span class="badge badge-soft-secondary badge-xs shadow-none d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Pending</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- High Priority --}}
                <div class="tab-pane fade" id="pills-contact" role="tabpanel">
                    <div class="accordion todo-accordion">
                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingSix">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-controls="collapseSix">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-purple me-2"></i></span>
                                                    <h5 class="fw-semibold">High</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">15</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star-filled filled"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Finalize project proposal</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>15 Jan 2025</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-success me-3">Projects</span>
                                                        <span class="badge bg-soft-pink d-inline-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Onhold</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-13.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-15.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Submit to supervisor by EOD</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>25 May 2024</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-danger me-3">Internal</span>
                                                        <span class="badge bg-transparent-purple d-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-20.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-21.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-22.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3 todo-strike-content">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Prepare presentation slides</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>15 Jan 2025</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-secondary me-3">Reminder</span>
                                                        <span class="badge badge-secondary-transparent d-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Pending</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-23.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-25.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Medium Priority --}}
                <div class="tab-pane fade" id="pills-medium" role="tabpanel">
                    <div class="accordion todo-accordion">
                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingSeven">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-controls="collapseSeven">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-warning me-2"></i></span>
                                                    <h5 class="fw-semibold">Medium</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">05</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseSeven" class="accordion-collapse collapse show" aria-labelledby="headingSeven">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Check and respond to emails</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>Tomorrow</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-secondary me-3">Reminder</span>
                                                        <span class="badge badge-soft-success align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Completed</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Coordinate with department head on progress</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>25 May 2024</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-danger me-3">Internal</span>
                                                        <span class="badge bg-transparent-purple d-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-06.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-09.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 {{-- Low Priority --}}
                <div class="tab-pane fade" id="pills-low" role="tabpanel">
                    <div class="accordion todo-accordion">
                        <div class="accordion-item border-0 mb-3">
                            <div class="row align-items-center mb-3 row-gap-3">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="accordion-header" id="headingEight">
                                        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-controls="collapseEight">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-2">
                                                    <a href="javascript:void(0);">
                                                        <span><i class="fas fa-chevron-down"></i></span>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span><i class="ti ti-square-rounded text-success me-2"></i></span>
                                                    <h5 class="fw-semibold">Low</h5>
                                                    <span class="badge bg-light rounded-pill ms-2">24</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-6">
                                    <div class="d-flex align-items-center justify-content-sm-end">
                                        <a href="#" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-circle-plus me-2"></i>Add New</a>
                                        <a href="#" class="btn btn-outline-light border">See All <i class="ti ti-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight">
                                <div class="accordion-body">
                                    <div class="list-group list-group-flush">
                                        <div class=" list-item-hover shadow-sm rounded mb-2 p-3">
                                            <div class="row align-items-center row-gap-3">
                                                <div class="col-lg-6 col-md-7">
                                                    <div class="todo-inbox-check d-flex align-items-center flex-wrap row-gap-3">
                                                        <span class="me-2 d-flex align-items-center"><i class="ti ti-grid-dots text-dark"></i></span>
                                                        <div class="form-check form-check-md me-2">
                                                            <input class="form-check-input" type="checkbox">
                                                        </div>
                                                        <span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
                                                        <div class="strike-info">
                                                            <h4 class="fs-14">Plan tasks for the next day</h4>
                                                        </div>
                                                        <span class="badge bg-transparent-dark text-dark border border-dark rounded ms-2"><i class="ti ti-calendar me-1"></i>Today</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-5">
                                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                                        <span class="badge badge-info me-3">Social</span>
                                                        <span class="badge badge-soft-secondary d-flex align-items-center me-3"><i class="fas fa-circle fs-6 me-1"></i>Pending</span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-list-stacked avatar-group-sm">
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                                </span>
                                                                <span class="avatar avatar-rounded">
                                                                    <img class="border border-white" src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                                </span>
                                                            </div>
                                                            <div class="dropdown ms-2">
                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_todo"><i class="ti ti-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-note-units"><i class="ti ti-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#view-note-units"><i class="ti ti-eye me-2"></i>View</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center">
                <a href="#" class="btn btn-primary"><i class="ti ti-loader me-2"></i>Load More</a>
            </div>
        </div>
    </div>

@endsection


@push('add-js')



    <script>
        $(document).ready(function () {
            // Create Data
            $('#createForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.todo.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        if (res.status === true) {
                            $('#createModal').modal('hide');
                            $('#createForm')[0].reset();
                            $('.validation-error').html('');

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            }).then(() => {
                                // Reload page after alert is closed
                                location.reload();
                            });
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;
                        console.log(error);

                        $('#title_validate').empty().html(error.title);
                        $('#user_id_validate').empty().html(error.assign_user_id);
                        $('#important_validate').empty().html(error.important);
                        $('#tag_validate').empty().html(error.tag);
                        $('#priority_validate').empty().html(error.priority);
                        $('#description_validate').empty().html(error.description);
                        $('#priority_status_validate').empty().html(error.priority_status);
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
                    url: "{{ url('admin/todo') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_title').val(data.title);
                        $('#up_assign_user_id').val(data.assign_user_id);
                        $('#up_important').val(data.important);
                        $('#up_tag').val(data.tag);
                        $('#up_priority').val(data.priority);
                        $('#up_description').val(data.description);
                        $('#up_priority_status').val(data.priority_status);
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
                    url: "{{ url('admin/todo') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');

                        swal.fire({
                            title: "Success",
                            text: "Todo Updated Successfully",
                            icon: "success"
                        }).then(() => {
                            // Reload page after alert is closed
                            location.reload();
                        });

                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_title_validate').empty().html(error.title);
                        $('#up_user_id_validate').empty().html(error.assign_user_id);
                        $('#up_important_validate').empty().html(error.important);
                        $('#up_tag_validate').empty().html(error.tag);
                        $('#up_priority_validate').empty().html(error.priority);
                        $('#up_description_validate').empty().html(error.description);
                        $('#up_priority_status_validate').empty().html(error.priority_status);
                        $('#up_status_validate').empty().html(error.status);

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

                            url: "{{ url('admin/todo') }}/" + id,
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
                        swal.fire('Your Image is Safe');
                    }
                })
            })


            // Important status updates
            $(document).on('click', '.important', function () {
                var id = $(this).data('id');
                var important = $(this).data('important');
                // console.log(id, important);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.todo.important') }}",
                    data: {
                        // '_token': token,
                        id: id,
                        important: important
                    },
                    success: function (res) {
                        if (res.status == 1) {
                            swal.fire(
                                {
                                    title: 'Status changed to important',
                                    icon: 'success'
                                }).then(() => {
                                    // Reload page after alert is closed
                                    location.reload();
                                });
                        } else {
                            swal.fire(
                                {
                                    title: 'Status changed to not important',
                                    icon: 'success'
                                })
                                .then(() => {
                                    // Reload page after alert is closed
                                    location.reload();
                                });
                        }
                    },
                    error: function (err) {
                        console.log(err);
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
                    url: "{{ url('admin/todo/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_title').html(data.title);
                        $('#view_tag').html(res.tag);
                        $('#view_description').html(data.description);
                        $('#view_priority').html(res.priority);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })
        })

    </script>

@endpush