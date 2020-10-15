@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-7 mt-2">
            <a href="{{ url()->previous() }}" class="mb-3 d-block"><i class="fas fa-chevron-left"></i> Back</a>
            <div class="card shadow-sm">
            	<form class="mainform" action="{{ url('login-user') }}" method="post">
            		 @csrf
	                <a href="{{ url('/') }}"><img src="images/blossom_logo_primary.svg" class="img-fluid logo mb-2" alt="blossom_logo"></a>
	                <h5 class="mb-3">User Login</h5>
	                <div class="form-group">
	                    <input type="text" class="form-control" placeholder="Enter Email" name="email"/>
	                </div>
	                <div class="form-group">
	                    <input type="password" class="form-control" placeholder="Password" name="password"/>
	                </div>
	                <div class="form-group row mx-0">
	                    <div class="custom-control custom-checkbox col-7">
	                        <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
	                        <label class="custom-control-label text-muted" for="customCheck">Remember me</label>
	                      </div>
	                      <div class="col-5 pr-0 text-right pl-0 custom-m-t">
	                          <a href="{{ url('/password/reset') }}" class="text-muted">Forgot Password?</a>
	                      </div>
	                </div>
	                <div><button type="submit" class="btn btn-success round-shape">Login</button></div>
                </form>
                <div class="or--label"><span>Or Login with</span></div>
                <div class="text-center form--multi--buttons-with-circle">
                    <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ url('auth/google') }}"><i class="fab fa-google-plus-g"></i></a>
                    <a href="{{ url('auth/linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="text-center mt-4 mb-5">
                <div><a href="{{ url('/home') }}" class="btn btn-success round-shape">Not a user yet? Click here to sign up! </a></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	jQuery('.mainform').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
            },
           
          },
          messages: {
            password: {required:"Password is required field. " },
            email: {
              required: "Email is required field.",
              email: "Your email address must be in the format of name@domain.com"
            }
          }   
      });

</script>
@endsection        