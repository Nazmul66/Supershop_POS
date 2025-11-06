
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
        
        <!-- animation CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

        <!-- Datatable CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/dataTables.bootstrap5.min.css') }}">
        
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css') }}">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">
        
    </head>

    {{-- Offline Template Show --}}
    @include('global_view.offline')


    <body class="error-page">
        <div id="global-loader" >
            <div class="whirly-loader"> </div>
        </div>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="error-box">
				<div class="error-img">
                    <img src="{{ asset('public/admin/assets/img/authentication/error-404.png') }}" class="img-fluid" alt="Img">
                </div>
				<h3 class="h2 mb-3">Oops, something went wrong</h3>
				<p>Error 404 Page not found. Sorry the page you looking for
                    doesn’t exist or has been moved</p>
				<a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
			</div>
        </div>
        <!-- /Main Wrapper -->
          

        <!-- jQuery -->
        <script src="{{ asset('public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

        <!-- Feather Icon JS -->
        <script src="{{ asset('public/admin/assets/js/feather.min.js') }}"></script>

        <!-- Slimscroll JS -->
        <script src="{{ asset('public/admin/assets/js/jquery.slimscroll.min.js') }}"></script>

        
        <!-- Bootstrap Core JS -->
        <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>
        
        <!-- Custom JS -->
        <script src="{{ asset('public/admin/assets/js/script.js') }}"></script>

	
    </body>
</html>