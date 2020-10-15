@extends('frontend.layouts.apps')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-small pl-0">
            <ul class="nav vertical-nav">
                <li class="nav-item">
                  <a class="nav-link"  href="{{ url('/my-profile')}}">My Profile</a>
                </li>
               <!--  <li class="nav-item">
                  <a class="nav-link"  href="{{ url('/referal-detail')}}">Referal Detail</a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/my-reviews')}}">My Reviews</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="{{ url('/change-password')}}">Change Password</a>
                </li>
              </ul>
            </div>
        </div>

        <div class="col-md-9 mb-5 mt-4 mt-md-0">
            <div class="card card-small">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="tab-pane active">
                    <h3 class="underline-heading font-weight-600">Change Password</h3>
                    <form class="update-profile" action="{{ url('user/update-password')}}" method="post" enctype="multipart/form-data">
                     @csrf	
                        
                        
                        <div class="row">
                            @if(Auth::user()->password)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" placeholder="Old Password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="{{ old('old_password')}}">
                                     @error('old_password')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('old_password', 'Old Password', $message)}}</strong>
                                             </span>
                                        @enderror
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input id="password" type="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}">
                                     @error('password')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message}}</strong>
                                             </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" placeholder="Confirm Password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" value="{{ old('cpassword')}}">
                                     @error('cpassword')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('cpassword', 'Confirm Password', $message)}}</strong>
                                             </span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success round-shape">Update</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
  jQuery('.update-profile').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            @if(Auth::user()->password)
            old_password:{
                required:true,

            },
            @endif
            password:{
                required:true,
                minlength : 8
            },
            cpassword:{
                required:true,
                minlength : 8,
                equalTo : "#password"
            },
          },
          messages: {
            old_password: {required:"Old Password is required field. " },
            password: {required:"Password is required field. " },
            cpassword: {required:"Confirm Password is required field. " },
            }   
      });
  jQuery('#custom-file-upload').change(function(){
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                jQuery('#cover_images_view').html('<img src="'+e.target.result+'" width="100">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection