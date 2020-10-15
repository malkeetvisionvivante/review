@extends('frontend.layouts.apps')
@section('content')
<!--banner start-->  
<style>
  section.sticky-top {
    background-color: #e5f4fb;
}
.btn-login, .btn-login:hover, .btn-login:focus, .btn-login:visited{
  border-radius:100px;
  background:#fff !important;
  color:#000 !important;
}
footer{
  background:url("{{ asset('images/footer-bg.svg') }}") #e5f4fb;
  background-repeat: no-repeat;
  background-size: cover;
  margin: 0;
  padding: 12rem 0 1rem 0;
}
footer h4{
  color:#fff;
}
.footer-nav a{
  color:#fff;
}
.footer-nav a:hover{
  text-decoration:underline;
  color:#fff;
}
footer p.text-muted{
  color:#fff !important;
}
/* .navbar-outer-div{
    background-color:#e5f4fb;
} */
.header-tooltip {
position: relative;
z-index: 2;
color: #fff;
}
.btn-invite-learn-more{
  background-color: white;
  padding: 6px 18px;
  border-radius: 5px;
}
.btn-invite-learn-more {
    background-color: white;
    padding: 5px 20px;
    border-radius: 5px;
    border: 1px solid #000;
    font-weight: 700;
    color: #0580c3 ;
}
.header::before {
    content: "";
    background-color: #e5f4fb;
    position: absolute;
    width: 100%;
    height: 100%;
    top: -27%;
    z-index: -1;
}

@media (max-width:767px){
  .how-it-works .col-md-4 {
  padding: 1rem !important;
}
.circle-corner-image {
    position: absolute;
    left: -35%;
    top: -15%;
    transform: rotate(45deg);
}
.home--block--md-contant {
    position: relative;
    top: 0;
    left: 0;
    width: 250px;
    display: block;
    float: right;
}
.home-block-m-large {
    margin-top: 4.5rem;
    margin-bottom: 4.5rem;
}
.home--block--md-contant.right {
    right: 0;
}
footer{
  background-position:center;
  padding: 6rem 0 0rem 0;
}
.home-block-m-large img {
    width: 80%;
    margin-left: 10%;
}
.see-and-be-seen {
  margin: 4rem 0;
}
.how-it-works {
  margin-bottom: 3rem;
}
.how-it-works .number {
  font-size: 40px;
}
.how-it-works img{
  width:60px;
}
.how-it-works p {
  min-height: auto;
  font-size:14px;
  line-height:18px;
}

}
</style>


<span class="form-corner-circles"><img src="{{ asset('images/blossom_logo_backgound_use2.png') }}" alt="" class="img-fluid"/></span>
<div class="bg-home">
<div class="header">
  <div class="container-fluid">
    <div class="row align-items-center justify-content-between">
      <div class="col-md-6 after-login-heading-div">
        <h1 class="font-weight-300 large-h1 mt-4 mt-md-0">Explore reviews of companies, departments, managers, and more</h1>
        <div class="form-group mt-3 mt-md-5">
         <form name="serch_home" action="{{ url('/search/results')}}" method="get">
          @csrf 
          <div class="input-group">
            <input type="text" name="name" class="form-control Search border-right-0" 
            placeholder="Search for companies, managers, colleagues">
            <div class="input-group-prepend mr-0">
              <button type="submit" class="input-group-text form-icon border-left-0"><ion-icon name="search-outline"></ion-icon></button>
            </div>
          </div>
         </form> 
        </div>
      </div>
      <!-- <a href="#section2" class="arrow-collapse"><i class="fas fa-chevron-down arrow text-white"></i></a> -->

      @if(!Auth::check())
      <div class="col-lg-5 col-md-5 mb-3 mb-md-0">
        <div class="form-div shadow-sm">
          <h3>Sign up (<i>Anonymously!</i> ) <sup><i data-toggle="tooltip" data-html="true"  class="fas fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Protecting your anonymity is our highest priority. Our platform is most valuable when our community feels comfortable sharing honest assessments. <br/><br/>We recommend signing up with your full name so that we can let you know if anyone ever looks you up, creates a profile for you, or gives you a shout-out!"></i></sup></h3>
          <p class="text-muted mt-2 mb-3 font-14">Take the hoping and guessing out of your job search and career growth journey</p>
          <!-- <form class="signup-form" action="{{ url('find-existing-users') }}" method="post"> -->
          <form class="signup-form" action="{{ url('signup-user') }}" method="post">
             @csrf
            <div class="form-group">
              <input type="text" class="form-control sign-up" placeholder="First name" required name="name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control sign-up" placeholder="Last name" required name="last_name">
            </div>
            <div class="form-group emailgroup">
              <input type="email" class="form-control sign-up" placeholder="Email address" required name="email">
              @error('email')
                <label id="email-error" class="error-message" for="email">{{$message}}</label>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control sign-up" placeholder="Password" required name="password">
            </div>
            <div class="form-group text-center mt-3">
              <button id="signup-form-submit" type="submit" class="btn btn-success btn-rounded" name="">Sign me up</button>
            </div>
          </form>
          <div class="or--label"><span>Or Sign Up With</span></div>
          
          <div class="text-center form--multi--buttons-with-circle mb-4">
            <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i></a>
            <a href="{{ url('auth/google') }}"><i class="fab fa-google-plus-g"></i></a>
            <a href="{{ url('auth/linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
          </div>
            <p class="text-muted mb-0 font-14 text-center">By signing up, you agree to our <a href="{{ url('/terms-conditions') }}">Terms</a>,
            <a href="{{ url('/privacy-policy') }}">Data</a>, <a href="{{ url('/other-policies') }}">Policy</a> and <a href="{{ url('/cookie-policy') }}">Cookies Policy.</a></p>
          </div>

        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!--end banner-->
