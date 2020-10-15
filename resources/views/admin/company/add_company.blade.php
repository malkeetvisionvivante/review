@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1 class="m-0">Add Company</h1>
            </div>
            <div class="col-md-5 m-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/company/list') }}" class="text-blue">Companies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Company</li>
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
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#department_details">Departments</a>
                    </li> -->
                </ul>
            </div>
            <div class="col-md-12">
                <div class="tab-content">
                    <div id="company_details" class="tab-pane active"><br>
                        <h3>Basic Info</h3>
                       <form class="mainform" action="{{ url('admin/add/company')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                         @csrf
                            <div class="form-group">
                                <label>Company Logo</label><br>
                                <label for="custom-file-upload"><span class="browse-plus"><i class="fas fa-plus @error('logo') is-invalid @enderror"></i></span> Browse...</label>
                                 @error('logo')
                                 <p style="color: red;">logo file is Missing!!</p>
                                 <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                 </span>
                                @enderror
                                <input type="file" name="logo" class="d-none" id="custom-file-upload"/>
                                <div class="pb-3" id="cover_images_view"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
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
                                              <option value="{{ $company_type->id}}" @if(old('company_type') == $company_type->id)  selected @endif>{{ $company_type->name}}</option>
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
                                        <input type="text" placeholder="Employee count" class="form-control  @error('no_of_employee') is-invalid @enderror" name="no_of_employee" value="{{ old('no_of_employee')}}">
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
                                        <input type="text" placeholder="Street address" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ old('address')}}">
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
                                        <input type="text" placeholder="Enter City" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city')}}">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="state_div">
                                        <select id="state_select" name="state" class=" form-control sign-up @error('state') is-invalid @enderror" id="state" disabled>
                                          <option value="">Select state</option>   
                                                                    
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
                                        <input type="text" placeholder="Postal Code" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode')}}">
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
                                                    <option value="{{ old('country',$country->id) }}" >{{ $country->name }}</option>                     
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
                            <!-- <div class="row">
                                <div class="col-md-12 mt-3">
                                    <h3>Account Info</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                    </div>
                                </div>
                            </div>-->
                            <hr> 

                             <!-- <div class="row">
                                <div class="col-md-12 mt-3">
                                    <h3> Password</h3>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> Password </label>
                                        <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                 <strong>{{  $message}}</strong>
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
                            </div> -->
                            <button type="submit" class="btn btn-success round-shape">Save</button>
                        </form>
                    </div>

                    <div id="department_details" class="container tab-pane fade"><br>
                        <div class="add-department-tab">
                            <h4 class="mb-3">Finance <a href="#" class="text-blue small float-right"><i class="fas fa-trash"></i></a></h4>
                            <div class="manager-widget-outer-div">
                                <div class="img-widget" style="background:url('../images/5th.jpg');background-size:cover;"></div>
                                <p class="font-weight-500 mt-2">Richard Styles</p>
                            </div>
                            <div class="manager-widget-outer-div">
                                <a href="#" data-toggle="modal" data-target="#add_manager"><div class="img-widget"><i class="fas fa-plus text-muted-dark"></i></div></a>
                                <p class="font-weight-500 mt-2">Add Manager</p>
                            </div>
                        </div>

                        <div class="add-department-tab"><a href="#" data-toggle="modal" data-target="#add_department" class="text-dark"><i class="fas fa-plus text-muted-dark"></i> Add Department</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


 
@endsection
@section('scripts')
  <script type="text/javascript">
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

    jQuery('#custom-file-upload').change(function(){
        readURL(this);
    });
    function readURL(input) {
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
            // email:{
            //     required:true,
            //     email:true,
            // },
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
            },
            // password:{
            //     required:true,
            // },
            // cpassword:{
            //     required:true,
            // },
            // logo:{
            //     required:true,
            // },
          }      
      });


  </script>
@endsection