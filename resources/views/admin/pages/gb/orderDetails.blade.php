@extends('admin.layout.master')

@push('title')
    Create FAQ
@endpush


@push('add-css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: "Arimo", sans-serif !important;
        }
        .ti-chevron-left,
        .ti-chevron-right{
            border: 2px solid #092C4C;
            padding: 5px;
            background: #F9FAFB;
            border-radius: 4px;
            cursor: pointer;
        }
        .additional_box{
            position: relative;
        }
        .additional_box .btn_note{
            position: absolute;
            top: -38px;
            right: 0;
        }
    </style>
@endpush

{{-- Active sidebar --}}
@section('faq', 'active')


@section('body-content')

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">FAQ</h4>
                <h6>Manage your Faqs</h6>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-4">
                        <p class="badge badge-xl bg-soft-info my-1 me-2">
                            <span id="copyName">GB-4658</span> <span id="copyId" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-success" data-bs-placement="top" data-bs-original-title="Copy" class="text-success ms-2" style="cursor: pointer;"><i class="ti ti-copy"></i></span>
                        </p>

                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Pending
                            </a>
                            <ul class="dropdown-menu" style="">
                                <li><a class="dropdown-item" href="#"><strong>Pending</strong></a></li>
                                <li><a class="dropdown-item" href="#"><strong>On Hold</strong></a></li>
                                <li><a class="dropdown-item" href="#"><strong>Cancelled</strong></a></li>
                            </ul>
                        </div>

                        <div class="ms-3">
                            <i class="ti ti-chevron-left" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Previous"></i>

                            <i class="ti ti-chevron-right" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" data-bs-placement="top" data-bs-original-title="Next"></i>
                        </div>
                    </div>

                    <p class="mb-2"><strong>Shipping Date :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>On Hold Reason :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>Cancelled Reason :</strong> Dec 12-2025 09:10 P.M</p>
                    <p class="mb-2"><strong>Auto approve date :</strong> Dec 12-2025 09:10 P.M</p>
                    <div class="mb-2 d-flex align-items-center gap-1"><strong>Assign to delivery partner :</strong> <img src="{{ asset('public/admin/assets/images/steadfast.png') }}" alt="" width="20"> Steadfast </div>
                    <div class="mb-2 d-flex align-items-center gap-1"><strong>Source :</strong>  Website <img src="{{ asset('public/admin/assets/img/logo-small.png') }}" alt="" width="20"> </div>
                    <p class="mb-2"><strong>Delivery Type :</strong> Regular / New</p>
                    <p class="mb-2"><strong>Source Info :</strong> https://ghorerbazar.com/collections/dates</p>
                    <p class="mb-2"><strong>Delivery Note :</strong> dgdfg</p>
                    <p class="mb-2"><strong>Additional Note :</strong></p>
                    <div class="additional_box">
                        <textarea name="" class="form-control" id="additional_form" cols="30" rows="4" disabled></textarea>
                        <div class="btn_note">
                            <button class="btn btn-square btn-secondary">Add Note</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 offset-lg-4">
                    df
                </div>
            </div>
        </div>
    </div>
@endsection

@push('add-js')
<script>
    // Copy Order Id function
    document.getElementById('copyId').addEventListener('click', function () {
        const copyText = document.getElementById('copyName').innerText;
        const iconWrapper = this;

        // Copy to clipboard
        navigator.clipboard.writeText(copyText).then(() => {
            // Change icon to check
            this.setAttribute("data-bs-original-title", "Copied!");
            iconWrapper.innerHTML = '<i class="ti ti-checks"></i>';

            // Revert back after 3 seconds
            setTimeout(() => {
                this.setAttribute("data-bs-original-title", "Copy");
                iconWrapper.innerHTML = '<i class="ti ti-copy"></i>';
            }, 3000);
        }).catch(error => {
            console.error('Copy failed:', error);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('additional_form');
        const btnContainer = document.querySelector('.btn_note');

        // Initial Add Note click
        btnContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-secondary')) {
                enableNote();
            }

            if (e.target.closest('.btn-danger')) {
                cancelNote();
            }

            if (e.target.closest('.btn-success')) {
                saveNote();
            }
        });

        function enableNote() {
            textarea.removeAttribute('disabled');
            textarea.setAttribute('placeholder', 'Write here...');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-danger">Cancel</button>
                <button type="button" class="btn btn-square btn-success ms-2">Save</button>
            `;
        }

        function cancelNote() {
            textarea.value = '';
            textarea.setAttribute('disabled', true);
            textarea.removeAttribute('placeholder');

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-secondary">Add Note</button>
            `;
        }

        function saveNote() {
            textarea.setAttribute('disabled', true);

            // 🔹 Add AJAX / form submit here if needed

            btnContainer.innerHTML = `
                <button type="button" class="btn btn-square btn-secondary">Add Note</button>
            `;
        }
    });
</script>
@endpush