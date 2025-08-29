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
            {{-- <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                <div class="dataTables_filter">
                    <label> <input type="search" class="form-control form-control-sm py-0" placeholder="Search"></label>
                </div></div>
            </div> --}}
            <div class="page-btn">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Note</a>
            </div>
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

                                                            <a href="javascript:void();" class="dropdown-item" id="editButton"
                                                                data-id="{{ $row->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"><span><i
                                                                        data-feather="edit"></i></span>Edit</a>

                                                            <a href="#" class="dropdown-item"
                                                                href="javascript:void(0)"
                                                                data-id="{{ $row->id }}" 
                                                                id="deleteBtn"><span>
                                                                    <i data-feather="trash-2"></i></span>Delete</a>

                                                            <a href="javascript:void(0);"
                                                                class="dropdown-item"><span><i
                                                                        data-feather="star"></i></span>Not
                                                                Important</a>
                                                            <a href="#" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#view-note-units"><span><i
                                                                        data-feather="eye"></i></span>View</a>
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
                                                            <img src="./assets/img/profiles/avatar-01.jpg"
                                                                alt="Profile" class="img-fluid rounded-circle">
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
                                                        @if ( $row->important == 1 )
                                                            <a href="javascript:void(0);" class="me-2">
                                                                <span><i class="fas fa-star text-warning"></i></span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" class="me-2">
                                                                <span><i class="fas fa-star"></i></span>
                                                            </a>
                                                        @endif
                                                        
                                                        <a href="javascript:void(0)"
                                                        data-id="{{ $row->id }}" 
                                                        id="deleteBtn">
                                                            <span><i class="ti ti-trash text-danger"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="row">
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Backup
                                                Files EOD</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Project files should
                                            be took backup before end of the day.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-05.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a
                                                href="javascript:void(0);">Download Server Logs</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Server log is a text
                                            document that contains a record of all activity.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-06.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Team
                                                meet at Starbucks</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Meeting all teamets
                                            at Starbucks for identifying them all.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-07.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-info d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a
                                                href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                    aria-labelledby="v-pills-messages-tab">
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Backup
                                                Files EOD</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Project files should
                                            be took backup before end of the day.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-05.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a
                                                href="javascript:void(0);">Download Server Logs</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Server log is a text
                                            document that contains a record of all activity.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-06.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-warning d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Team
                                                meet at Starbucks</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Meeting all teamets
                                            at Starbucks for identifying them all.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-07.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-info d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a
                                                href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                    aria-labelledby="v-pills-settings-tab">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-end">
                            <a href="#" class="btn btn-danger mb-4">
                                <span> <i class="ti ti-trash f-20 me-2"></i> </span>
                                Restore all
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-success d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-danger d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="badge bg-outline-info d-inline-flex align-items-center"><i
                                                class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit-note-units"><span><i
                                                            data-feather="edit"></i></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal"><span><i
                                                            data-feather="trash-2"></i></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><i
                                                            data-feather="star"></i></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#view-note-units"><span><i
                                                            data-feather="eye"></i></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a
                                                href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i
                                                class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile"
                                                    class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i
                                                    class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2">
                                                <span><i class="fas fa-star text-warning"></i></span>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span><i class="ti ti-trash text-danger"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row custom-pagination">
                <div class="col-md-12">
                    <div class="paginations d-flex justify-content-end">
                        <span><i class="fas fa-chevron-left"></i></span>
                        <ul class="d-flex align-items-center page-wrap">
                            <li>
                                <a href="javascript:void(0);" class="active">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    3
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    4
                                </a>
                            </li>
                        </ul>
                        <span><i class="fas fa-chevron-right"></i></span>
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


            // View Data
            $(document).on("click", '#viewButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/categories/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_category_name').html(data.category_name);
                        $('#viewImageShow').html('');
                        $('#viewImageShow').append(`
                          <a href="{{ asset("`+ data.category_img +`") }}" target="__blank">
                            <img src={{ asset("`+ data.category_img +`") }} alt="" style="width: 75px;">    
                          </a>
                       `);

                        $('#created_date').html(res.created_date);
                        $('#updated_date').html(res.updated_date);
                        $('#view_status').html(res.statusHtml);
                        $('#view_front_status').html(res.front_status_html);
                    },
                    error: function (error) {
                        console.log('error');
                    }

                });
            })
        })

    </script>

@endpush