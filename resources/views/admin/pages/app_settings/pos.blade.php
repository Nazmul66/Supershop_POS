@extends('admin.layout.master')

@push('add-title')
    POS Setting
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
                <form action="{{ route('admin.app-settings.pos.setting.update') }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                        <select class="select form-control" name="printer_paper">
                                            <option value="a4" @if( $setting->printer_paper === 'a4' ) selected @endif>A4</option>
                                            <option value="a3" @if( $setting->printer_paper === 'a3' ) selected @endif>A3</option>
                                            <option value="b4" @if( $setting->printer_paper === 'b4' ) selected @endif>B4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>	

                            {{-- <div class="row align-items-center">
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
                            </div>	 --}}

                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="setting-info mb-0">
                                        <h6>Enable Sound Effect </h6>
                                    </div>
                                </div>

                            @php
                                $checked = '';
                                $active = '';
                                if( $setting->enable_sound == 1 ){
                                    $checked = 'checked';
                                    $active = 'active';
                                }
                            @endphp

                                <div class="col-sm-4">
                                    <input type="checkbox" id="desktop_push" class="toggle-checkbox" name="enable_sound" {{ $checked }} hidden>
                                    <label for="desktop_push" class="toggle_label {{$active}}">
                                        <span class="toggle-ball"></span>
                                    </label>
                                </div>
                            </div>									
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-secondary">Save Changes</button>
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

    <script>
		document.querySelectorAll(".toggle-checkbox").forEach((checkbox) => {
			checkbox.addEventListener("change", function () {
				if (this.checked) {
					console.log("✅ Active for", this.id);
					this.setAttribute("checked", "checked");
					this.nextElementSibling.classList.add("active");
				} else {
					console.log("❌ Inactive for", this.id);
					this.removeAttribute("checked", "");
					this.nextElementSibling.classList.remove("active");
				}
			});
		});
	</script>

@endpush