{{-- Install Desktop APP --}}
{{-- <div class="modal fade" id="appInstallModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="appInstallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(#444444, #0a0b0c);">
                <h1 class="modal-title text-white" id="appInstallModalLabel">Welcome to DreamPos!</h1>
                <button type="button" class="btn-close" style="background-color: #FFF !important;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 16px; color: #000;">
                If you want to add a shortcut on your desktop, click the Install button.
            </div>
            <div class="modal-footer pt-3" style="background: #DDD;">
                <button type="button" id="installPwa" class="btn btn-info btn-lg mt-2">Install</button>
            </div>
        </div>
    </div>
</div> --}}



<!-- jQuery -->
<script src="{{ asset('/public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('public/admin/assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Laravel PWA Package -->
{{-- <script src="{{ asset('public/sw.js') }}"></script>
<script src="{{ asset('public/pwa-install.js') }}"></script> --}}


<!-- Chart JS -->
<script src="{{ asset('public/admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/plugins/apexchart/chart-data.js') }}"></script>

 <!-- Sweetalert js -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Color Picker JS -->
<script src="{{ asset('public/admin/assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}"></script>

 <!-- toaster Js plugins  -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('public/admin/assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/script.js') }}"></script>

@stack('add-js')


{!! Toastr::message() !!}

<script type="text/javascript">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{!! $error !!}");
        @endforeach
    @endif

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
