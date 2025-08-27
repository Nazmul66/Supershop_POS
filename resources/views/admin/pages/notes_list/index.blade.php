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
                    <a href="notes.html" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
                </li>
            </ul>
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                <div class="dataTables_filter">
                    <label> <input type="search" class="form-control form-control-sm py-0" placeholder="Search"></label>
                </div></div>
            </div>
            <div class="page-btn">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ti ti-circle-plus me-1"></i>Add Note</a>
            </div>
        </div>
    </div>


    <!-- Note Unit -->
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
                            </div>											
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select" name="assign_user_id">
                                    <option value="1" selected>user 1</option>
                                    <option value="0">user 2</option>
                                </select>
    
                                <span id="status_validate" class="text-danger mt-1"></span>
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

                                    <span id="status_validate" class="text-danger mt-1"></span>
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

                                    <span id="status_validate" class="text-danger mt-1"></span>
                                </div>
                            </div>
                       </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="description">Descriptions<span class="text-danger ms-1">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
    <!-- /Note Unit -->


    <div class="row" style="transform: none;">
        <div class="col-xl-3 col-md-12 sidebars-right theiaStickySidebar section-bulk-widget" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
            
        <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none; top: 0px; left: 276px;"><div class="border rounded-3 bg-white p-3">
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
                <div class="mt-3">
                    <div class="border-bottom px-2 pb-3 mb-3">
                        <h5 class="mb-2">Tags</h5>
                        <div class="d-flex flex-column mt-2">
                            <a href="javascript:void(0);" class="text-info mb-2">
                                <span class="text-info me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Pending
                            </a>
                            <a href="javascript:void(0);" class="text-danger mb-2">
                                <span class="text-danger me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Onhold
                            </a>
                            <a href="javascript:void(0);" class="text-warning mb-2">
                                <span class="text-warning me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Inprogress
                            </a>
                            <a href="javascript:void(0);" class="text-success">
                                <span class="text-success me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Done
                            </a>
                        </div>
                    </div>
                    <div class="px-2">
                        <h5 class="mb-2">Priority</h5>
                        <div class="d-flex flex-column mt-2">
                            <a href="javascript:void(0);" class="text-warning mb-2">
                                <span class="text-warning me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Medium
                            </a>
                            <a href="javascript:void(0);" class="text-success mb-2">
                                <span class="text-success me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                High
                            </a>
                            <a href="javascript:void(0);" class="text-danger">
                                <span class="text-danger me-2">
                                    <i class="fas fa-square square-rotate fs-10"></i>
                                </span>
                                Low
                            </a>
                        </div>
                    </div>
                </div>
            </div><div class="resize-sensor" style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;"><div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0px; top: 0px; transition: all; width: 281px; height: 1112px;"></div></div><div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div></div></div></div></div>
        <div class="col-xl-9 budget-role-notes">
            <div class="bg-white rounded-3 d-flex align-items-center justify-content-between flex-wrap mb-4 p-3 pb-0">
                <div class="form-sort me-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders info-img"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    <select class="select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="3">Sort by A-Z</option>
                        <option>Ascending </option>
                        <option>Descending</option>
                        <option>Recently Viewed </option>
                        <option>Recently Added</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-town-container"><span class="select2-selection__rendered" id="select2-town-container" role="textbox" aria-readonly="true" title="Sort by A-Z">Sort by A-Z</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="input-icon-start me-2 position-relative">
                        <span class="icon-addon">
                            <i class="ti ti-calendar"></i>
                        </span>
                        <input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
                    </div>
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        <div class="dataTables_filter">
                            <label> <input type="search" class="form-control form-control-sm" placeholder="Search"></label>
                        </div></div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="v-pills-tabContent2">
                <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="border-bottom mb-4 pb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <h4>Important </h4>
                                        <div class="owl-nav slide-nav5 text-end nav-control ms-3"></div>
                                    </div>
                                    <div class="notes-close mb-3">
                                        <a href="javascript:void(0);" class="text-danger fs-15"><i class="fas fa-times me-1"></i> Close </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="notes-slider owl-carousel owl-loaded owl-drag">
                                    
                                    
                                    
                                    
                                    
                                <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(-813px, 0px, 0px); transition: all; width: 2984px;"><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Learn calligraphy</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>24 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Calligraphy,
                                                    the art of beautiful handwriting. The term may derive
                                                    from the Greek words. </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-03.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                    </div></div><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Plan a trip to another
                                                        country</a></h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Space, the
                                                    final frontier. These are the voyages of the Starship
                                                    Enterprise.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-01.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                    </div></div><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Improve touch typing</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Well, the
                                                    way they make shows is, they make one show.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-02.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                    </div></div><div class="owl-item active" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Plan a trip to another
                                                        country</a></h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Space, the
                                                    final frontier. These are the voyages of the Starship
                                                    Enterprise.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-01.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                    </div></div><div class="owl-item active" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Improve touch typing</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>22 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Well, the
                                                    way they make shows is, they make one show.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-02.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                    </div></div><div class="owl-item active" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Learn calligraphy</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>24 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Calligraphy,
                                                    the art of beautiful handwriting. The term may derive
                                                    from the Greek words. </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-03.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                    </div></div><div class="owl-item" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Plan a trip to another
                                                        country</a></h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Space, the
                                                    final frontier. These are the voyages of the Starship
                                                    Enterprise.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-01.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                    </div></div><div class="owl-item" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Improve touch typing</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Well, the
                                                    way they make shows is, they make one show.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-02.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                    </div></div><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Plan a trip to another
                                                        country</a></h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Space, the
                                                    final frontier. These are the voyages of the Starship
                                                    Enterprise.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-01.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                    </div></div><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Improve touch typing</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>22 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Well, the
                                                    way they make shows is, they make one show.</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-02.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                    </div></div><div class="owl-item cloned" style="width: 247.25px; margin-right: 24px;"><div class="card rounded-3 mb-0">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                                <div>
                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                        <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not
                                                            Important</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Learn calligraphy</a>
                                                </h5>
                                                <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>24 Jan 2024</p>
                                                <p class="text-truncate line-clamb-2 text-wrap">Calligraphy,
                                                    the art of beautiful handwriting. The term may derive
                                                    from the Greek words. </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                        <img src="./assets/img/profiles/avatar-03.jpg" alt="Profile" class="img-fluid rounded-circle">
                                                    </a>
                                                    <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                    </div></div></div></div><div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i class="fas fa-chevron-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="fas fa-chevron-right"></i></button></div><div class="owl-dots disabled"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Backup
                                                Files EOD</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Project files should
                                            be took backup before end of the day.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-05.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                        <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Download Server Logs</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Server log is a text
                                            document that contains a record of all activity.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-06.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                        <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Team
                                                meet at Starbucks</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Meeting all teamets
                                            at Starbucks for identifying them all.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-07.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                        <span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                        <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <div class="card rounded-3 mb-4 flex-fill">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Backup
                                                Files EOD</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>20 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Project files should
                                            be took backup before end of the day.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-05.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                        <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Download Server Logs</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>25 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Server log is a text
                                            document that contains a record of all activity.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-06.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                                        <span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Team
                                                meet at Starbucks</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>26 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Meeting all teamets
                                            at Starbucks for identifying them all.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-07.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                        <span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                        <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
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
                                        <span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Create
                                                a compost pile</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>27 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Compost pile refers
                                            to fruit and vegetable scraps, used tea, coffee grounds etc..
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-08.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-warning d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Social</span>
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
                                        <span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Take a
                                                hike at a local park</a></h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Hiking involves a
                                            long energetic walk in a natural environment.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-09.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-info d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Personal</span>
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
                                        <span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>medium</span>
                                        <div>
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu notes-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>Edit</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>Delete</a>
                                                <a href="javascript:void(0);" class="dropdown-item"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>Not Important</a>
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-note-units"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <h5 class="text-truncate mb-1"><a href="javascript:void(0);">Research a topic interested</a>
                                        </h5>
                                        <p class="mb-3 d-flex align-items-center text-dark"><i class="ti ti-calendar me-1"></i>28 Jan 2024</p>
                                        <p class="text-truncate line-clamb-2 text-wrap">Research a topic
                                            interested by listen actively and attentively.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                <img src="./assets/img/profiles/avatar-10.jpg" alt="Profile" class="img-fluid rounded-circle">
                                            </a>
                                            <span class="text-success d-flex align-items-center"><i class="fas fa-square square-rotate fs-10 me-1"></i>Work</span>
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

@endpush