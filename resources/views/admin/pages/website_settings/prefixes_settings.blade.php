@extends('admin.layout.master')

@push('add-title')
    Prefix Setting
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
					<form action="{{ route('admin.website-settings.prefixes.update') }}" method="POST" >
					    @csrf
						@method('PUT')
						
						<div class="row">
							<div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Product (SKU)</label>
                                    <input type="text" class="form-control" name="product_prefix"
                                           value="{{ old('product_prefix', $setting->product_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" name="supplier_prefix"
                                           value="{{ old('supplier_prefix', $setting->supplier_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Purchase</label>
                                    <input type="text" class="form-control" name="purchase_prefix"
                                           value="{{ old('purchase_prefix', $setting->purchase_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Purchase Return</label>
                                    <input type="text" class="form-control" name="purchase_return_prefix"
                                           value="{{ old('purchase_return_prefix', $setting->purchase_return_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Sales</label>
                                    <input type="text" class="form-control" name="sales_prefix"
                                           value="{{ old('sales_prefix', $setting->sales_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Sales Return</label>
                                    <input type="text" class="form-control" name="sales_return_prefix"
                                           value="{{ old('sales_return_prefix', $setting->sales_return_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Customer</label>
                                    <input type="text" class="form-control" name="customer_prefix"
                                           value="{{ old('customer_prefix', $setting->customer_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Expense</label>
                                    <input type="text" class="form-control" name="expense_prefix"
                                           value="{{ old('expense_prefix', $setting->expense_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock Transfer</label>
                                    <input type="text" class="form-control" name="stock_transfer_prefix"
                                           value="{{ old('stock_transfer_prefix', $setting->stock_transfer_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock Adjustment</label>
                                    <input type="text" class="form-control" name="stock_adjustment_prefix"
                                           value="{{ old('stock_adjustment_prefix', $setting->stock_adjustment_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Sales Order</label>
                                    <input type="text" class="form-control" name="sales_order_prefix"
                                           value="{{ old('sales_order_prefix', $setting->sales_order_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">POS Invoice</label>
                                    <input type="text" class="form-control" name="pos_invoice_prefix"
                                           value="{{ old('pos_invoice_prefix', $setting->pos_invoice_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Estimation</label>
                                    <input type="text" class="form-control" name="estimate_prefix"
                                           value="{{ old('estimate_prefix', $setting->estimate_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Transaction</label>
                                    <input type="text" class="form-control" name="transaction_prefix"
                                           value="{{ old('transaction_prefix', $setting->transaction_prefix) }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Employee</label>
                                    <input type="text" class="form-control" name="employee_prefix"
                                           value="{{ old('employee_prefix', $setting->employee_prefix) }}">
                                </div>
                            </div>
						</div>
						<div class="text-end settings-bottom-btn mt-0">
							<button type="submit" class="btn btn-secondary">Update</button>
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

