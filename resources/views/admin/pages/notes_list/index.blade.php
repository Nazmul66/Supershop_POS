@extends('admin.layout.master')

@push('add-title')
    Notes
@endpush

@push('add-css')
    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/owl.carousel.min.css') }}">
@endpush

{{-- Active sidebar --}}
@section('application', 'subdrop active')
@section('notes', 'active')


@section('body-content')

    <div class="page-header page-add-notes border-0 flex-sm-row flex-column">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Notes</h4>
                <h6 class="mb-0">Manage your notes</h6>
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
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Note</a>
                </div>
            @endif
        </div>
    </div>


    <!-- Create Note Modal -->
    <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"  data-bs-scroll="true" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Notes</h5>

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
                    <h5 class="modal-title" id="myModalLabel">Update Notes</h5>

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
                                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Close</button>
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



    <div class="row" style="transform: none;">
        <div class="col-xl-3 col-md-12 sidebars-right theiaStickySidebar section-bulk-widget" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
            
            <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none; top: 0px; left: 276px;">
                <div class="border rounded-3 bg-white p-3">
                    <div class="mb-3 pb-3 border-bottom">
                        <h4 class="d-flex align-items-center"><i class="ti ti-file-text me-2"></i>Notes List</h4>
                    </div>

                    <div class="border-bottom pb-3 ">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="d-flex text-start align-items-center fw-medium fs-15 nav-link active mb-1" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                                <i class="ti ti-inbox me-2"></i>All Notes<span class="ms-2">1</span>
                            </button>
                            <button class="d-flex text-start align-items-center fw-medium fs-15 nav-link mb-1" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false" tabindex="-1">
                                <i class="ti ti-star me-2"></i>
                                Important
                            </button>
                            <button class="d-flex text-start align-items-center fw-medium fs-15 nav-link mb-0" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" tabindex="-1">
                                <i class="ti ti-trash me-2"></i>
                                Trash
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="resize-sensor" style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;">
                    <div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                        <div style="position: absolute; left: 0px; top: 0px; transition: all; width: 281px; height: 1112px;"></div>
                    </div>
                    
                    <div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                        <div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%">
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-xl-9 budget-role-notes">
            <div class="tab-content" id="v-pills-tabContent2">

                {{-- All Notes --}}
                <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel"
                    aria-labelledby="v-pills-profile-tab">
                    <div class="border-bottom mb-4 pb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div
                                    class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <h4>Important </h4>
                                        <div class="owl-nav slide-nav5 text-end nav-control ms-3"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- For ( Carousel/Slider ) important notes --}}
                            <div class="col-md-12">
                                @if ( $important_notes->count() > 0 )
                                    <div class="notes-slider owl-carousel">
                                        @foreach ($important_notes as $row)
                                            <div class="card rounded-3 mb-0">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center justify-content-between">

                                                        @if ( $row->priority === 'low' )
                                                            <span
                                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                        @elseif( $row->priority === 'medium' )
                                                            <span
                                                            class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                                class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                        @elseif( $row->priority === 'high' )
                                                            <span
                                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                                        @elseif( $row->priority === 'urgent' )
                                                            <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>
                                                        @endif
                                                        
                                                        <div>
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu notes-menu dropdown-menu-end">

                                                            @if(auth("admin")->user()->can("update.note"))
                                                                <a href="javascript:void();" class="dropdown-item" id="editButton"
                                                                    data-id="{{ $row->id }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModal"><span><i
                                                                            data-feather="edit"></i></span>Edit</a>
                                                            @endif

                                                            @if(auth("admin")->user()->can("delete.note"))
                                                                <a href="#" class="dropdown-item"
                                                                    href="javascript:void(0)"
                                                                    data-id="{{ $row->id }}" 
                                                                    id="deleteBtn"><span>
                                                                        <i data-feather="trash-2"></i></span>Delete</a>
                                                            @endif

                                                            @if(auth("admin")->user()->can("important.note"))
                                                                <a href="javascript:void(0);"
                                                                    class="dropdown-item important"
                                                                    data-id="{{ $row->id }}" 
                                                                    data-important="{{ $row->important }}">
                                                                    <span><i data-feather="star"></i></span>Not
                                                                    Important</a>
                                                            @endif

                                                            
                                                                    <a href="#" class="dropdown-item"
                                                                    id="viewButton" href="javascript:void(0)" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                                <span><i data-feather="eye"></i></span>View</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="my-3">
                                                        <h5 class="text-truncate mb-1"><a
                                                                href="javascript:void(0);">{{ \Illuminate\Support\Str::limit($row->title, 24) }}...</a></h5>
                                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                                class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</p>
                                                        <p class="text-truncate line-clamb-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->description, 60) }}...</p>
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">

                                                                @if ( !empty($row->image) && $row->image )
                                                                    <img src="{{ asset($row->image) }}"
                                                                    alt="Profile" class="img-fluid rounded-circle">
                                                                @else
                                                                    <img src="{{ asset('public/admin/assets/img/profiles/avatar-01.jpg') }}"
                                                                    alt="Profile" class="img-fluid rounded-circle">
                                                                @endif
                                                               
                                                            </a>

                                                            @if ( $row->tag === 'personal' )
                                                            <span class="text-info d-flex align-items-center"><i
                                                                class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                                            @elseif( $row->tag === 'social' )
                                                                <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                                            @elseif( $row->tag === 'work' )
                                                                <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                                            @endif
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                        @if(auth("admin")->user()->can("important.note"))
                                                            @if ( $row->important == 1 )
                                                                <a href="javascript:void(0);"
                                                                    data-id="{{ $row->id }}" 
                                                                    data-important="{{ $row->important }}" 
                                                                    class="me-2 important">
                                                                    <span><i class="fas fa-star text-warning"></i></span>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);"
                                                                    data-id="{{ $row->id }}" 
                                                                    data-important="{{ $row->important }}" 
                                                                class="me-2 important">
                                                                    <span><i class="fas fa-star"></i></span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                            
                                                        @if(auth("admin")->user()->can("delete.note"))
                                                            <a href="javascript:void(0)"
                                                            data-id="{{ $row->id }}" 
                                                            id="deleteBtn">
                                                                <span><i class="ti ti-trash text-danger"></i></span>
                                                            </a>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="alert alert-solid-secondary alert-dismissible fade show">
                                            There is no importants notes here!
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if ( $all_notes->count() > 0 )
                            @foreach ($all_notes as $row)
                                <div class="col-md-4 d-flex">
                                    <div class="card rounded-3 mb-4 flex-fill">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">

                                                    @if ( $row->priority === 'low' )
                                                        <span
                                                        class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                    @elseif( $row->priority === 'medium' )
                                                        <span
                                                        class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                    @elseif( $row->priority === 'high' )
                                                        <span
                                                        class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>High</span>
                                                    @elseif( $row->priority === 'urgent' )
                                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>
                                                    @endif
                                                    
                                                    <div>
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu notes-menu dropdown-menu-end">

                                                        @if(auth("admin")->user()->can("update.note"))
                                                            <a href="javascript:void();" class="dropdown-item" id="editButton"
                                                                data-id="{{ $row->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"><span><i
                                                                        data-feather="edit"></i></span>Edit</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("delete.note"))
                                                            <a href="#" class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                data-id="{{ $row->id }}" 
                                                                id="deleteBtn"><span>
                                                                    <i data-feather="trash-2"></i></span>Delete</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("important.note"))
                                                            <a href="javascript:void(0);"
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="dropdown-item important"><span><i
                                                                        data-feather="star"></i></span>Not
                                                                Important</a>
                                                        @endif

                                                            <a href="#" class="dropdown-item"
                                                                id="viewButton" href="javascript:void(0)" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                            <span><i data-feather="eye"></i></span>View</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3">
                                                    <h5 class="text-truncate mb-1"><a
                                                            href="javascript:void(0);">{{ \Illuminate\Support\Str::limit($row->title, 24) }}...</a></h5>
                                                    <p class="mb-3 d-flex align-items-center text-dark"><i
                                                            class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</p>
                                                    <p class="text-truncate line-clamb-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->description, 60) }}...</p>
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between border-top pt-3">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            class="avatar avatar-md me-2">

                                                            @if ( !empty($row->image) && $row->image )
                                                                <img src="{{ asset($row->image) }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @else
                                                                <img src="{{ asset('public/admin/assets/img/profiles/avatar-01.jpg') }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @endif
                                                        </a>

                                                        @if ( $row->tag === 'personal' )
                                                            <span class="text-info d-flex align-items-center"><i
                                                            class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                                        @elseif( $row->tag === 'social' )
                                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                                        @elseif( $row->tag === 'work' )
                                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                                        @endif
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                    @if(auth("admin")->user()->can("important.note"))
                                                        @if ( $row->important == 1 )
                                                            <a href="javascript:void(0);" class="me-2">
                                                                <span><i class="fas fa-star text-warning"></i></span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" 
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="me-2 important">
                                                                <span><i class="fas fa-star"></i></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                        
                                                    @if(auth("admin")->user()->can("delete.note"))
                                                        <a href="javascript:void(0)"
                                                        data-id="{{ $row->id }}" 
                                                        id="deleteBtn">
                                                            <span><i class="ti ti-trash text-danger"></i></span>
                                                        </a>
                                                    @endif
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="alert alert-solid-secondary alert-dismissible fade show">
                                        There is no notes here!
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Important Notes --}}
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                    aria-labelledby="v-pills-messages-tab">
                    <div class="row">
                        @if ( $important_notes->count() > 0 )
                            @foreach ($important_notes as $row)
                                <div class="col-md-4 d-flex">
                                    <div class="card rounded-3 mb-4 flex-fill">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">

                                                    @if ( $row->priority === 'low' )
                                                        <span
                                                        class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                    @elseif( $row->priority === 'medium' )
                                                        <span
                                                        class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                    @elseif( $row->priority === 'high' )
                                                        <span
                                                        class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>High</span>
                                                    @elseif( $row->priority === 'urgent' )
                                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>
                                                    @endif
                                                    
                                                    <div>
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu notes-menu dropdown-menu-end">

                                                        @if(auth("admin")->user()->can("update.note"))
                                                            <a href="javascript:void();" class="dropdown-item" id="editButton"
                                                                data-id="{{ $row->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"><span><i
                                                                        data-feather="edit"></i></span>Edit</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("delete.note"))
                                                            <a href="#" class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                data-id="{{ $row->id }}" 
                                                                id="deleteBtn"><span>
                                                                    <i data-feather="trash-2"></i></span>Delete</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("important.note"))
                                                            <a href="javascript:void(0);"
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="dropdown-item important"><span><i
                                                                        data-feather="star"></i></span>Not
                                                                Important</a>
                                                        @endif

                                                            <a href="#" class="dropdown-item"
                                                                id="viewButton" href="javascript:void(0)" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                            <span><i data-feather="eye"></i></span>View</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3">
                                                    <h5 class="text-truncate mb-1"><a
                                                            href="javascript:void(0);">{{ \Illuminate\Support\Str::limit($row->title, 24) }}...</a></h5>
                                                    <p class="mb-3 d-flex align-items-center text-dark"><i
                                                            class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</p>
                                                    <p class="text-truncate line-clamb-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->description, 60) }}...</p>
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between border-top pt-3">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            class="avatar avatar-md me-2">

                                                            @if ( !empty($row->image) && $row->image )
                                                                <img src="{{ asset($row->image) }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @else
                                                                <img src="{{ asset('public/admin/assets/img/profiles/avatar-01.jpg') }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @endif
                                                        </a>

                                                        @if ( $row->tag === 'personal' )
                                                            <span class="text-info d-flex align-items-center"><i
                                                            class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                                        @elseif( $row->tag === 'social' )
                                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                                        @elseif( $row->tag === 'work' )
                                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                                        @endif
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                    @if(auth("admin")->user()->can("important.note"))
                                                        @if ( $row->important == 1 )
                                                            <a href="javascript:void(0);" class="me-2">
                                                                <span><i class="fas fa-star text-warning"></i></span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" 
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="me-2 important">
                                                                <span><i class="fas fa-star"></i></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                        
                                                    @if(auth("admin")->user()->can("delete.note"))
                                                        <a href="javascript:void(0)"
                                                        data-id="{{ $row->id }}" 
                                                        id="deleteBtn">
                                                            <span><i class="ti ti-trash text-danger"></i></span>
                                                        </a>
                                                    @endif
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="alert alert-solid-secondary alert-dismissible fade show">
                                        There is no importants notes here!
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                 {{-- Trash Notes --}}
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                    aria-labelledby="v-pills-settings-tab">
                    <div class="row">

                        @if ( $trash_notes->count() > 0 )
                            @foreach ($trash_notes as $row)
                                <div class="col-md-4 d-flex">
                                    <div class="card rounded-3 mb-4 flex-fill">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">

                                                    @if ( $row->priority === 'low' )
                                                        <span
                                                        class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                    @elseif( $row->priority === 'medium' )
                                                        <span
                                                        class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                    @elseif( $row->priority === 'high' )
                                                        <span
                                                        class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                            class="fas fa-circle fs-6 me-1"></i>High</span>
                                                    @elseif( $row->priority === 'urgent' )
                                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>
                                                    @endif
                                                    
                                                    <div>
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu notes-menu dropdown-menu-end">

                                                        @if(auth("admin")->user()->can("update.note"))
                                                            <a href="javascript:void();" class="dropdown-item" id="editButton"
                                                                data-id="{{ $row->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"><span><i
                                                                        data-feather="edit"></i></span>Edit</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("delete.note"))
                                                            <a href="#" class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                data-id="{{ $row->id }}" 
                                                                id="deleteBtn"><span>
                                                                    <i data-feather="trash-2"></i></span>Delete</a>
                                                        @endif

                                                        @if(auth("admin")->user()->can("important.note"))
                                                            <a href="javascript:void(0);"
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="dropdown-item important"><span><i
                                                                        data-feather="star"></i></span>Not
                                                                Important</a>
                                                        @endif

                                                            <a href="#" class="dropdown-item"
                                                                id="viewButton" href="javascript:void(0)" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                            <span><i data-feather="eye"></i></span>View</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3">
                                                    <h5 class="text-truncate mb-1"><a
                                                            href="javascript:void(0);">{{ \Illuminate\Support\Str::limit($row->title, 24) }}...</a></h5>
                                                    <p class="mb-3 d-flex align-items-center text-dark"><i
                                                            class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</p>
                                                    <p class="text-truncate line-clamb-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->description, 60) }}...</p>
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between border-top pt-3">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            class="avatar avatar-md me-2">

                                                            @if ( !empty($row->image) && $row->image )
                                                                <img src="{{ asset($row->image) }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @else
                                                                <img src="{{ asset('public/admin/assets/img/profiles/avatar-01.jpg') }}"
                                                                alt="Profile" class="img-fluid rounded-circle">
                                                            @endif
                                                        </a>

                                                        @if ( $row->tag === 'personal' )
                                                            <span class="text-info d-flex align-items-center"><i
                                                            class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                                        @elseif( $row->tag === 'social' )
                                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                                        @elseif( $row->tag === 'work' )
                                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                                        @endif
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                    @if(auth("admin")->user()->can("important.note"))
                                                        @if ( $row->important == 1 )
                                                            <a href="javascript:void(0);" class="me-2">
                                                                <span><i class="fas fa-star text-warning"></i></span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" 
                                                                data-id="{{ $row->id }}" 
                                                                data-important="{{ $row->important }}"
                                                                class="me-2 important">
                                                                <span><i class="fas fa-star"></i></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                        
                                                    @if(auth("admin")->user()->can("delete.note"))
                                                        <a href="javascript:void(0)"
                                                        data-id="{{ $row->id }}" 
                                                        id="deleteBtn">
                                                            <span><i class="ti ti-trash text-danger"></i></span>
                                                        </a>
                                                    @endif
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="alert alert-solid-secondary alert-dismissible fade show">
                                        There is no Trash notes here!
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('add-js')
    <!-- Owl Carousel -->
    <script src="{{ asset('public/admin/assets/js/owl.carousel.min.js') }}"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ asset('public/admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>


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
                    url: "{{ route('admin.note.store') }}",
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
                    url: "{{ url('admin/notes') }}/" + id + "/edit",
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
                    url: "{{ url('admin/notes') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');

                        swal.fire({
                            title: "Success",
                            text: "Notes Updated Successfully",
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

                            url: "{{ url('admin/notes') }}/" + id,
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

                // console.log(id, status);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.note.important') }}",
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
                    url: "{{ url('admin/notes/view') }}/" + id,
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