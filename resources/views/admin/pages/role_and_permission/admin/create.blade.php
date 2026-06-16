@extends('admin.layout.master')

@push('add-title')
    Create Admin User
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .is-valid {
            border-color: #198754;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .form-select{
            border: 1px solid #aaa !important; 
        }
        .select2-container {
            border: 1px solid #aaa !important;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 38px !important;
            max-height: 100px !important;
            overflow-y: scroll !important;
        }
        .form-check-input {
            border: 1px solid #009688 !important;
        }
    </style>
@endpush

@section('admin-role', 'active')

@section('body-content')

    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create New Admin</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Content part Start -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Create Form</h4>
                <a href="{{ route('admin.admin-role.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.admin-role.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="branch_name" class="form-label">Branch Name</label>
                            <select class="form-select" name="branch_name[]" id="branch_name" multiple="multiple">
                                @foreach ($branch as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="selectAllBranches" style="cursor: pointer;">
                                <label class="form-check-label" for="selectAllBranches" style="cursor: pointer;">
                                    Select All Branches
                                </label>
                            </div>

                             @error('branch_name')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">User Name</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Name..." value="{{ old('name') }}"> 

                             @error('name')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phones" class="form-label">Phone</label>
                            <input class="form-control" type="number" name="phone" id="phones" placeholder="Phone..." pattern="[0-9]{11,15}" value="{{ old('phone') }}" oninput="validatePhone(this)"> 

                             @error('phone')
                                <span id="phone-error" class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password...">

                            <div class="progress mt-2" style="height:8px;">
                                <div id="passwordStrengthBar"
                                     class="progress-bar"
                                     role="progressbar"
                                     style="width:0%">
                                </div>
                            </div>
                        
                            <small id="passwordStrengthText" class="fw-bold mt-1 d-block">
                                🔴 Weak (0%)
                            </small>
                        
                            <ul class="list-unstyled mt-2 small" id="passwordRules">
                                <li id="rule-length">❌ Minimum 8 characters</li>
                                <li id="rule-upper">❌ One uppercase letter</li>
                                <li id="rule-lower">❌ One lowercase letter</li>
                                <li id="rule-number">❌ One number</li>
                                <li id="rule-special">❌ One special character</li>
                            </ul>
                            
                            @error('password')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="device_name" class="form-label">Device Name</label>
                            <select class="form-select" name="device_name[]" id="device_name" multiple="multiple">
                                @foreach ($device as $row)
                                    <option value="{{ $row->id }}">{{ $row->device_name }}</option>
                                @endforeach
                            </select>

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="selectAllDevices" style="cursor: pointer;">
                                <label class="form-check-label" for="selectAllDevices" style="cursor: pointer;">
                                    Select All Devices
                                </label>
                            </div>

                             @error('device_name')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Email..." value="{{ old('email') }}">

                            @error('email')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="role">Roles</label>
                            <select class="form-select" id="role" name="roles[]" multiple>
                                @foreach ($roles as $role)
                                   <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="selectAllRoles" style="cursor: pointer;">
                                <label class="form-check-label" for="selectAllRoles" style="cursor: pointer;">
                                    Select All Roles
                                </label>
                            </div>

                            @error('roles')
                                <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-secondary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@push('add-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#password').on('keyup', function () {

            let password = $(this).val();
            let score = 0;

            let lengthRule = password.length >= 8;
            let upperRule = /[A-Z]/.test(password);
            let lowerRule = /[a-z]/.test(password);
            let numberRule = /[0-9]/.test(password);
            let specialRule = /[^A-Za-z0-9]/.test(password);

            if (lengthRule) score += 20;
            if (upperRule) score += 20;
            if (lowerRule) score += 20;
            if (numberRule) score += 20;
            if (specialRule) score += 20;

            updateRule('#rule-length', lengthRule, 'Minimum 8 characters');
            updateRule('#rule-upper', upperRule, 'One uppercase letter');
            updateRule('#rule-lower', lowerRule, 'One lowercase letter');
            updateRule('#rule-number', numberRule, 'One number');
            updateRule('#rule-special', specialRule, 'One special character');

            $('#passwordStrengthBar').css('width', score + '%');

            let text = '';
            let color = '';

            if (score <= 20) {
                text = '🔴 Very Weak (' + score + '%)';
                color = 'bg-danger';
            } else if (score <= 40) {
                text = '🟠 Weak (' + score + '%)';
                color = 'bg-warning';
            } else if (score <= 60) {
                text = '🟡 Medium (' + score + '%)';
                color = 'bg-info';
            } else if (score <= 80) {
                text = '🟢 Strong (' + score + '%)';
                color = 'bg-success';
            } else {
                text = '🚀 Very Strong (' + score + '%)';
                color = 'bg-success';
            }

            $('#passwordStrengthBar')
                .removeClass('bg-danger bg-warning bg-info bg-success')
                .addClass(color);

            $('#passwordStrengthText').text(text);
        });

        function updateRule(id, valid, text) {
            $(id).html(
                valid
                    ? '✅ ' + text
                    : '❌ ' + text
            );
        }
    </script>

    <script>
        $('#branch_name').select2({
            placeholder: "Select Branch",
            width: '100%',
            allowClear: true,
            multiple: true,
            closeOnSelect: false,
            minimumResultsForSearch: 0
        });

        $('#device_name').select2({
            placeholder: "Select Device",
            allowClear: true,
            multiple: true,
            closeOnSelect: false
        });
        
        
        function handleSelectAll(checkboxId, selectId) {
            $(checkboxId).on('change', function () {
                if ($(this).is(':checked')) {
                    $(selectId + ' option').prop('selected', true);
                    $(selectId).trigger('change');
                } else {
                    $(selectId + ' option').prop('selected', false);
                    $(selectId).trigger('change');
                }
            });
        }

        handleSelectAll('#selectAllDevices', '#device_name');
        handleSelectAll('#selectAllBranches', '#branch_name');
        handleSelectAll('#selectAllRoles', '#role');

        function handleUnselectAll (checkboxId, selectId){
            $(selectId).on('change', function () {
                let total = $(selectId + ' option').length;
                let selected = $(this).val() ? $(this).val().length : 0;

                // if nothing selected → checkbox unchecked
                if (selected === 0) {
                    $(checkboxId).prop('checked', false);
                    return;
                }

                // if all selected → checkbox checked
                $(checkboxId).prop('checked', total === selected);
            });
        }

        handleUnselectAll('#selectAllRoles', '#role');
        handleUnselectAll('#selectAllBranches', '#branch_name');
        handleUnselectAll('#selectAllDevices', '#device_name');


        $('#role').select2({
            placeholder: "Select Role",
            allowClear: true,
            multiple: true,
            closeOnSelect: false
        });
    </script>

    <script>
        function validatePhone(input) {
            const phone = input.value; // Get the input value

            // Check if the phone number length is within the valid range
            if (phone.length >= 11 && phone.length <= 19) {
                input.classList.remove('is-invalid'); // Remove error styling
                input.classList.add('is-valid'); // Add success styling (optional)
            } else {
                input.classList.add('is-invalid'); // Add error styling
                input.classList.remove('is-valid'); // Remove success styling (optional)
            }
        }
    </script>
@endpush