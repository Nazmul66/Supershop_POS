<!-- jQuery -->
<script src="{{ asset('/public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('public/admin/assets/js/jquery.slimscroll.min.js') }}"></script>

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
</script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
