@extends('admin.layout.master')

@push('title')
    Create Employee
@endpush


@push('add-css')
      <!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/select2/css/select2.min.css') }}">

    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

	<style>
		.select2-container .select2-selection--single {
			height: calc(2.25rem + 2px); /* Same as .form-control */
			padding: 0.375rem 0.75rem;   /* Same as input padding */
			border: 1px solid #ced4da;   /* Bootstrap border */
			border-radius: 0.375rem;     /* Bootstrap rounded corners */
		}

		/* Fix the arrow alignment */
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 100%;
			right: 10px;
		}

        /* CKEditor editing area */
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            height: 200px;
        }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-blurred) {
            height: 200px;
        }
	</style>
@endpush

{{-- Active sidebar --}}
@section('employee', 'active')


@section('body-content')


<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Add Employee</h4>
            <h6>Create new Employee</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li class="me-2">
            <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li class="me-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn">
        <a href="{{ route('admin.hrm.employee.index') }}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Back to List</a>
    </div>
</div>


<form action="{{ route('admin.hrm.employee.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="accordions-items-seperate" id="accordionExample">
        <div class="accordion-item border mb-4">
            <h2 class="accordion-header" id="headingOne">
                <div class="accordion-button bg-white" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">
                    <div class="d-flex align-items-center justify-content-between flex-fill">
                        <h5 class="d-inline-flex align-items-center"><i class="ti ti-users text-primary me-2"></i><span>Employee Information</span></h5>
                    </div>
                </div>
            </h2>


            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body border-top">
                <div class="new-employee-field">
                    <div class="profile-pic-upload">
                        <div class="profile-pic">
                            <span id="imagePreview"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle plus-down-add"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Profile Photo</span>
                        </div>
                        <div class="input-blocks mb-0">
                            <div class="image-upload mb-0">
                                <input type="file" name="image" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp">
                                <div class="image-uploads">
                                    <h4>Change Image</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('image')
                        <span  class="text-danger d-block mb-3">{{ $message }}</span>
                    @enderror


                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">

                                @error('first_name')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="last_name" class="form-control">

                                @error('last_name')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                <input type="email" name="email" class="form-control">

                                @error('email')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Number<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="contact_number" class="form-control">

                                @error('contact_number')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Blood Group<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="blood_group">
                                    <option value="" disabled selected>Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>

                                @error('blood_group')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emp Code<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="employee_code" value="{{ getSetting()->employee_prefix }}" class="form-control">
                            </div>
                        </div> --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="input-blocks">
                                <label class="form-label">Date of Birth<span class="text-danger ms-1">*</span></label>
                                <div class="input-groupicon calender-input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar info-img"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <input type="date" class="date_of_birth form-control" placeholder="Select Date" name="date_of_birth">
                                </div>
                            </div>

                            @error('date_of_birth')
                                <span  class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gender<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="gender">
                                    <option value="" disabled selected>Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                                @error('gender')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nationality<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="nationality">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($countries as $row)
                                        <option value="{{ $row->id }}">{{ $row->country_name }}</option>	
                                    @endforeach	
                                </select>

                                @error('nationality')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="input-blocks">
                                <label>Joining Date<span class="text-danger ms-1">*</span></label>
                                <div class="input-groupicon calender-input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar info-img"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <input type="text" class="joining_date form-control" placeholder="Select Date" name="joining_date">
                                </div>
                            </div>

                            @error('joining_date')
                                <span  class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Department<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="department_id">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($departments as $row)
                                        <option value="{{ $row->id }}">{{ $row->department }}</option>
                                    @endforeach
                                </select>

                                @error('department_id')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Designation<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="designation_id">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($designations as $row)
                                        <option value="{{ $row->id }}">{{ $row->designation }}</option>
                                    @endforeach
                                </select>

                                @error('designation_id')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                <select class="select2 form-control" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Deactive</option>
                                </select>

                                @error('status')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Editor -->
                    <div class="col-lg-12">
                        <div class="input-blocks summer-description-box transfer mb-3">
                            <label for="about">About</label>

                            <textarea class="form-control" id="about" name="about" rows="7">{{ old('about') }}</textarea>

                            @error('about')
                                <span  class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /Editor -->
                </div>
            </div>
            </div>
        </div>
        
        <div class="accordion-item border mb-4">
            <div class="accordion-header" id="headingThree">
                <div class="accordion-button bg-white" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree">
                    <div class="d-flex align-items-center justify-content-between flex-fill">
                        <h5 class="d-inline-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin feather-edit text-primary me-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><span>Address Information</span></h5>
                    </div>
                </div>
            </div>
            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body border-top">
                <div class="other-info">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control">

                                @error('address')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <select class="select2 form-control" name="country_id">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($countries as $row)
                                        <option value="{{ $row->id }}">{{ $row->country_name }}</option>	
                                    @endforeach				
                                </select>

                                @error('country_id')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <select class="select2 form-control" name="state_id">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($states as $row)
                                        <option value="{{ $row->id }}">{{ $row->state_name }}</option>	
                                    @endforeach		
                                </select>

                                @error('state_id')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <select class="select2 form-control" name="city_id">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($cities as $row)
                                        <option value="{{ $row->id }}">{{ $row->city_name }}</option>	
                                    @endforeach				
                                </select>

                                @error('city_id')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Zipcode</label>
                                <input type="text" name="zip_code" class="form-control">

                                @error('zip_code')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <div class="accordion-item border mb-4">
            <div class="accordion-header" id="heading4">
                <div class="accordion-button bg-white" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-controls="collapseFour">
                    <div class="d-flex align-items-center justify-content-between flex-fill">
                        <h5 class="d-inline-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info feather-edit text-primary me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg><span>Emergency Information</span></h5>
                    </div>
                </div>
            </div>
            <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="heading4" data-bs-parent="#accordionExample">
            <div class="accordion-body border-top">
                <div class="other-info">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergency Contact Number 1</label>
                                <input type="text" name="emergency_number_1" class="form-control">

                                @error('emergency_number_1')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Relation</label>
                                <input type="text" name="emergency_relation_1" class="form-control">

                                @error('emergency_relation_1')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="relation_name_1" class="form-control">

                                @error('relation_name_1')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergency Contact Number 2</label>
                                <input type="text" name="emergency_number_2" class="form-control">

                                @error('emergency_number_2')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Relation</label>
                                <input type="text" name="emergency_relation_2" class="form-control">

                                @error('emergency_relation_2')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="relation_name_2" class="form-control">

                                @error('relation_name_2')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <div class="accordion-item border mb-4">
            <div class="accordion-header" id="heading5">
                <div class="accordion-button bg-white" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-controls="collapseFive">
                    <div class="d-flex align-items-center justify-content-between flex-fill">
                        <h5 class="d-inline-flex align-items-center"><i class="ti ti-building-bank feather-edit text-primary me-2"></i><span>Bank Information</span></h5>
                    </div>
                </div>
            </div>
            <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="heading5" data-bs-parent="#accordionExample">
            <div class="accordion-body border-top">
                <div class="other-info">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control">

                                @error('bank_name')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="account_number" class="form-control">

                                @error('account_number')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">IFSC / Routing Number</label>
                                <input type="text" name="routing_number" class="form-control">

                                @error('routing_number')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Branch</label>
                                <input type="text" name="branch_name" class="form-control">

                                @error('branch_name')
                                    <span  class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>


    </div>
    <!-- /product list -->

    <div class="text-end mb-3">
        <button type="submit" class="btn btn-primary">Add Employee</button>
    </div>
</form>


@endsection


@push('add-js')
  
	<!-- Select2 Js -->
	<script src="{{ asset('public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Ckeditor JS -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

	<script>
        		// Function to handle image preview
		function previewImage(input, previewId) {
			const file = input.files[0];
			const preview = document.getElementById(previewId);

			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:60px; display:block; border-radius: 50px;">`;
				}
				reader.readAsDataURL(file);
			}
		}

		// Attach event listeners
		document.getElementById('imageInput').addEventListener('change', function() {
			previewImage(this, 'imagePreview');
		});


		$(document).ready(function () {
			$('.select2').select2();

            // Flatpicker Plugin
            $(".date_of_birth").flatpickr();

            $(".joining_date").flatpickr();

            // Ckeditor 5 plugin
            let jReq;
            ClassicEditor
            .create(document.querySelector('#about'))
            .then(newEditor => {
                jReq = newEditor;
                // newEditor.ui.view.editable.element.style.height = '400px';
            })
            .catch(error => {
                console.error(error);
            });
		});
    </script>

@endpush