<!--media object start-->
<section id="section2" class="share-colleagues">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center py-4 py-md-5">
      <div class="col-md-5 text-center">
        <img src="{{ asset('images/user-share-rating.svg') }}" class="img-fluid" alt="avatar">
      </div>
      <div class="col-md-7 section-two ">
        <h2 class="font-weight-700 mt-md-5 share-colleagues-text text-gradient">Share with your friends and colleagues</h2>
        <h5 class="text-black font-weight-400 mb-4">We spend +33% of our lives at work, let’s make it more <span class="d-lg-block"> transparent, meaningful and enjoyable</span></h5>
        <!-- <a href="#" class="btn btn-success round-shape">Invite Now</a> -->
        <button class="btn btn-success round-shape" data-target="#request_invitation" data-toggle="modal">Invite now</button>
      </div>
    </div>
  </div>
</section>


<section class="see-and-be-seen">
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-md-6">
        <h3 class="font-weight-700 h2"><span class="text-gradient">See and be seen.</span></h3>
        <h5 class="font-weight-400">Companies and leaders that go the extra mile to create fantastic cultures and employee experiences deserve to be recognized, celebrated, and rewarded.</h5>
      </div>
      <div class="col-md-6 mt-5 mt-md-0">
        <h3 class="font-weight-700 h2"><span class="text-gradient">Hear and be heard.</span></h3>
        <h5 class="font-weight-400">Feedback should be open, transparent, and accessible to current and prospective employees at all levels. </h5>
      </div>
    </div>
  </div>
</section>


<section class="how-it-works">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 text-center">
            <h3 class="font-weight-700 h2 mb-3 mb-md-5"><span class="text-gradient">How it works</span></h3>
          </div>
            <div class="col-md-4 text-center">
            <img src="{{ asset('images/1.svg') }}" alt="" class="img-fluid"/>
              <div class="media align-items-center mt-3 mt-md-4">
                <div class="media-left mr-3"><span class="number">1</span></div>
                <div class="media-body">
                <p class="text-left text-black">We aggregate objective employee reviews based on our research-backed leadership and team performance assessment criteria.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-center">
              <img src="{{ asset('images/2.svg') }}" alt="" class="img-fluid"/>
              <div class="media align-items-center mt-3 mt-md-4">
                <div class="media-left mr-3"><span class="number">2</span></div>
                <div class="media-body">
                <p class="text-left text-black">We anonymize all reviewer details, combine with a bit of algorithm magic… and voila!</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-center">
              <img src="{{ asset('images/3.svg') }}" alt="" class="img-fluid"/>
              <div class="media align-items-center mt-3 mt-md-4">
                <div class="media-left mr-3"><span class="number">3</span></div>
                <div class="media-body">
                <p class="text-left text-black">We share reviews with our community, unlocking your ability to make informed career decisions from job-seeking to professional development.</p>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

