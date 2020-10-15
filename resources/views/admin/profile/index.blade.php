@extends('admin.admin_layout.admin_app')
@section('content')
@if ($errors->any())
<?php toastr()->error('Something went wrong!!'); ?>
@endif
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1 class="m-0">User Profile</h1>
            </div>
            <div class="col-md-5 m-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" class="text-blue">Dashboard</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Add Company</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-12">
                <div class="card card-small">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="tab-pane active">
                    <!-- <h3 class="underline-heading font-weight-600">My Profile</h3> -->
                    <form class="update-profile" action="{{ url('admin/profile/update') }}" method="post" enctype="multipart/form-data">
                     @csrf  
                        <div class="form-group">
                            <label>Profile Picture</label><br>
                            <input type="file" class="d-none @error('profile') is-invalid @enderror" name="profile" id="custom-file-upload" accept="image/*"/>
                            <label for="custom-file-upload"><span class="browse-plus"><i class="fas fa-plus"></i></span> Browse...</label>
                             @error('profile')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                             </span>
                             @enderror
                            <div id="cover_images_view">
                                @if(!empty(Auth::guard('admin')->user()->profile))
                                  <img src="{{ asset('images/users/'.Auth::guard('admin')->user()->profile)}}" height="100" width="100">
                                @endif
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name',Auth::guard('admin')->user()->name)}}">
                                     @error('first_name')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('first_name', 'First Name', $message)}}</strong>
                                             </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" placeholder="Last Name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', Auth::guard('admin')->user()->last_name)}}">
                                     @error('last_name')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('last_name', 'Last Name', $message)}}</strong>
                                             </span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',Auth::guard('admin')->user()->email)}}">
                             @error('email')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                             </span>
                             @enderror
                        </div>
                        <div class="form-group mb-5">
                            <label>Phone</label>
                            <input type="tel" placeholder="Enter Phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',Auth::guard('admin')->user()->phone)}}">
                             @error('phone')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message}}</strong>
                                             </span>
                            @enderror
                        </div><hr>
                        <div class="form-group mt-4">
                            <h5>Change Password</h5>
                        </div>
                        <div class="row">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}">
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
                                    <input type="password" placeholder="" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" value="{{ old('cpassword')}}">
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

                <div id="menu1" class="tab-pane fade">
                 <h3 class="underline-heading font-weight-600">My Reviews
                     <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#review_details">Add my review</a>
                 </h3>
                 <div class="row">
                     <div class="col-md-12 mb-2">
                         <small class="text-muted">20 December, 2019</small>
                     </div>
                    <div class="col-md-7">
                        <div class="media">
                            <div class="media-left">
                                <div class="media-img-container small-img-container">
                                    <a href="company-details.php"><img src="images/apple-icon.png" alt="apple" class="img-fluid" /></a>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3>Apple Inc.</h3>
                                <h6 class="text-muted">Human Resource</h6>
                                <h6>Evalyn Bray</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-right">
                        <p class="m-0"><span class="thumb"><i class="fas fa-thumbs-up"></i></span> 5.0</p>
                        <a href="#" style="color:#276086;" class="small" data-toggle="modal" data-target="#review_details">Review previous evaluation</a>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <small class="text-muted">20 December, 2019</small>
                    </div>
                   <div class="col-md-7">
                       <div class="media">
                           <div class="media-left">
                               <div class="media-img-container small-img-container">
                                   <a href="company-details.php"><img src="images/airbnb-icon.png" alt="apple" class="img-fluid" /></a>
                               </div>
                           </div>
                           <div class="media-body">
                               <h3>Airbnb Inc.</h3>
                               <h6 class="text-muted">Human Resource</h6>
                               <h6>Richard Styles</h6>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-5 text-right">
                       <p class="m-0"><span class="thumb"><i class="fas fa-thumbs-up text-yellow"></i></span> 3.0</p>
                       <a href="#" style="color:#276086;" class="small" data-toggle="modal" data-target="#review_details">Review previous evaluation</a>
                   </div>
               </div>
                </div>
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
            first_name:{
                required:true,
            },
            last_name:{
                required:true,
            },
            email:{
                required:true,
                email:true,
            },
            phone:{
                //required:true,
                number: true,
                // maxlength:12,
                // minlength:10,
            },
           
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