{{-- 
<!doctype html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ env('APP_NAME') }} | Admin Login </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public/backend/assets/images/favicon.ico') }}">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('public/backend/assets/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('public/backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        
        <!-- Icons Css -->
        <link href="{{ asset('public/backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- toaster css plugin -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Custom Css-->
        <link href="{{ asset('public/backend/assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0" style="margin-top: 120px;">
                    <div class="col-xxl-4 offset-xxl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3">
                        <div class="card mx-3">
                            <div class="card-body">
                                <div class="d-flex flex-column h-100">
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back !</h5>
                                        </div>

                                        @if ( Session::get('error_message') )
                                            <div class="alert alert-danger text-center" role="alert">
                                                <strong>Error: </strong>Invalid Login Or Password
                                            </div>
                                        @endif

                                        <form class="mt-4 pt-2" method="post" action="{{ url('/admin/login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control" id="email" autocomplete="off" placeholder="Enter Email Address">
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label for="password" class="form-label">Password</label>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="auth-recoverpw.html" class="text-muted">Forgot password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">

                                                    <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- JAVASCRIPT -->
        <script src="{{ asset("public/backend/assets/libs/jquery/jquery.min.js") }}"></script>
        <script src="{{ asset("public/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("public/backend/assets/libs/feather-icons/feather.min.js") }}"></script>

         <!-- toaster Js plugins  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- password addon init -->
        <script src="{{ asset("public/backend/assets/js/pages/pass-addon.init.js") }}"></script>

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
</html> --}}





<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- Meta Tags -->
		<meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
		<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		<title>Dreams POS - Login Page</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/assets/img/favicon.png') }}">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/img/apple-touch-icon.png') }}">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css') }}">

        <!-- Tabler Icon CSS -->
	    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/tabler-icons/tabler-icons.css') }}">

        <!-- toaster css plugin -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">
		
    </head>
    <body class="account-page">

        <div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>

		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper bg-img">
                    <div class="login-content authent-content">
                        <form method="post" action="{{ url('/admin/login') }}">
                            @csrf
                            
                            <div class="login-userset">
                                <div class="login-logo logo-normal">
                                   <img src="{{ asset('public/admin/assets/img/logo.svg') }}" alt="img">
                               </div>
                               <a href="index.html" class="login-logo logo-white">
                                   <img src="{{ asset('public/admin/assets/img/logo-white.svg') }}"  alt="Img">
                               </a>
                               <div class="login-userheading">
                                   <h3>Sign In</h3>
                                   <h4 class="fs-16">Access the Dreamspos panel using your email and passcode.</h4>
                               </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="email" name="email" id="email" autocomplete="off" value="" class="form-control border-end-0">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger"> *</span></label>
                                    <div class="pass-group">
                                        <input type="password" id="password" name="password" class="pass-input form-control" autocomplete="off">
                                        <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                    </div>
                                </div>

                               <div class="form-login authentication-check">
                                   <div class="row">
                                       <div class="col-12 d-flex align-items-center justify-content-between">
                                           <div class="custom-control custom-checkbox">
                                               <label class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                                   <input type="checkbox" class="form-control">
                                                   <span class="checkmarks"></span>Remember me
                                               </label>
                                           </div>
                                           {{-- <div class="text-end">
                                               <a class="text-orange fs-16 fw-medium" href="forgot-password.html">Forgot Password?</a>
                                           </div> --}}
                                       </div>                                    
                                   </div>
                               </div>

                               <div class="form-login">
                                   <button type="submit" class="btn btn-primary w-100">Sign In</button>
                               </div>

                               <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                                <p>Copyright &copy; 2025 DreamsPOS</p>
                            </div>
                           </div>
                        </form>
                    </div>
                </div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		  
		
		<!-- jQuery -->
        <script src="{{ asset('public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

         <!-- Feather Icon JS -->
		<script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

        <!-- toaster Js plugins  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		
		<!-- Custom JS -->
        <script src="{{ asset('public/admin/assets/js/script.js') }}"></script>

 
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