<div class="bg-home py-3 py-md-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 text-center">
        <h3 class="font-weight-700 h1 text-gradient">Your new work life with Blossom.team</h3>
      </div>
    </div>
    <div class="row justify-content-end position-relative home-block-m-large">
      <div class="col-md-8 col-8 circle-corner-image"><img src="{{ asset('images/blossom_logo_backgound_full.png') }}" alt="" class="img-fluid"/></div>
      <div class="col-md-6">
        <span class="home--block--md-contant text-right">
          <h3 class="font-weight-700 h2"><span class="text-gradient">Browse profiles.</span></h3>
          <h4 class="font-weight-400">Explore companies, departments, and colleagues at all levels.</h4>
        </span>
        <img src="{{ asset('images/blossom_phone_introduction.svg') }}" alt="blossom_phone_introduction" class="img-fluid"/>
      </div>
    </div>
    <div class="row justify-content-between align-items-center home-block-m-large">
      <div class="col-md-6 order-2 order-md-1">
        <img src="{{ asset('images/blossom_phone_profile2_profile.svg') }}" alt="blossom_phone_introduction" class="img-fluid"/>
      </div>
      <div class="col-md-5 order-1 order-md-2">
          <h3 class="font-weight-700 h2"><span class="text-gradient">Explore reviews.</span></h3>
          <h4 class="font-weight-400">Submit and read reviews – anonymously. <br><br>
          Accelerate your professional <span class="d-lg-block">development – give and receive the gift of</span> feedback.<br><br>

          Blossom.team uses proprietary criteria to <span class="d-lg-block">cover universal aspects of effective</span> leadership.
            </h4>
      </div>
    </div>
    <div class="row justify-content-end home-block-m-large">
      <div class="col-md-12 text-center">
        <span class="home--block--md-contant right text-right">
          <h3 class="font-weight-700 h2"><span class="text-gradient">Stay in the loop.</span></h3>
          <h4 class="font-weight-400">Stay on top of every update, <span class="d-lg-block">for your own network and beyond.</span></h4>
        </span>
        <img src="{{ asset('images/blossom_all.svg') }}" alt="blossom_all" class="img-fluid"/>
      </div>
    </div>
  </div>
</div>



