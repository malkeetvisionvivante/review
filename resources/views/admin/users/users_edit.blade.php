
@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1>Edit User</h1>
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/users/list')}}" class="text-blue">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        @if(Session::has('flash_message_success'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                    </div>
          @endif
          @if(Session::has('flash_message_error'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
          @endif
        <div class="row p-0">
            <div class="col-md-12">
                <form class="mainform" method="post" action="{{ url('admin/edit/users/'.$data->id)}}" enctype="multipart/form-data">
                 @csrf
                    <div class="form-group">
                        <label>Profile Picture</label><br>
                        <label for="custom-file-upload"><span class="browse-plus"><i class="fas fa-plus"></i></span>
                            Browse...</label>
                             @error('profile')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                            @enderror
                            <input type="file" name="profile" class="d-none  @error('profile') is-invalid @enderror" id="custom-file-upload" />
                            <div class="pb-4" id="show_pic">
                                @if($data->profile)
                                <img src="{{ url('/images/users/'.$data->profile) }}" width="100">
                                @endif
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" placeholder="First Name" class="form-control  @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name',$data->name)}}">
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
                                <input type="text" placeholder="Last Name" class="form-control  @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name',$data->last_name)}}">
                                 @error('last_name')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('last_name', 'Last Name', $message)}}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" placeholder="Email Address" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email',$data->email)}}" readonly>
                                 @error('email')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                 @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" placeholder="Phone" class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone',$data->phone)}}">
                                 @error('phone')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Company</label>
                                <select class="form-control" name="company_id" value="{{ old('company_id')}}">
                                    <option value=''>Select Company</option>
                                    @foreach($companys as $company)
                                        @if($company->id == $data->company_id)
                                        <option value="{{ $company->id }}" selected>{{ $company->company_name}}</option>
                                        @else 
                                        <option value="{{ $company->id }}" >{{ $company->company_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Department</label>
                                <select class="form-control" name="department_id" value="{{ old('department_id')}}">
                                    <option value=''>Select Department</option>
                                    @foreach($departments as $department)
                                         @if($department->id == $data->department_id)
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
                                <label>Job Title</label>
                                <input type="text" placeholder="Job Title" class="form-control  @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title',$data->job_title)}}">
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
                                <input type="url" placeholder="Linkedin Url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url',$data->linkedin_url)}}">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <h3>Password</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" placeholder="Old Password" class="form-control  @error('old_password') is-invalid @enderror" name="old_password" value="" autocomplete="off">
                                 @error('old_password')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" placeholder="New Password" class="form-control  @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}">
                                 @error('password')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" placeholder="Confirm Password" class="form-control  @error('cpassword') is-invalid @enderror" name="cpassword" value="{{ old('cpassword')}}">
                                 @error('cpassword')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('cpassword', 'Confirm Password', $message)}}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-success round-shape">Save</button>
                </form>
            </div>
        </div>


        <div class="row p-0">
            <div class="col-md-12">
                <hr>
                <form class="mainform1" id="banned-form" method="post" action="{{ url('admin/banned/users/'.$data->id)}}" enctype="multipart/form-data">
                 @csrf
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <h3>Banned</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Banned Status</label>
                                <select class="form-control" name="banned" value="{{ old('banned')}}">
                                    <option value='no' @if($data->banned == 'no') selected @endif>No</option>
                                    <option value='yes' @if($data->banned == 'yes') selected @endif>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" placeholder="Start Date" class="form-control" name="banned_from" readonly autocomplete="off" id="datepicker1" value="{{ date_format(date_create($data->banned_from),'yy-m-d') }}">
                                <span id="errorVisitorStartDate"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" placeholder="End Date" class="form-control" name="banned_to" readonly autocomplete="off" id="datepicker2" value="{{ date_format(date_create($data->banned_to),'yy-m-d') }}">
                                <span id="errorVisitorEndDate"></span>
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-success round-shape">Save</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
  <script type="text/javascript">
       jQuery('#custom-file-upload').change(function(){
            readURL(this);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#show_pic').html('<img src="'+e.target.result+'" width="100">');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        jQuery('.mainform').validate({
            ignore: [],
            errorClass:"error-message",
            validClass:"green",
            rules:{
                email:{
                    required:true,
                    email:true,
                },
                first_name:{
                    required:true,
                },
                last_name:{
                    required:true,
                }, 
                company_id:{
                    required:true,
                },
                phone:{
                    //required:true,
                    number:true,
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
              }      
          });
  </script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan", 
    function(value, element, params) {
        if (new Date($('#datepicker1').val()) > new Date($('#datepicker2').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#banned-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            banned_from:{
                required:true,
            },
            banned_to:{
                required:true,
                greaterThan: true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "banned_from") {
                error.appendTo("#errorVisitorStartDate");
            } else if (element.attr("name") == "banned_to") {
                error.appendTo("#errorVisitorEndDate");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>
@endsection