@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>
    <div class="card">
        <div class="row p-0">
            <div class="col-md-12 col-12">
            	<div class="title text-center">
                    <h3>Visitors</h3>
                    <a data-toggle="collapse" href="#visitorsDownload" role="button" aria-expanded="false" aria-controls="visitorsDownload">
                    Report
                    </a>
                    @if(session()->has('visitor_fileName'))
                        <a id="visitor_file" class="text-success" href="{{ url('admin_data/reports/visitors/'. session('visitor_fileName')) }}" download> Download </a>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#visitor_file')[0].click();
                            });
                        </script>
                    @endif  
                </div>
                <div class="collapse" id="visitorsDownload">
                    <div class="card card-body">
                        <form action="{{ url('/admin/download-visitor-report') }}" method="post" id="visitor-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control" name="start_date" readonly autocomplete="off" id="datepicker1">
                                         <span id="errorVisitorStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control" name="end_date" readonly autocomplete="off" id="datepicker2">
                                        <span id="errorVisitorEndDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success round-shape">Generate</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>   
                    </div>
                </div>
            	<div id="visitors"></div>
            </div>
            <div class="col-md-12 col-12">
                <hr>
                <div class="title text-center">
                    <h3>Reviews</h3>
                    <a data-toggle="collapse" href="#reviewDownload" role="button" aria-expanded="false" aria-controls="reviewDownload">
                    Report
                    </a>
                    @if(session()->has('review_fileName'))
                        <a id="review_file" class="text-success" href="{{ url('admin_data/reports/review/'. session('review_fileName')) }}" download> Download </a>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#review_file')[0].click();
                            });
                        </script>
                    @endif  
                </div>
                <div class="collapse" id="reviewDownload">
                    <div class="card card-body">
                        <form action="{{ url('/admin/download-review-report') }}" method="post" id="review-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control" name="start_date" readonly autocomplete="off" id="datepicker3">
                                         <span id="errorReviewStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control" name="end_date" readonly autocomplete="off" id="datepicker4">
                                        <span id="errorReviewEndDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success round-shape">Generate</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>   
                    </div>
                </div>
            	<div id="reviews"></div>
            </div>
        </div>
        <hr>
        <div class="row p-0">
            <div class="col-md-12 col-12">
                <div class="title text-center">
                    <h3>New User SignUps</h3>
                    <a data-toggle="collapse" href="#signupUserDownload" role="button" aria-expanded="false" aria-controls="signupUserDownload">
                    Report
                    </a>
                    @if(session()->has('signup_user_fileName'))
                        <a id="signup_user_file" class="text-success" href="{{ url('admin_data/reports/signup_user/'. session('signup_user_fileName')) }}" download> Download </a>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#signup_user_file')[0].click();
                            });
                        </script>
                    @endif  
                </div>
                <div class="collapse" id="signupUserDownload">
                    <div class="card card-body">
                        <form action="{{ url('/admin/download-signup-user-report') }}" method="post" id="signup-user-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control" name="start_date" readonly autocomplete="off" id="datepicker5">
                                         <span id="errorSignupUserStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control" name="end_date" readonly autocomplete="off" id="datepicker6">
                                        <span id="errorSignupUserEndDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Account Type</label>
                                        <div class="dropdown show">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li class="dropdown-item" >
                                                    <input id="acc1_user" name="account_type[]" value="user" type="checkbox">
                                                    <label for="acc1_user">User</label>
                                                </li>
                                                <li class="dropdown-item">
                                                    <input id="acc1_profile" name="account_type[]" value="profile" type="checkbox">
                                                    <label for="acc1_profile">Profile</label>
                                                </li>                               
                                            </ul>
                                        </div>
                                        <span id="errorSignupUserAccountType"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Number of record's form</label>
                                        <input type="text" placeholder="From" class="form-control" name="from" value="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Number of record's to</label>
                                        <input type="text" placeholder="To" class="form-control" name="to" value="5000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success round-shape">Generate</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>   
                    </div>
                </div>
            	<div id="users" ></div>
            </div>
            <div class="col-md-12 col-12">
                <hr>
                <div class="title text-center">
                    <h3>Average Reviews Per User</h3>
                    <a data-toggle="collapse" href="#avgReviewPerUserDownload" role="button" aria-expanded="false" aria-controls="avgReviewPerUserDownload">
                    Report
                    </a>
                    @if(session()->has('review_per_user_fileName'))
                        <a id="review_per_user_file" class="text-success" href="{{ url('admin_data/reports/review_per_user/'. session('review_per_user_fileName')) }}" download> Download </a>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#review_per_user_file')[0].click();
                            });
                        </script>
                    @endif  
                </div>
                <div class="collapse" id="avgReviewPerUserDownload">
                    <div class="card card-body">
                        <form action="{{ url('/admin/download-review-per-user-report') }}" method="post" id="review-per-use-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control" name="start_date" readonly autocomplete="off" id="datepicker9">
                                         <span id="errorReviewPerUserStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control" name="end_date" readonly autocomplete="off" id="datepicker10">
                                        <span id="errorReviewPerUserEndDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Account Type</label>
                                        <div class="dropdown show">
                                          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Account
                                          </a>

                                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li class="dropdown-item" >
                                                <input id="acc_user" name="account_type[]" value="user" type="checkbox">
                                                <label for="acc_user">User</label>
                                            </li>
                                            <li class="dropdown-item">
                                                <input id="acc_profile" name="account_type[]" value="profile" type="checkbox">
                                                <label for="acc_profile">Profile</label>
                                            </li>
                                            <li class="dropdown-item">
                                                <input id="acc_invitee" name="account_type[]" value="invitee" type="checkbox">
                                                <label for="acc_invitee">Invitee</label>
                                            </li>
                                            <li class="dropdown-item">
                                                <input id="acc_visitor" name="account_type[]" value="visitor" type="checkbox">
                                                <label for="acc_visitor">Visitor</label>
                                            </li>  
                                            <li class="dropdown-item">
                                                <input id="acc_visitor" name="account_type[]" value="guest" type="checkbox">
                                                <label for="acc_visitor">Guest</label>
                                            </li>                                    
                                          </ul>
                                        </div>
                                        <span id="errorReviewPerUserAccountType"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Number of record's form</label>
                                        <input type="text" placeholder="From" class="form-control" name="from" value="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Number of record's to</label>
                                        <input type="text" placeholder="To" class="form-control" name="to" value="5000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success round-shape">Generate</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>   
                    </div>
                </div>
             	<div id="average_reviews_per_user"></div>
            </div>
        </div>
        <hr>
        <div class="row p-0">
            <div class="col-md-12 col-12">
                <div class="title text-center">
                    <h3>Referrals</h3>
                    <a data-toggle="collapse" href="#ReferralsDownload" role="button" aria-expanded="false" aria-controls="ReferralsDownload"> Report</a>
                    @if(session()->has('referrals_fileName'))
                        <a id="referrals_file" class="text-success" href="{{ url('admin_data/reports/referrals/'. session('referrals_fileName')) }}" download> Download </a>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#referrals_file')[0].click();
                            });
                        </script>
                    @endif  
                </div>
                <div class="collapse" id="ReferralsDownload">
                    <div class="card card-body">
                        <form action="{{ url('/admin/download-referrals-report') }}" method="post" id="referrals-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control" name="start_date" readonly autocomplete="off" id="datepicker7">
                                         <span id="errorReferralsStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control" name="end_date" readonly autocomplete="off" id="datepicker8">
                                        <span id="errorReferralsEndDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success round-shape">Generate</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  	google.charts.load('current', {'packages':['corechart']});
  	google.charts.setOnLoadCallback(drawChart);

 	function drawChart() {
 		var reviewOptions = {  legend: { position: 'bottom' }, hAxis: { minValue: 0, maxValue: 9 }, curveType: 'function', pointSize: 3, vAxis: {title: 'Number Of Users', viewWindow:{min:0 } } };
	    var reviewData = google.visualization.arrayToDataTable(<?php echo json_encode( $reviewArray, JSON_PRETTY_PRINT ) ?>);	    
	    var reviewChart = new google.visualization.LineChart(document.getElementById('reviews'));
	    reviewChart.draw(reviewData, reviewOptions);

        var usersOptions = {  legend: { position: 'bottom' }, hAxis: { minValue: 0, maxValue: 9 }, curveType: 'function', pointSize: 3, vAxis: {title: 'Number Of Users', viewWindow:{min:0 } } };

	    //var usersOptions = { title: '', curveType: 'function', legend: { position: 'bottom' }, vAxis: {title: 'Number Of Users', viewWindow:{min:0 } } };
	    var usersData = google.visualization.arrayToDataTable(<?php echo json_encode( $userArray, JSON_PRETTY_PRINT ) ?>);	    
	    var usersChart = new google.visualization.LineChart(document.getElementById('users'));
	    usersChart.draw(usersData, usersOptions);

        var avgUserReviewsOptions = {  legend: { position: 'bottom' }, hAxis: { minValue: 0, maxValue: 9 }, curveType: 'function', pointSize: 3, vAxis: {title: 'Reviews', viewWindow:{min:0 } } };
	    //var avgUserReviewsOptions = { title: '', curveType: 'function', legend: { position: 'bottom' }, vAxis: {title: 'Reviews', viewWindow:{min:0 } } };
	    var avgUserReviewsData = google.visualization.arrayToDataTable(<?php echo json_encode( $avgUserReviewsArray, JSON_PRETTY_PRINT ) ?>);
	    var avgUserReviewsChart = new google.visualization.LineChart(document.getElementById('average_reviews_per_user'));
	    avgUserReviewsChart.draw(avgUserReviewsData, avgUserReviewsOptions);

        var visitorsOptions = {  legend: { position: 'bottom' }, hAxis: { minValue: 0, maxValue: 9 }, curveType: 'function', pointSize: 3, vAxis: {title: 'Number Of Visitors', viewWindow:{min:0 } } };

	    //var visitorsOptions = { title: '', curveType: 'function', legend: { position: 'bottom' }, vAxis: {title: 'Number Of Visitors', viewWindow:{min:0 } }};
	    var visitorsData = google.visualization.arrayToDataTable(<?php echo json_encode( $visitorsArray, JSON_PRETTY_PRINT ) ?>);	
	    var visitorsChart = new google.visualization.LineChart(document.getElementById('visitors'));
	    visitorsChart.draw(visitorsData, visitorsOptions);

  	}
</script>
<style type="text/css">
	#visitors, #reviews , #users, #average_reviews_per_user{ height: 400px; } 
    li.dropdown-item input.error-message { color: red; float: none; width: auto; }
    @media (max-width:767px) {
        .title{margin-top: 75px;}
    }
</style>
@include('admin.dashboard_script')
@endsection