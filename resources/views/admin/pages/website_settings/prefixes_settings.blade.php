@extends('admin.layout.master')

@push('add-title')
    Database Backup
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('website-setting', 'subdrop active')
@section('prefixes-setting', 'active')


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
			<a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
		</li>
		<li>
			<a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse"><i class="ti ti-chevron-up"></i></a>
		</li>
	</ul>
</div>


<div class="row">
	<div class="col-xl-12">
		 <div class="settings-wrapper d-flex">
			   @include('admin.include.mini-sidebar')
			
			
			<div class="card flex-fill mb-0">
				<div class="card-header">
					<h4 class="fs-18 fw-bold">Prefixes</h4>
				</div>
				<div class="card-body">
					<form action="prefixes.html">
						<div class="row">
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Product (SKU)</label>
									<input type="text" class="form-control" value="SKU -">
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Supplier</label>
									<input type="text" class="form-control" value="SUP -">
								</div>
							</div>									
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Purchase</label>
									<input type="text" class="form-control" value="PU -">
								</div>
							</div>										
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Purchase Return</label>
									<input type="text" class="form-control" value="PR -">
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Sales</label>
									<input type="text" class="form-control" value="SA -">
								</div>
							</div>										
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Sales Return</label>
									<input type="text" class="form-control" value="SR -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Customer</label>
									<input type="text" class="form-control" value="CT -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Expense</label>
									<input type="text" class="form-control" value="EX -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Stock Transfer</label>
									<input type="text" class="form-control" value="ST -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Stock Adjustmentt</label>
									<input type="text" class="form-control" value="SA -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Sales Order</label>
									<input type="text" class="form-control" value="SO -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">POS Invoice</label>
									<input type="text" class="form-control" value="PINV -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Estimation</label>
									<input type="text" class="form-control" value="EST -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Transaction</label>
									<input type="text" class="form-control" value="TRN -">
								</div>
							</div>	
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Employee</label>
									<input type="text" class="form-control" value="EMP -">
								</div>
							</div>	
						</div>
						<div class="text-end settings-bottom-btn mt-0">
							<button type="button" class="btn btn-secondary me-2">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
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

