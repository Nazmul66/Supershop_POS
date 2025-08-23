@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('other-setting', 'subdrop active')
@section('backup-setting', 'active')


@section('body-content')

<div class="page-header settings-pg-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Settings</h4>
            <h6>Manage your settings on portal</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a href="{{ route('admin.cacheClear') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><i class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-xl-12">
         <div class="settings-wrapper d-flex">
            
            @include('admin.include.mini-sidebar')

            
            <div class="card flex-fill mb-0 w-50">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Database Backup</h5>
                    <div class="flex-shrink-0">
                        @if(auth("admin")->user()->can("pull.backup"))
                            <a href="{{ route('admin.other-settings.pull.backup') }}">
                                <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-banip"><i class="ti ti-circle-plus me-1"></i>Pull Latest Database</button>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">												
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>File Name</th>
                                    <th>Download</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($backups as $file)
                                    <tr>												
                                        <td class="text-gray-9 fw-medium">{{ basename($file) }}</td>
                                        @if(auth("admin")->user()->can("download.backup"))
                                            <td>
                                                <a href="{{ route('admin.other-settings.backup.download', basename($file)) }}" download>
                                                    <button type="button" class="btn btn-secondary">Download</button>
                                                </a>
                                            </td>  
                                        @endif  
                                        <td class="text-gray-9 fw-medium">
                                            <a class="p-2" href="{{ route('admin.other-settings.backup.delete', basename($file)) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </a>
                                    </td>               
                                    </tr>
                                @endforeach 							
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>						
    </div>
</div>

@endsection

@push('add-js')

@endpush

