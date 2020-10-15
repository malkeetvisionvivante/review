@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
<div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md-4">
            <h1>Users</h1>
        </div>
        <div class="col-md-8">
          <form name="serch" action="{{ url('/admin/profile/users/list')}}" method="get">
           @csrf 
            <div class="row p-0">
            <div class="col-md-3">
            <div class="input-group mb-1">
                <select name="type" class="form-control">
                    <option value="name" <?php if($type == "name") echo "selected"; ?>>By Name</option>
                    <option value="company" <?php if($type == "company") echo "selected"; ?> >By Company</option>
                </select> 
            </div>
            </div>
            <div class="col-md-9">
            <div class="input-group mb-1">
                <input type="text" name="name" value="{{ $name}}" class="form-control border-right-0"
                    placeholder="Search User">
                <div class="input-group-prepend mr-0">
                    <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                </div>
                <a href="{{ url('admin/add/users')}}" class="btn btn-success round-shape ml-4">Add User</a>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>
    @if(Session::has('flash_message_success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{!! session('flash_message_success') !!}</strong>
    </div>
    @endif 
    <div class="card">          
     @if(count($data))   
      @foreach($data as $datas)
      <div class="row p-0">
            <div class="col-md-8">
                <div class="media">
                    <div class="media-left">
                      @if(!empty($datas->profile))
                        <div class="media-img-container p-0">
                            <a href="{{ url('admin/users/detail/'.$datas->id)}}"><img src="{{ asset('images/users/'.$datas->profile)}}" alt="profile" class="img-fluid" /></a>
                        </div>
                         @else
                          <div class="media-img-container">
                             <a href="{{ url('admin/company/detail/'.$datas->id)}}"><img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid" /></a>
                          </div>
                        @endif 
                    </div>
                    <div class="media-body">
                        <a href="{{ url('admin/users/detail/'.$datas->id)}}">
                            <h3>{{ $datas->name}} {{ $datas->last_name}}</h3>
                        </a>
                        <h6 class="text-muted">Type: {{ $datas->type() }}</h6>
                        <!-- <h6 class="text-muted">{{ $datas->email}}</h6> -->
                        <!-- <h6>{{ $datas->phone}}</h6> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input change_status" data-id="{{ $datas->id}}" id="status{{$datas->id}}" @if($datas->status == 0) checked @endif>
                    <label class="custom-control-label" for="status{{$datas->id}}">Visible</label>
                </div>
                <a href="{{ url('admin/edit/users/'.$datas->id)}}" class="h6 text-blue"><i class="fas fa-pencil-alt"></i>  Edit</a>
                <a href="{{ url('admin/delete/user/'.$datas->id)}}" onclick="return confirm('Are You Sure delete user Permanently!')" class=" h6 text-blue ml-3"><i class="fas fa-trash"></i> Delete</a>
                
            </div>
        </div>
        <!-- <div class="row p-0">
            <div class="col-md-9">
                <div class="media">
                    <div class="media-left">
                        <div class="media-img-container p-0">
                            <a href="{{ url('admin/users/detail/'.$datas->id)}}"><img src="{{ asset('images/users/'.$datas->profile)}}" alt="profile" class="img-fluid" /></a>
                        </div>
                    </div>
                    <div class="media-body">
                        <a href="{{ url('admin/users/detail/'.$datas->id)}}">
                            <h3>{{ $datas->name}} {{ $datas->last_name}}</h3>
                        </a>
                         <label class="switch">
                            <input type="checkbox" data-id="{{ $datas->id}}" id="status{{$datas->id}}" class="change_status" @if($datas->status == 0) checked @endif>
                            <span class="slider round"></span>
                         </label>
                        <h6 class="text-muted">{{ $datas->email}}</h6>
                        <h6>{{ $datas->phone}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{ url('admin/delete/user/'.$datas->id)}}" onclick="return confirm('Are You Sure delete user Permanently!')" class="text-blue"><i class="fas fa-trash"></i></a>
                <a href="{{ url('admin/edit/users/'.$datas->id)}}" class="ml-2 text-blue"><i class="fas fa-user-edit"></i></a>
            </div>
        </div> -->
        <hr>
       @endforeach

        <div class="row mt-5">
            <div class="col-">
                {{ $data->links()}}
            </div>
            <div class="col- ml-4">
                <span class="text-muted" style="font-size: 14px;">
                    Showing {{count($data)}} of {{$countData}} Results
                </span>
            </div>
        </div>
     @else
        <span class="ml-3 small text-muted">No Result found!!</span>
     @endif   
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
                url: "{{ url('change_status/user/comp')}}/"+id,
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
</script>

@endsection