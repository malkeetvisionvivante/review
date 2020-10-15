<!doctype html>
<html lang="en">

	<head>
	    <title>Blossom.team</title>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="viewport" content="width=device-width, user-scalable=no">
	    <meta name="keywords" content="">
	    <meta name="title" content="Blossom.team: Log in or sign up">
	    <meta name="description" content="Explore reviews of companies, departments, managers, & more | Submit & browse objective, honest professional reviews.">
	    
	    <meta property="og:title" content="Blossom.team: Log in or sign up">
	    <meta property="og:description" content="Explore reviews of companies, departments, managers, & more | Submit & browse objective, honest professional reviews.">
	    <meta property="og:type" content="website">
	    <meta property="og:url" content="https://blossom.team/">

	    <meta name="twitter:card" content="summary">
	    <meta name="twitter:site" content="@blossom.team">
	    <meta name="twitter:title" content="Blossom.team: Log in or sign up">
	    <meta name="twitter:description" content="Explore reviews of companies, departments, managers, & more | Submit & browse objective, honest professional reviews.">
	    <!-- bootstrap-->
	    <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
	    <!-- custom css-->
	    <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ url('css/responsive.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/jQuery-plugin-progressbar.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
		<link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}" />

		<!--owl carousel css-->
		<link href="{{ url('css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">

		<!-- fontawsome-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
			integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	
		<!-- jquery-->	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		
		<!-- bootstrap-->
		<script src="{{ url('js/popper.min.js')}}"></script>
		<script src="{{ url('js/bootstrap.min.js')}}"></script>
		<script src="{{ url('js/jqvalidation.js')}}"></script>
		
		<!--owl carousel js-->
		<script src="{{ url('js/owl.carousel.min.js')}}"></script>
		<script src="{{ url('js/jQuery-plugin-progressbar.js')}}"></script>

	    @toastr_css
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<script src="{{ url('js/custom.js') }}"></script>
		<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-171618040-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-171618040-2');
		</script>
		<!-- Start of HubSpot Embed Code -->
		<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/8253412.js"></script>
		<!-- End of HubSpot Embed Code -->
	</head>
	<body>
		@if(strpos(Request::url(), 'login-user') == false)
			@include('frontend.layouts.header')
		@endif
		@yield('content')
		@if(strpos(Request::url(), 'login-user') == false)    
			@include('frontend.layouts.footer')
		@endif
		
		
		@toastr_js
    	@toastr_render
		
    </body>
</html>