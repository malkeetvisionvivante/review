@extends('admin.admin_layout.admin_app')
@section('content')

<div class="inner-container">
            <div class="card card-small">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="tab-pane active">
                    <h3 class="underline-heading font-weight-600">Basic Info</h3>
                   <form class="mainform" action="{{ url('/my/data/update/company')}}" method="post" autocomplete="off" enctype="multipart/form-data">
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
                                <div class="pb-3" id="cover_images_view"><img src="{{ url('/images/company/'.old('email',$data->profile ) ) }}" width="200"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type of Industry</label>
                                        <select class="form-control @error('company_type') is-invalid @enderror" name="company_type">
                                            <option value="">Company Type</option>
                                            <option value="Industrial" @php if($data->company['company_type'] == 'Industrial'){ echo"selected";} @endphp>Industrial</option>
                                            <option value="IT" @php if($data->company['company_type'] == 'IT'){ echo"selected";} @endphp>IT</option>
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
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$data->name)}}">
                                         @error('name')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('name', 'Company Name', $message)}}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. of Employee</label>
                                        <select class="form-control  @error('no_of_employee') is-invalid @enderror" name="no_of_employee">
                                            <option value="">Select</option>
                                            <option @php if($data->company['no_of_employee'] == 100){ echo"selected";} @endphp value="100">100</option>
                                            <option @php if($data->company['no_of_employee'] == 200){ echo"selected";} @endphp value="200">200</option>
                                            <option @php if($data->company['no_of_employee'] == 300){ echo"selected";} @endphp value="300">300</option>
                                            <option @php if($data->company['no_of_employee'] == 400){ echo"selected";} @endphp value="400">400</option>
                                            <option @php if($data->company['no_of_employee'] == 500){ echo"selected";} @endphp value="500">500</option>
                                            <option @php if($data->company['no_of_employee'] == 600){ echo"selected";} @endphp value="600">600</option>
                                            <option @php if($data->company['no_of_employee'] == 800){ echo"selected";} @endphp value="800">800</option>
                                            <option @php if($data->company['no_of_employee'] == 1000){ echo"selected";} @endphp value="1000">1000</option>
                                        </select>
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
                                        <input type="text" placeholder="Street address" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ old('address',$data->company['address'])}}">
                                         @error('address')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{str_replace('address', 'Address', $message)}}</strong>
                                         </span>
                                         @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <select name="country" class=" form-control sign-up @error('country') is-invalid @enderror" id="country">
                                           <option value="">Select Country</option>   
                                             @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" @php if($data->company['country_code'] == $country->id){ echo"selected";} @endphp>{{ $country->name }}</option>                     
                                             @endforeach                    
                                        </select>
                                    @error('country')
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
                                              <option value="{{ $state->id}}" @php if($data->company['state_code'] == $state->id){ echo"selected";} @endphp>{{ $state->name}}</option>
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
                                        <input type="text" placeholder="Enter City" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city',$data->company['city'])}}">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Postal Code" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode',$data->company['zipcode'])}}">
                                    </div>
                                     @error('zipcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <h3>Account Info</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$data->email)}}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                       @enderror
                                    </div>
                                </div>
                            </div><hr>

                            <div class="row">
                               <div class="row">
                                <div class="col-md-12 mt-3">
                                    <h3>Change Password</h3>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" placeholder="Old Password" value="{{ old('old_password')}}" class="form-control" name="old_password">
                                        @error('old_password')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('old_password', 'Old Password', $message)}}</strong>
                                             </span>
                                        @enderror
                                    </div>
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
                                        <input type="password" placeholder="Confirm Password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" value="{{ old('cpassword')}}">
                                        @error('cpassword')
                                             <span class="invalid-feedback" role="alert">
                                                    <strong>{{str_replace('cpassword', 'Confirm Password', $message)}}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                              
                            </div>
                            <button type="submit" class="btn btn-success round-shape">Save Changes</button>
                        </form>
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
            address:{
                required:true,
            }, 
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
                required:true,
                number:true,
            }
          }      
      });
 </script>

@endsection    	