<!--card section end--> 
<div class="modal fade" id="request_invitation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div> -->

      <div class="modal-body p-3 p-md-4">
        <h4 class="mb-4">Invite your colleagues & friends!</h4>
        <form class="invite-form" name="Invitation_form" action="{{ url('/invite/invite_friends_email')}}" method="post">
          @csrf
          <div class="form-group">
            <label>First name</label>
            <input type="text" placeholder="Your friend's first name" class="form-control" name="_fname">
          </div>
          <div class="form-group">
            <label>Last name</label>            
            <input type="text" placeholder="Your friend's last name" class="form-control" name="_lname">
          </div>
          <div class="form-group">
            <label>Email address</label>
            <input type="email" placeholder="Your friend's email address" class="form-control" name="_email">
          </div>
          <div class="form-group mb-4">
            <label>LinkedIn profile <i>(Bonus!)</i></label>            
            <input type="url" placeholder="Your friend's LinkedIn profile url" class="form-control" name="_linkedin">
          </div>
          <!-- <div class="form-group">
            <label>Your Email</label>
            @if(Auth::check())
              <input type="email" placeholder="Email" value="{{Auth::user()->email}}" class="form-control" name="_login_user_email" readonly>
            @else
              <input type="email" placeholder="Email" class="form-control" name="_login_user_email">                
            @endif
            </div> --><hr>
          <div class="form-check mb-4">
            <label class="form-check-label mt-0">
              <input type="checkbox" class="form-check-input" name="mystery">Send as a mystery invitation (anonymous)
            </label>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-dark-blue btn-disabled">Send invite</button>
          </div>
        </form>
      </div>
      <div class="modal-body p-3 p-md-4 invite-sent text-center" style="display: none;">
        <span class="sent-image animate__animated animate__zoomIn"><img src="{{ url('/images/flash.png') }}"/></span>
        <span class="sent-image right animate__animated animate__zoomIn animate__delay-1s"><img src="{{ url('/images/flash.png') }}"/></span>
        <h2 class="mt-5 font-weight-bold">Invite sent!</h2>
        <div class="btn-gap"><span><img src="{{ url('/images/flash1.png') }}"/> <a href="#" class="btn btn-success btn-blue mx-2 invite_again">Invite another</a> <img src="{{ url('/images/flash1.png') }}"/></span></div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="find_existing_users">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-1 p-md-3">

      <div class="modal-header border-0 pb-0">
        <h4>Your name is a close match with a profile already in our system. Please select who you are from the below</h4>
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <p class="text-muted mb-3">Hint: your anonymity will always be protected. This is just so you can get notifications when someone leaves you a new review or visits your profile!</p>
        <?php $merchants = Session::get('isSocialMatch'); $users = Session::get('users');$login_from = Session::get('login_from');
          if($merchants){  ?>
            <div id="matched-users">@include('frontend.homepage.find_existing_social_users_list',["users" => $users,"login_from" => $login_from])</div>
          <?php }  else { ?>
            <div id="matched-users"></div>
          <?php } ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  jQuery('.signup-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            name:{
                required:true,
            },
            last_name:{
                required:true,
            },
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
                minlength:8
            },
           
          }  , 
          messages: {
            name: {required:"First name is required field. " },
            last_name: {required:"Last name is required field. " },
            password: {required:"Password is required field. " },
            email: {
              required: "Email is required field.",
              email: "Your email address must be in the format of name@domain.com"
            }
          }   
      });
  jQuery('.invite-form').validate({
     errorClass:"error-message",
     validClass:"green",
     rules:{
            _fname:{
                required:true,
            },
            _lname:{
                required:true,
            },
            _email:{
                required:true,
                email:true,
            },
            // _login_user_email:{
            //     required:true,
            //     email:true,
            // },
            // _linkedin:{
            //     required:true,
            // },
          },
           messages: {
            _fname: {required:"First name is required field. " },
            _lname: {required:"Last name is required field. " },
            // _linkedin: {required:"LinkedIn profile is required field. " },
            _email: {
              required: "Email is required field.",
              email: "Email address must be in the format of name@domain.com"
            },
            // _login_user_email: {
            //   required: "Email is required field.",
            //   email: "Email address must be in the format of name@domain.com"
            // }
        }      
  });


  jQuery("#signup-form-submit").click(function(e){
    e.preventDefault();
    var _form = jQuery(".signup-form");
    if(_form.valid()){
    jQuery.ajax({
            type: 'post',
            url: "{{ url('find-existing-users') }}",
            data: _form.serialize(),
            success: function (data) {
                if(data.success){
                  $("#matched-users").html(data.html);
                  jQuery('#find_existing_users').modal('show');
               }else if(data.error){
                jQuery(".emailgroup").append('<label id="email-error" class="error-message" for="email">The email has already been taken.</label>');
               }else if(data.empty){
                _form.submit();
               }
            }
          });
    }
        });


  jQuery(".invite-form").submit(function(e){
    e.preventDefault();
    var _this = jQuery(this);
    if(_this.valid()){
    jQuery.ajax({
            type: 'post',
            url: "{{ url('/invite/invite_friends_email') }}",
            data: _this.serialize(),
            success: function (data) {
                if(data.success){
                  $('#request_invitation .modal-body').hide();
                  $('.invite-sent').show();
               }else if(data.error){
                  console.log('error')
                	
               }
            }
          });
    }
        });
        $('.invite_again').click(function(){
  	 $('#request_invitation .modal-body').show();
  	 $('#request_invitation form')[0].reset();
     $('#request_invitation button').addClass('btn-disabled');
      $('.invite-sent').hide();
  })
  $('#request_invitation').find('input[name=_email]').on("keyup change", function(){
  	if($('#request_invitation').find('input[name=_email]').val() != ''){
  		$('#request_invitation button').removeClass('btn-disabled');
  	}else{
      $('#request_invitation button').addClass('btn-disabled');
  		// if(!$('#request_invitation button').hasClass('btn-disabled')){
	  	// 	$('#request_invitation button').removeClass('btn-disabled');
	  	// }
  	}
  })
</script>
<?php 
$merchants = Session::get('isSocialMatch');
if($merchants){ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      jQuery('#find_existing_users').modal('show');
    });
  </script> <?php 
} ?>
@endsection   





        