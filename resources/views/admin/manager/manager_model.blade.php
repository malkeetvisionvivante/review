@if(Auth::guard('admin')->user()->role == 1)
 <form class="update-model" action="{{ url('admin/update/manager/'.$data->id)}}" method="post" enctype="multipart/form-data">
@else
 <form class="update-model" action="{{ url('/company/update/manager/'.$data->id)}}" method="post" enctype="multipart/form-data">
@endif  
     @csrf
      <div class="row">
              <div class="col-md-6">
              <label>Profile</label><br>
              <input type="file" name="profile" class="form-control" id="manager_profile_pic_update" />
                  @error('profile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-6">
                <div class="pb-3" id="show_pic_update"><img src="{{ url('/images/users/'.$data->profile) }}" width="100"></div>    
              </div>
            </div> 
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" placeholder="First Name" class="form-control  @error('first_name') is-invalid @enderror" name="first_name" value="{{ $data->name}}">
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
          <input type="text" placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $data->last_name}}">
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
          <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" readonly value="{{ $data->email}}">
            @error('email')
              <span class="invalid-feedback" role="alert">
                 <strong>{{ $message}}</strong>
              </span>
            @enderror
        </div>
       </div>
        <div class="col-md-6">
        <div class="form-group">
          <label>Phone</label>
          <input type="text" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $data->phone}}">
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

              <option value="{{ $dep->id}}" @if($dep->id == $data->department_id) selected @endif>{{ $dep->name}}</option>
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
              <input type="text" placeholder="Job Title" class="form-control  @error('job_title') is-invalid @enderror" name="job_title" value="{{ $data->job_title}}">
               @error('job_title')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{str_replace('job_title', 'Job Title', $message)}}</strong>
                      </span>
              @enderror
          </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
             <option value="0" @if($data->status == 0) selected @endif>Active</option>
             <option value="1" @if($data->status == 1) selected @endif>Inactive</option>
          </select>
           @error('phone')
              <span class="invalid-feedback" role="alert">
                 <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>
      </div>
      </div>
    <button type="submit" class="btn btn-success round-shape">Save</button>
  </form>

  <script type="text/javascript">
    jQuery('.update-model').validate({
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
             job_title:{
                required:true,
            },
        }
    });
    jQuery('#manager_profile_pic_update').change(function(){
        readURL2(this);
    });
    function readURL2(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              jQuery('#show_pic_update').html('<img src="'+e.target.result+'" width="100">');
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
  </script>