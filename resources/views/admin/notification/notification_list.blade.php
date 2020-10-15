@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
<div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md-7">
            <h1>Notifications</h1>
        </div>
        <div class="col-md-5">
          <form name="serch" id="sort_filter" action="{{ url('/admin/notifications/list')}}" method="get">
           @csrf 
            <div class="row p-0">
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <select name="type" class="form-control">
                        <option value="all" @if($statuValue == 'all') selected @endif>All</option>
                        <option value="open" @if($statuValue == 'open') selected @endif>Open</option>
                        <option value="escalated" @if($statuValue == 'escalated') selected @endif>Escalated</option>
                        <option value="resolved" @if($statuValue == 'resolved') selected @endif>Resolved</option>
                    </select> 
                </div>
            </div>
             <div class="col-md-6">
                <div class="input-group mb-1">
                    <select name="order_by" class="form-control">
                        <option value="ASC" @if($order_by == 'ASC') selected @endif>Oldest</option>
                        <option value="DESC" @if($order_by == 'DESC') selected @endif>Latest</option>
                    </select> 
                </div>
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
     @if(count($notifications))   
      @foreach($notifications as $notification)
      <div class="row p-0">
            <div class="col-md-6 order-1 order-md-1">
                <a href="{{ url('/admin/notifications/detail/'.$notification->id) }}">
                    <h3>{{ $notification->title() }}</h3>
                </a>
            </div>
            <div class="col-md-6 order-3 order-md-2 text-right">
                <div class="radio-group">
                    <div class="set">
                        <input type="radio" name="natification_{{ $notification->id}}" value="open" class="change_status" data-id="{{ $notification->id}}" id="status{{$notification->id}}open" @if($notification->status == 'open') checked @endif >
                        <label for="status{{$notification->id}}open">Open</label>
                    </div>  
                    <div class="set">
                        <input type="radio" name="natification_{{ $notification->id}}" value="escalated" class="change_status" data-id="{{ $notification->id}}" id="status{{$notification->id}}escalated" @if($notification->status == 'escalated') checked @endif >
                        <label for="status{{$notification->id}}escalated">Escalated</label>
                    </div>
                    <div class="set">
                        <input type="radio" name="natification_{{ $notification->id}}" value="resolved"  class="change_status" data-id="{{ $notification->id}}" id="status{{$notification->id}}resolved" @if($notification->status == 'resolved') checked @endif >
                        <label for="status{{$notification->id}}resolved">Resolved</label>
                    </div>
                </div>         
            </div>
        </div>
        <hr>
       @endforeach

        <div class="row mt-5">
            <div class="col-">
                {{ $notifications->links()}}
            </div>
            <div class="col- ml-4">
                <span class="text-muted" style="font-size: 14px;">
                    Showing {{count($notifications)}} of {{$notificationsCount}} Results
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
$(document).on('change','#sort_filter select',function(){
    $('#sort_filter').submit();
});
$(document).on('click','input.change_status',function(){
    if(confirm('Are You sure to change status')) {
        var id = $(this).attr('data-id');
        var value = $(this).val();
        $.ajax({
            url: "{{ url('admin/change_notification/status')}}",
            type: "post",
            data: {'id':id , status: value , "_token": "{{ csrf_token() }}"},
            success : function(data) { 
                toastr.success('Updated successfully!'); 
                setTimeout(function(){  location.reload(); }, 2000);
              
            }
        });
    }
});
</script>

<style>
.radio-group .set {
    display: inline-block;
    margin: 0px 5px;
}
</style>
@endsection