@extends('admin.admin_layout.admin_app')
@section('content')

<div class="inner-container">
  @if(Session::has('flash_message_success'))
    <div class="alert alert-success">
        {{Session::get('flash_message_success')}}
    </div>
@endif
  <div class="card my-3 border-bottom">
    <div class="row p-0">
        <div class="col-lg-7 col-md-5">
            <h1>Managers</h1>
        </div>
        <div class="col-lg-3 col-md-4 pr-md-0">
          <form name="serch_manager" action="{{ url('/company/managers/list')}}" method="get">
            @csrf  
            <div class="input-group mb-1">
                <input type="text" name="name" class="form-control border-right-0"
                    placeholder="Search Managers" value="{{ $name}}">
                <div class="input-group-prepend mr-0">
                    <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                </div>
            </div>
           </form> 
        </div>
        <div class="col-lg-2 col-md-3">
          <a href="#" data-toggle="modal" data-target="#add_manager" class="btn btn-success round-shape">Add Manager</a>
        </div>
    </div>
</div>

<div class="card mt-2">
  @if(count($data))  
   @foreach($data as $datas)
    
    <div class="row p-0">
        <div class="col-md-8">
            <div class="media">
                <div class="media-left">
                  @if(!empty($datas->profile))  
                    <div class="media-img-container">
                       <span><img src="{{ asset('images/manager/'.$datas->profile)}}" alt="apple" class="img-fluid" /></span>
                    </div>
                  @else
                    <div class="media-img-container">
                       <span><img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid" /></span>
                    </div>
                  @endif  
                </div>
                <div class="media-body">
                    <span ><h3>{{ $datas->first_name }} {{ $datas->last_name}}</h3></span>
                    <h6> {{ $datas->department($datas->department_id)}}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-right">
            <div class="mb-2">
            <div class="custom-control custom-switch custom-control-inline">
                <input type="checkbox" class="custom-control-input change_status" data-id="{{ $datas->id}}" id="status{{$datas->id}}" @if($datas->status == 0) checked @endif>
                <label class="custom-control-label"for="status{{$datas->id}}" >Visible</label>
            </div>
            
                <a href="#"  class="mb-1 edit_manager text-blue" data-id="{{ $datas->id}}" data-toggle="modal" data-target="#update_manager"><i class="fas fa-pencil-alt text-blue"></i> Edit</a>
                <a  href="{{ url('/company/delete/manager/'.$datas->id)}}" onclick="return confirm('Are You Sure delete Manager and its Reviews Permanently!')"  class="h6 text-blue ml-3"><i class="fas fa-trash"></i> Delete</a>
            </div>
               
            <h6 class="mb-1"><span class="thumb"><i class="fas fa-thumbs-up"></i></span> {{ round($datas->manager_review($datas->id),1)}} Manager</h6>
        </div>
    </div>
    <hr>
   @endforeach  
   <div class="row mt-5">
    <div class="col-md-12">
        <ul class="pagination align-items-center">
            {{ $data->links()}}
        </ul>
    </div>
</div>
 @else
   <p>No managers found!!</p>
 @endif   
   



</div>
</div>

<div class="modal fade" id="add_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Add Manager</h4>
        
        <form class="add_manager_popup" action="{{ url('/company/add/manager')}}" method="post" enctype="multipart/form-data">
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
                <input type="text" placeholder="First Name" class="form-control  @error('fname') is-invalid @enderror" name="fname">
                 @error('fname')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{str_replace('fname', 'First Name', $message)}}</strong>
                    </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" placeholder="Last Name" class="form-control @error('lname') is-invalid @enderror" name="lname">
                   @error('lname')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{str_replace('lname', 'Last Name', $message)}}</strong>
                    </span>
                  @enderror
              </div>
            </div>
          </div>
          <div class="row">
             <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email">
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
                 <select name="department" class="form-control @error('department') is-invalid @enderror">
                   <option value="">Select Department</option>
                   @foreach($departments_list as $dep)

                    <option value="{{ $dep->id}}">{{ $dep->name}}</option>
                   @endforeach
                   
                 </select>
                 @error('department')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
            </div>
            </div>
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
     $(document).on('click','.change_status',function(){
        if(confirm('Are You sure to change status'))
        {
           var id = $(this).attr('data-id');
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax(
            {
                // url: "{{url('search_filter/admin/quiz')}}",
                url: "{{ url('/company/change_status/manager')}}/"+id,
                type: "post",
                data: {'id':id},
                success : function(data) { 
                   location.reload();
                },
                error : function(data) {

                }
            });
        }
        return false;
        
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
    jQuery('.add_manager_popup').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            email:{
                required:true,
                email:true,
            },
            fname:{
                required:true,
            },
            lname:{
                required:true,
            },
            phone:{
                required:true,
                number:true,
            },
            department:{
                required:true,
            },
            profile:{
                required:true,
            },
        }
    });
    $(document).on('click','.edit_manager',function(){
      var id =  $(this).attr('data-id');
      var url = "{{ url('/company/get_data_manager')}}/" + id;
       $('#load_model').load(url,function(){
        $('#update_manager').modal({show:true});
      });
    });
 </script>

@endsection