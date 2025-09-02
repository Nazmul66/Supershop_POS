@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('app-setting', 'subdrop active')
@section('pos-setting', 'active')


@section('body-content')


<div class="page-header">
	<div class="add-item d-flex">
		<div class="page-title">
			<h4 class="fw-bold">Settings</h4>
			<h6>Manage your settings on portal</h6>
		</div>
	</div>
	<ul class="table-top-head">
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
				<i class="ti ti-refresh"></i>
			</a>
		</li>
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse">
				<i class="ti ti-chevron-up"></i>
			</a>
		</li>
	</ul>
</div>


<div class="row">
    <div class="col-xl-12">
         <div class="settings-wrapper d-flex">
            @include('admin.include.mini-sidebar')

            
            <div class="card flex-fill mb-0">
                <form action="pos-settings.html">
                    <div class="card-header">
                        <h4>POS Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="localization-info">
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>POS Printer</h6>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="localization-select">
                                        <select class="select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="3">A4</option>
                                            <option>A4</option>
                                            <option>A4</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-69hq-container"><span class="select2-selection__rendered" id="select2-69hq-container" role="textbox" aria-readonly="true" title="A4">A4</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>	
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>Payment Method</h6>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="localization-select pos-payment-method d-flex align-items-center mb-0 w-100">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>COD
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>Cheque
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>Card
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>Paypal
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>Bank Transfer
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs mb-0 pb-0 line-height-1">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>Cash
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>	
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info">
                                        <h6>Enable Sound Effect </h6>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="localization-select d-flex align-items-center">
                                        <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-3">
                                            <input type="checkbox" id="user4" class="check" checked="">
                                            <label for="user4" class="checktoggle"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>									
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-submit">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>


@endsection

@push('add-js')

    <!-- Sticky-sidebar -->
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@endpush