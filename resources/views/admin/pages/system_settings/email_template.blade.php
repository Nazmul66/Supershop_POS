@extends('admin.layout.master')

@push('add-title')
    Admin Profile
@endpush

@push('add-css')
  
@endpush

{{-- Active sidebar --}}
@section('system-setting', 'subdrop active')
@section('email-template', 'active')


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
                <div class="card-header">
                    <h4>Email Template</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="accordion-card-one accordion" id="accordionExample">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="headingOne">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user1" class="check" checked="">
                                                <label for="user1" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>Welcome Email</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#email-detail">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample2">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="heading2">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-controls="collapse2">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user2" class="check" checked="">
                                                <label for="user2" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>Order Confirmation</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample2">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample3">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="heading3">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-controls="collapse3">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user3" class="check" checked="">
                                                <label for="user3" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>Invoice Receipt</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample3">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample4">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="heading4">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-controls="collapse4">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user4" class="check" checked="">
                                                <label for="user4" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>Subscription Renewal Reminder</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample4">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample5">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="heading5">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-controls="collapse5">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user5" class="check" checked="">
                                                <label for="user5" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>Seasonal Promotion</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample5">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample6">
                        <div class="accordion-item pb-3">
                            <div class="accordion-header" id="heading6">
                                <div class="accordion-button p-3 pb-0" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-controls="collapse6">
                                    <div class="addproduct-icon d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="status-toggle modal-status d-flex justify-content-between align-items-center me-2">
                                                <input type="checkbox" id="user6" class="check" checked="">
                                                <label for="user6" class="checktoggle">	</label>
                                            </div>
                                            <h5><span>System Update</span></h5>
                                        </div>
                                        <a href="javascript:void(0);" class="ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down chevron-down-add"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample6">
                            <div class="accordion-body border-0 pb-0">
                                <div class="row gy-4">
                                    <div class="col-xl-7">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <textarea class="form-control" cols="5" style="height: 300px">																		Hi &lt;span class="text-orange"&gt;{Customer Name}&lt;/span&gt;,&lt;br&gt; Welcome to &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;!
                                                    We’re thrilled to have you as part of our community and are eager to support you in optimizing your operations. Thank you for choosing us – we appreciate your trust and confidence.
                                                    At &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;, our mission is to make your experience seamless and efficient. From managing day-to-day tasks to improving workflows, we’re here to help you get the most out of our solutions.
                                                    If you have any questions or need assistance, our dedicated support team is always ready to assist you. Feel free to reach out anytime – we’re committed to ensuring your success.
                                                    Thank you again for trusting &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt;. We’re excited to be part of your journey and look forward to supporting you every step of the way.
                                                    Best, The &lt;span class="text-orange"&gt;{Company Name}&lt;/span&gt; Team
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                                            <a href="#" class="btn bg-cyan me-2">Save Template</a>
                                            <a href="#" class="btn btn-secondary me-2">Default Template</a>
                                            <a href="#" class="btn btn-primary">Preview Template</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h5 class="mb-2">Tags</h5>
                                                <div>
                                                    <p class="fs-12 text-orange mb-1">{Customer Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Company Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Invoice ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Receipt ID}</p>
                                                    <p class="fs-12 text-orange mb-1">{Login Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Support Email}</p>
                                                    <p class="fs-12 text-orange mb-1">{Password Reset Link}</p>
                                                    <p class="fs-12 text-orange mb-1">{Product Name}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Total}</p>
                                                    <p class="fs-12 text-orange mb-1">{Order Date}</p>
                                                    <p class="fs-12 text-orange mb-1">{Delivery Date}</p>
                                                    <p class="fs-12 text-orange">{Discount Code}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
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