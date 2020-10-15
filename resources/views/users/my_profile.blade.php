@extends('frontend.layouts.apps')
@section('content')
<?php $inCompeteCount = 1; ?>
<div class="container-fluid">
    <div class="row">
        <!-- <div class="col-md-3">
            <div class="card card-small pl-0">
            <ul class="nav vertical-nav">
                <li class="nav-item">
                  <a class="nav-link active"  href="{{ url('/my-profile')}}">My Profile</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/my-reviews')}}">My Reviews</a>
                </li>
              </ul>
            </div>
        </div> -->

        <div class="col-md-12 mb-5 mt-4 mt-md-0">
            <div class="card card-small">
            <!-- Tab panes -->
              <div class="tab-content">
                <div id="home" class="tab-pane active setting-pane">
                  <div class="row">
                    <div class="col-lg-2 col-md-3">
                    <h3 class="underline-heading font-weight-600">Settings</h3>
                    </div>
                    <div class="col-lg-10 col-md-9">
                    @if(Auth::user()->inCompleteProfileCount() > 0)
                      <div class="alert alert-warning d-flex align-items-center" role="alert">
                      <span class="badge badge-danger rounded-circle mr-2">{{ Auth::user()->inCompleteProfileCount() }}</span> Complete your profile,&nbsp;<a href="javascript:void(0)" class="anonymous_popup">anonymously!</a>
                      </div>
                    @endif
                    </div>
                    </div>
                    <form class="update-profile" action="{{ url('user/update-my-profile')}}" method="post" enctype="multipart/form-data">
                     @csrf	
                      <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                              <label>Profile Picture</label><br>
                              <input type="file" class="d-none @error('profile') is-invalid @enderror" name="profile" id="custom-file-upload" accept="image/*"/>
                              <label for="custom-file-upload" class="text-nowrap"><span class="browse-plus"><i class="fas fa-plus"></i></span> Browse...</label>
                               @error('profile')
                                               <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                               </span>
                               @enderror
                              <div id="cover_images_view">
                              	@if(!empty(Auth::user()->profile))
                                    <img src="{{ asset('images/users/'.Auth::user()->profile)}}" height="100" width="100">
                              	@endif
                              </div>
                          </div>
                        </div>
                        <div class="col-7 text-right">
                              <span class="btn btn-success round-shape" data-toggle="modal" data-target="#anonymityModal">
                                Our Anonymity Pledge
                              </span>
                        </div>
                      </div>
                       
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>First Name</label>
                                  <input type="text" placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name',Auth::user()->name)}}">
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
                                  <input type="text" placeholder="Last Name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', Auth::user()->last_name)}}">
                                   @error('last_name')
                                           <span class="invalid-feedback" role="alert">
                                                  <strong>{{str_replace('last_name', 'Last Name', $message)}}</strong>
                                           </span>
                                      @enderror
                              </div>
                          </div>
                      
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',Auth::user()->email)}}">
                                 @error('email')
                                                 <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                 </span>
                                 @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="tel" placeholder="Enter Phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',Auth::user()->phone)}}">
                                 @error('phone')
                                     <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message}}</strong>
                                     </span>
                                @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>
                                    @if(!Auth::user()->company_id)  <i class="fas fa-exclamation-circle text-danger"></i> @endif
                                    Company
                                  </label>
                                  @if(Auth::user()->company_id)
                                  <input type="text" placeholder="Search Company" list="company_list" class="form-control" name="company_id" id="search_company_list" autocomplete="off" value="{{ $companyName }}" >
                                  @else
                                  <input type="text" placeholder="Search Company" list="company_list" class="form-control" name="company_id" id="search_company_list" autocomplete="off" value="" >
                                  @endif                               
                              </div>
                              <datalist id="company_list"></datalist>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="d-flex align-items-center">
                                    @if(!Auth::user()->department_id) <i class="fas fa-exclamation-circle text-danger mr-2"></i> @endif
                                    Select Department
                                  </label>
                                  <select class="form-control" name="department_id" value="{{ old('department_id')}}">
                                      <option value=''>Select Department</option>
                                      @foreach($departments as $department)
                                          @if(Auth::user()->department_id == $department->id)
                                          <option value="{{ $department->id }}" selected>{{ $department->name}}</option>
                                          @else
                                          <option value="{{ $department->id }}" >{{ $department->name}}</option>
                                          @endif
                                      @endforeach
                                  </select>
                                  
                              </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-flex align-items-center">
                                      @if(!Auth::user()->job_title) <i class="fas fa-exclamation-circle text-danger mr-2"></i> @endif
                                      Job Title
                                    </label>
                                    <!-- <input type="text" placeholder="Job Title" class="form-control  @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title',Auth::user()->job_title)}}"> -->
                                    <input list="title_list" placeholder="Job Title" class="form-control  @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title',Auth::user()->job_title)}}" id="search_title" autocomplete="off">
                                      <datalist id="title_list">
                                      </datalist>

                                    @error('job_title')
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{str_replace('job_title', 'Job Title', $message)}}</strong>
                                            </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Linkedin Profile</label>
                                <input type="url" placeholder="Linkedin Url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url',Auth::user()->linkedin_url)}}">
                              </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success round-shape">Update</button>
                      </form>
                    </div>
                  </div>
              <div class="tab-content mt-4">
                <div id="home" class="tab-pane active">
                    <h3 class="underline-heading font-weight-600">Change Password</h3>
                    <form class="update-profile1" action="{{ url('user/update-password')}}" method="post" enctype="multipart/form-data">
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
<div id="anonymityModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Protecting your anonymity is our priority. Our platform is most valuable when our community feels comfortable sharing honest assessments.</p>

        <p>For you to derive the most value from Blossom, we recommend completing your profile details. That way we can let you know if anyone ever looks you up, creates a profile for you, or gives you a shout-out!</p>

        <p>And don’t worry - we’ll never make your profile publicly searchable until the reviews you leave are totally unidentifiable and untraceable. (Pro-tip: you can also help with that by <a href="javascript:void(0)" id="show_add_manager_popup">adding more of your peers and company managers to the site!</a>)</p>
      </div>
      
    </div>

  </div>
