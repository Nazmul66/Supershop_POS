
<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">

<head>

	{{-- CSS Start --}}
		@include('admin.include.css')
	{{-- CSS End --}}

</head>

<body>
	
	{{-- Loader Section Start --}}
		@include('admin.include.loader')
	{{-- Loader Section End --}}


	<!-- Main Wrapper -->
	<div class="main-wrapper">


		{{-- Header Section Start --}}
           @include('admin.include.header')
		{{-- Header Section End --}}



		{{-- Sidebar Section Start --}}
			@include('admin.include.sidebar')
		{{-- Sidebar Section End --}}



		{{-- Horizontal Section Start --}}
		    @include('admin.include.horizental_sidebar')
		{{-- Horizontal Section End --}}



		{{-- Two Col Sidebar Start --}}
		   @include('admin.include.two_sidebar')
		{{-- Two Col Sidebar End --}}



		<div class="page-wrapper">
			<div class="content">

				{{-- Body Section Start --}}
				   @yield('body-content')
				{{-- Body Section End --}}

			</div>

			
			{{-- Footer Section Start --}}
			    @include('admin.include.footer')
			{{-- Footer Section End --}}
		</div>

	</div>
	<!-- /Main Wrapper -->



	{{-- Javascript Start --}}
		@include('admin.include.js')
	{{-- Javascript End --}}

	
</body>

</html>