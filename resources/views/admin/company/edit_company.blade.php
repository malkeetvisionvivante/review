@extends('admin.admin_layout.admin_app')
@section('content')
@if (session('error'))
    <?php toastr()->success(session('error')); ?>
@endif
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1 class="m-0">Edit Company</h1> 
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end left-align">
                        <li class="breadcrumb-item"><a href="{{ url('admin/company/list') }}" class="text-blue">Companies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-12">
                <ul class="nav nav-pills bg-light-blue p-2 rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#company_details">Company Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="department_tab" data-toggle="pill" href="#department_details">Departments</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#filter_tab">Departments</a>
                    </li> -->
                </ul>
            </div>
            <div class="col-md-12">
                <div class="tab-content">
                    <div id="company_details" class="tab-pane active"><br>
                        <h3>Basic Info</h3>
                       <form class="mainform" action="{{ url('admin/update/company/'.$data->id)}}" method="post" autocomplete="off" enctype="multipart/form-data">
                         @csrf
                            <div class="form-group">
                                <label>Company Logo</label><br>
                                <label for="custom-file-upload"><span class="browse-plus"><i class="fas fa-plus @error('logo') is-invalid @enderror"></i></span> Browse...</label>
                                @error('logo')
                                 <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                 </span>
                                @enderror
                                <input type="file" name="logo" class="d-none" id="custom-file-upload"/>
                                <div class="pb-3" id="cover_images_view">
                                  @if($data->logo)
                                  <img src="{{ url('/images/company/'.old('email',$data->logo ) ) }}" width="200">
                                  @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$data->company_name)}}">
                                         @error('name')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('name', 'Company Name', $message)}}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Industry</label>
                                        <select class="form-control @error('company_type') is-invalid @enderror" name="company_type">
                                            <option value="">Company Type</option>
                                            @if(isset($company_types))   
                                            @foreach($company_types as $company_type)
                                              <option value="{{ $company_type->id}}" @if($data->company_type == $company_type->id)  selected @endif>{{ $company_type->name}}</option>
                                            @endforeach
                                           @endif  
                                        </select>
                                        @error('company_type')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('company_type', 'Company Type', $message)}}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employee count</label>
                                        <input type="text" placeholder="Employee count" class="form-control  @error('no_of_employee') is-invalid @enderror" name="no_of_employee" value="{{ old('no_of_employee',$data->no_of_employee)}}">
                                          @error('no_of_employee')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('no_of_employee', 'No Of Employees', $message)}}</strong>
                                         </span>
                                         @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" placeholder="Street address" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ old('address',$data->address)}}">
                                         @error('address')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('address', 'Address', $message)}}</strong>
                                         </span>
                                         @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-none d-md-block">&nbsp;</label>
                                        <input type="text" placeholder="Enter City" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city',$data->city)}}">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="state_div">
                                        <select name="state" id="state_select" class=" form-control sign-up @error('state') is-invalid @enderror" id="state" >
                                          <option value="">Select state</option>   
                                           @foreach($states as $state)
                                              <option value="{{ $state->id}}" @php if($data->state_code == $state->id){ echo"selected";} @endphp>{{ $state->name}}</option>
                                           @endforeach                      
                                       </select>
                                      @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Postal Code" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode',$data->zipcode)}}">
                                    </div>
                                     @error('zipcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <select name="country" class=" form-control sign-up @error('country') is-invalid @enderror" id="country">
                                           <option value="">Select Country</option>   
                                             @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" @php if($data->country_code == $country->id){ echo"selected";} @endphp>{{ $country->name }}</option>                     
                                             @endforeach                    
                                        </select>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success round-shape">Save Changes</button>
                        </form>
                    </div>

                    
                    <div id="department_details" class="container tab-pane fade"><br> 
                       
                        <div class="row">
                            <div class="col-md-3 custom-d-block">
                                 <div class="add-department-tab" id="custom-add-dep-tab"><a href="#" data-toggle="modal" data-target="#add_department" class="text-dark"><i class="fas fa-plus text-muted-dark"></i> Add Department</a></div>
                            </div> 
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Select Departments</label>
                                    <select class="form-control" name="company_type" id="filter-department-select">
                                        <option value="">Select Departments</option>
                                        @if(count($departments_list) > 0 )   
                                            @foreach($departments_list as $dep)
                                              <option value="{{ $dep->id}}">{{ $dep->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 custom-d-none">
                                 <div class="add-department-tab" id="custom-add-dep-tab"><a href="#" data-toggle="modal" data-target="#add_department" class="text-dark"><i class="fas fa-plus text-muted-dark"></i> Add Department</a></div>
                            </div> 
                        </div>   
                        <div class="add-department-tab" id="filter-tab-managers">
                            <h4 class="mb-3">Managers</h4>
                            @if(count($managers)) 
                              @foreach($managers as $manager)
                              <div class="manager-widget-outer-div filter-manager-div manager-dep-id-{{ $manager->department_id }}">
                                  <div class="img-widget" style="background:url('{{ url('/images/users/'.$manager->profile) }}');background-size:cover;"></div>
                                  <a href="#" class="mb-1 edit_manager" data-id="{{ $manager->id}}" data-toggle="modal" data-target="#update_manager"><i class="fas fa-pencil-alt"></i> Edit</a>
                                  @if($manager->deleted == 'no')
                                   <a  href="{{ url('admin/delete/manager/'.$manager->id)}}" onclick="return confirm('Are You Sure delete Manager!')" style="margin-left: 2%;"  class="text-blue h6"><i class="fas fa-trash"></i></a>
                                  @else
                                    <a  href="{{ url('admin/recover/manager/'.$manager->id)}}" onclick="return confirm('Are You Sure recover Manager!')" style="margin-left: 2%;"  class="text-blue h6"><i class="fas fa-trash-restore"></i></a>
                                  @endif
                                  <p class="font-weight-500 mt-2">{{ $manager->name}} {{ $manager->last_name}}</p>
                              </div>
                            @endforeach   
                            @endif 
                          
                            <!-- <div id="manager-not-found">Not found any manager related to this Departmant</div> -->
                            <div class="manager-widget-outer-div">
                                <a href="#" data-toggle="modal" data-target="#add_manager"><div class="img-widget mb-custom"><i class="fas fa-plus text-muted-dark"></i></div></a>
                                <p class="font-weight-500 mt-2">Add Manager</p>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- add manager -->
<div class="modal fade" id="add_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Add Manager</h4>
        
        <form class="add_manager_popup" action="{{ url('admin/add/manager')}}" method="post" enctype="multipart/form-data">
           @csrf
            <div class="row">
              <div class="col-md-6">
              <label>Profile</label><br>
              <input type="file" name="profile" class="form-control" id="manager_profile_pic" />
                  @error('profile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-6">
                <div class="pb-3" id="show_pic"></div>    
              </div>
            </div> 
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" placeholder="First Name" class="form-control  @error('first_name') is-invalid @enderror" name="first_name">
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
                <input type="text" placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" name="last_name">
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
                <label>Email</label>
                <input type="email" id="add_manager_email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message}}</strong>
                    </span>
                  @enderror
                  <label id="already_email_error" class="text-danger" for="phone">Email already exist.</label>
              </div>
             </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>Phone</label>
                <input type="text" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror" name="phone">
                 @error('phone')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Assign Department</label>
                 <select name="department_id" class="form-control @error('department_id') is-invalid @enderror">
                   <option value="">Select Department</option>
                   @foreach($departments_list as $dep)
                    <option value="{{ $dep->id}}">{{ $dep->name}}</option>
                   @endforeach
                 </select>
                 @error('department_id')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Job Title</label>
                  <input type="text" placeholder="Job Title" class="form-control  @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title')}}">
                   @error('job_title')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{str_replace('job_title', 'Job Title', $message)}}</strong>
                          </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> Password</label>
                    <input type="password"  id="custom_confirm" placeholder="Password" class="form-control  @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}">
                     @error('password')
                             <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
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
     
           @if(isset($data))
            <input type="hidden" value="{{ $data->id}}" name="company_id">
           @endif 
          <button type="submit" class="btn btn-success round-shape">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_department">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Add Department</h4>
        <form class="add-departmanet-form" method="post" action="{{ url('admin/add/department')}}">
          @csrf
          <div class="form-group">
            <label>Department Name</label>
            <input type="text" placeholder="Department Name" class="form-control" name="name" required="">
          </div>
          <div class="form-group">
            <label>Department Description</label>
            <input type="text" placeholder="Description" class="form-control" name="description" required="">
          </div>
          <input type="hidden" name="company_id" value="{{ $data->id}}">
          <button type="submit" class="btn btn-success round-shape">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
 <div class="modal fade" id="update_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4" id="load_model">
        <h4>Update Manager</h4>
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script type="text/javascript">
    jQuery(document).on('change','#add_manager_email',function(){
      var self = this;
     jQuery.ajax({
          type:"post",
          url:" {{ url('/admin/check/manager/email') }}", 
          data: {
          "_token": "{{ csrf_token() }}",
          "email": jQuery(this).val(),
          },
          success:function(data) {       
             if(data){
              jQuery(self).attr('data',false);
             } else {
              jQuery(self).attr('data',true);
             }
          } 
      });
    });
    $(document).on('click','.edit_manager',function(){
      var id =  $(this).attr('data-id');
      var url = "{{ url('get_data_manager')}}/" + id;
       $('#load_model').load(url,function(){
        $('#update_manager').modal({show:true});
      });
    });
    $(document).ready(function(){ <?php
        if(Session::has('department_tab')) { ?>
          $('#department_tab').trigger('click'); 
          <?php
        }
      ?>
    });

    jQuery('#country').change(function(){
        var cid = jQuery(this).val();
        if(cid){
            jQuery("#state_select").prop('disabled', true);
            jQuery.ajax({
                type:"get",
                url:" {{ url('/get/state') }}/"+cid, 
                success:function(data) {       
                    jQuery("#state_select").html(data);
                     jQuery("#state_select").val('');  
                     jQuery("#state_select").prop('disabled', false);  
                }
            });
        }
    });

    jQuery('#manager_profile_pic').change(function(){
        readURL(this);
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              jQuery('#show_pic').html('<img src="'+e.target.result+'" width="80">');
          }
          reader.readAsDataURL(input.files[0]);
      }
    }

    jQuery('#custom-file-upload').change(function(){
        readURL1(this);
    });
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                jQuery('#cover_images_view').html('<img src="'+e.target.result+'" width="200">');
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
            name:{
                required:true,
            },
            company_type:{
                required:true,
            },
            no_of_employee:{
                required:true,
            },
            // address:{
            //     required:true,
            // }, 
            country:{
                required:true,
            },
            state:{
                required:true,
            },
            city:{
                required:true,
            },
            zipcode:{
                //required:true,
                number:true,
            }
          }      
      });
    jQuery('.add_manager_popup').submit(function(){
      jQuery('#already_email_error').hide();
      if(jQuery('#add_manager_email').val()){
        if(jQuery('#add_manager_email').attr('data') == 'false'){
          jQuery('#already_email_error').show();
          return false;
        } 
      }
    });
    jQuery('.add_manager_popup').validate({
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
            phone:{
                required:true,
                number:true,
            },
            department_id:{
                required:true,
            },
            profile:{
                required:true,
            },
            job_title:{
                required:true,
            },
            password:{
                required:true,
            },
            cpassword:{
                required:true,
                equalTo : "#custom_confirm"
            },
        }
    });
    jQuery('.add-departmanet-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            name:{
                required:true,
            },
            description:{
                required:true,
            }
        }
    });
    jQuery('#filter-department-select').change(function(){
        var value = jQuery(this).val();
        if(value != ''){
            jQuery('.filter-manager-div, #manager-not-found').hide();
            if(jQuery('.manager-dep-id-'+value).length > 0){
                jQuery('#manager-not-found').hide();
                jQuery('.manager-dep-id-'+value).show();
            } else {
                jQuery('#manager-not-found').show();
            }
            jQuery('#filter-tab-managers').show();
        } else {
            jQuery('#filter-tab-managers,#manager-not-found').hide();
        }
    });
  </script>
  <style type="text/css">
      #filter-tab-managers, #manager-not-found ,.custom-d-block, #already_email_error{ display: none; }
      .custom-d-none{display: block}
      div#custom-add-dep-tab { padding: 6px 25px !important; margin-top: 36px; }
       @media (max-width:767px) {
        .custom-d-block{display: block}
        .custom-d-none{display: none}
           div#custom-add-dep-tab { padding: 6px 25px !important; margin-top: 0px; }
        }
  </style>
@endsection