</div>
@include('users.add_manager_popup')
<script type="text/javascript">
//   $('#search_title').keypress(function(){
//     $.ajax({
//         url: "{{ url('/load-titles') }}",
//         type: "post",
//         data: { data: jQuery(this).val() , "_token": "{{ csrf_token() }}"},
//         success : function(data) { 
//             $('#title_list option').remove();
//             $('#title_list').prepend(data); 
//         },
//         error : function(data) {}
//       });
//   });
  
  $('.anonymous_popup').mouseover(function(){
      $('#anonymityModal').modal('show');
  });
  $('#show_add_manager_popup').click(function(){
      $('#anonymityModal').modal('hide');
      $('#request_new_manager').modal('show');
  });
  $('#search_company_list').keyup(function(){
      $.ajax({
          url: "{{ url('/load-company-list') }}",
          type: "post",
          data: { data: jQuery(this).val() , "_token": "{{ csrf_token() }}"},
          success : function(data) { 
              $('#company_list option').remove();
              $('#company_list').prepend(data); 
          },
          error : function(data) {}
        });
    });
    $('#company_list option').click(function(){
      $(this).next().focus();
    });

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
                maxlength:12,
                minlength:10,
            },
            company_id:{
                required:true,
            },
            department_id:{
                required:true,
            },
            job_title:{
                required:true,
            },
          },
           messages: {
            first_name: {required:"First Name is required field. " },
            last_name: {required:"Last Name is required field. " },
            phone: {required:"Phone Number is required field. " },
            company_id: {required:"Company is required field. " },
            department_id: {required:"Department is required field. " },
            job_title: {required:"Job Title is required field. " },
            email: {
              required: "Email is required field.",
              email: "Your email address must be in the format of name@domain.com"
            }
        }     

      });
    jQuery('.update-profile1').validate({
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