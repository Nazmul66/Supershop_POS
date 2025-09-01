
<!DOCTYPE html>
<html lang="en">
    <head>

		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
		<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		<title>Dreams POS - Inventory Management & Admin Dashboard Template</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/assets/img/favicon.png') }}">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/img/apple-touch-icon.png') }}">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">

        <!-- toaster css plugin -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css') }}">

         <!-- Tabler Icon CSS -->
	    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/tabler-icons/tabler-icons.css') }}">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">
		
    </head>

    
    @php
        $admin = Auth::guard('admin')->user();
        $expireAt = \Carbon\Carbon::parse($admin->two_factor_expire_at);
        $now = \Carbon\Carbon::now();
        // Get signed difference in seconds
        $remainingSeconds = $now->diffInSeconds($expireAt, false); // negative if expired
        // dd($remainingSeconds);
    @endphp

    <body class="account-page bg-white">

        {{-- <div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div> --}}
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="row login-wrapper m-0">
                    <div class="col-lg-6 p-0">
                        <div class="login-content">
                            <form id="confirmVerify" class="digit-group" method="POST">
                                @csrf 
                                
                                <div class="login-userset">
                                    <div class="login-logo logo-normal">
                                        <img src="{{ asset('public/admin/assets/img/logo.svg') }}" alt="img">
                                    </div>
                                    <a href="index.html" class="login-logo logo-white">
                                        <img src="{{ asset('public/admin/assets/img/logo-white.svg') }}"  alt="Img">
                                    </a>


                                    <div>
                                        <div class="login-userheading">
                                            <h3>Email OTP Verification</h3>
                                            <h4>OTP sent to your Email Address ending {{ maskEmail(Auth::guard('admin')->user()->email) }}</h4>
                                        </div>

                                        <div class="text-center otp-input">
                                            <div class="d-flex align-items-center mb-3">
                                                <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3" id="digit-1" name="digit-1" data-next="digit-2" maxlength="1">

                                                <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1">

                                                <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1">
                                                
                                                <input type="text" class=" rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1">
                                            </div>

                                            <div>

                                                <div class="badge bg-danger-transparent mb-3">
                                                    <p id="countdown" class="d-flex align-items-center "><i class="ti ti-clock me-1"></i>
                                                    <span >00:00</span>
                                                    </p>
                                                </div>

                                                <div class="mb-3 d-flex justify-content-center">
                                                    <p class="text-gray-9">Didn't get the OTP? <a href="javascript:void(0)" id="verify_resend" class="text-primary">Resend OTP</a></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Verify & Proceed</button>
                                        </div>
                                    </div>


                                    <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                                        <p>Copyright &copy; 2025 DreamsPOS</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="login-img">
                            <img src="{{ asset('public/admin/assets/img/authentication/authentication-06.svg') }}" alt="img">
                        </div>
                    </div>
                </div>
			</div>
        </div>
          
		<!-- /Main Wrapper -->
	
		<!-- jQuery -->
        <script src="{{ asset('public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

        <!-- toaster Js plugins  -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Sweetalert js -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

         <!-- Feather Icon JS -->
		<script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

		
		<!-- Custom JS -->
        <script src="{{ asset('public/admin/assets/js/script.js') }}"></script>


        <script>
             // Submit Verification
             $('#confirmVerify').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('verify.code') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        console.log(res);
                        $('#confirmVerify')[0].reset();

                        if (res.status === true) {
                            window.location.href = "{{ route('admin.dashboard') }}";
                        }
                        else{
                            swal.fire({
                                title: "Error",
                                text: `${res.message}`,
                                icon: "error"
                            })
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })


            // Resend Verify Code
            $(document).on('click', '#verify_resend', function () {
                $.ajax({
                    type: "GET",
                    url: "{{ route('verify.resend') }}",
                    success: function (res) {
                        verifyOtpCountDown(res.remainingSeconds);
                        $('#confirmVerify')[0].reset();

                        if (res.status === true) {
                            toastr.info(res.message, "Success", {
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }

                })
            })
        </script>

        <script>
                let countdownSeconds; // global
                let countdownTimer;   // global

                function verifyOtpCountDown(seconds) { // default 10 min
                    countdownSeconds = Math.floor(seconds);

                    // Clear previous timer if exists
                    if (countdownTimer) {
                        clearInterval(countdownTimer);
                    }

                    const countdownEl = document.getElementById("countdown").querySelector("span");

                    countdownTimer = setInterval(() => {
                        let minutes = Math.floor(countdownSeconds / 60);
                        let seconds = countdownSeconds % 60;

                        countdownEl.textContent =
                            String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');

                        countdownSeconds--;

                        if (countdownSeconds < 0) {
                            clearInterval(countdownTimer);
                            countdownEl.textContent = "00:00";
                        }
                    }, 1000);
                }

                // Initialize on page load with server-side remaining time
                verifyOtpCountDown({{ $remainingSeconds }});
        </script>


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

	
    </body>
</html>