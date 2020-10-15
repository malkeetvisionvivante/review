@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
<div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md-4">
            <h1>Email Templates</h1>
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
    <div class="row p-0 mb-4 font-weight-bold">
            <div class="col-md-3">Subject</div>
            <div class="col-md-3">From</div>
            <div class="col-md-3">To</div>
            <div class="col-md-3 text-right">Action</div>
        </div>       
     @if(count($emails))   
      @foreach($emails as $email)
      <div class="row p-0">
            <div class="col-md-3">{{$email->subject}}</div>
            <div class="col-md-3">{{$email->from}}</div>
            <div class="col-md-3">{{$email->to}}</div>
            <div class="col-md-3 text-right">
                <a href="{{ url('admin/email/edit/'.$email->id)}}" class="h6 text-blue"><i class="fas fa-pencil-alt"></i>  Edit</a>     
            </div>
        </div>
     
        <hr>
       @endforeach
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