<!doctype html>
<html lang="en">
<head>
    <title>Back End Domain</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- bootstrap-->
    <link rel="stylesheet" href="{{ url('admin_data/css/bootstrap.css')}}">
    <!-- custom css-->
    <link rel="stylesheet" type="text/css" href="{{ url('admin_data/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('admin_data/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('admin_data/css/custom.css') }}">
    <!-- fontawsome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- material-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ url('admin_data/js/jqvalidation.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">  
    @toastr_css  
</head>

<body>

    <section>
		@include('admin.admin_layout.header')
	</section>	
    <main class="">
        @yield('content')
    </main>
        
	@include('admin.admin_layout.footer')        
	@yield('scripts')
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	@toastr_js
    @toastr_render
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="{{ url('admin_data/js/custom.js')}}"></script>
	<script>
	  /*var ctx = document.getElementById('myChart').getContext('2d');
	  var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'bar',

	    // The data for our dataset
	    data: {
	      labels: ['', 'Apple', '', 'Industry', ''],
	      datasets: [{
	        label: '',
	        backgroundColor: 'rgb(255, 99, 132)',
	        borderColor: 'rgb(255, 99, 132)',
	        data: [0, 4.1, 0, 4.2, 0]
	      }]
	    },

	    // Configuration options go here
	    options: {

	    }
	  }); */
	</script>
	<?php
		//toastr()->success('Data has been saved successfully!'); 
		//toastr()->error('Error')
	?>
</body>

</html>