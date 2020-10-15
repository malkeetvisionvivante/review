@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1>Notification Detail</h1>
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/notifications/list') }} " class="text-blue">Notifications</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notification Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="row p-0">
                <div class="col-md-6">
                    <h3>{{ $notification->title() }}</h3>
                </div>
                <div class="col-md-6">
                    <div class="radio-group">
                         <div class="set">
                            <h3>Status: </h3>
                        </div>
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
            <div class="row p-0">
                <div class="col-md-12">
                    <!---------------------------->
                    @if($notification->type == 'commentReportLimit')
                    <h3><a target="_blank" href="{{ url('/manager-detail/'.$notification->reviewUserId()) }}">Open Review</a></h3>
                    <h3>Report On</h3>
                    <p>Manager Name: {{ $notification->reportOnUserName() }} </p>
                    <p>Manager Email: {{ $notification->reportOnUserEmail() }} </p>
                    <p>Comment: {{ $notification->reviewComment() }}</p>
                    <hr>

                    <h3>Reported by</h3>
                    @foreach($notification->reportBy() as $report)
                        <p>Name: {{ $report->customer_name() }}</p>
                        <p>Email: {{ $report->customer_Email() }}</p>
                        <p>Report Time: {{ $report->created_at }}</p>
                        @if(!$loop->last)
                        <hr>
                        @endif
                    @endforeach

                    <!---------------------------->
                    @elseif($notification->type == 'reviewsByRevieweeLimit')
                    <h3>Review To</h3>
                    <p>Name: <a target="_blank" href="{{ url('/manager-detail/'.$notification->review_to) }}">{{ $notification->reviewUserName() }}</a></p>
                    <p>Email: {{ $notification->reviewUserEmail() }}</p>
                    <hr>
                    
                    <h3>Review by</h3>
                    <p>Name:  <a target="_blank" href="{{ url('/manager-detail/'.$notification->review_by) }}">{{ $notification->reviewCustomerName() }}</a></p>
                    <p>Email: {{ $notification->reviewCustomerEmail() }}</p>

                    <!---------------------------->
                    @elseif($notification->type == 'newCompanyAdded')    
                    <h3>Added By</h3>
                    <p>Name: {{ $notification->companyUserName() }}</p>
                    <p>Email: {{ $notification->companyUserEmail() }}</p>
                    <hr>
                    
                    <h3>Company Info</h3>
                    <p>Name: <a href="{{ url('admin/company/detail/'.$notification->company_id) }}" target="_blank">{{ $notification->companyName() }}</p>

                    <!---------------------------->
                    @elseif($notification->type == 'newCompanyAddedThroughFooter')    
                    <h3>Added By</h3>
                    <p>User Type: {{ $notification->newCompanyAddedThroughFooterType() }}</p>
                    @if($notification->user_id)
                    <p>Name: {{ $notification->newCompanyAddedThroughFooterUserName() }}</p>
                    <p>Email: {{ $notification->newCompanyAddedThroughFooterUserEmail() }}</p>
                    @endif
                    <hr>
                    
                    <h3>Company Info</h3>
                    <p>Name: {{ $notification->company_name }}</p>

                    <!---------------------------->
                    @elseif($notification->type == 'userCompanyChange')    
                    <h3>Change By</h3>
                    <p>Name: <a target="_blank" href="{{ url('/manager-detail/'.$notification->user_id) }}">{{ $notification->changeCompanyUserName() }}</a></p>
                    <p>Email: {{ $notification->changeCompanyUserEmail() }}</p>
                    <hr>
                    
                    <h3>Company List</h3>
                    @foreach($notification->changeCompanyList() as $company)
                    <p>From: {{ $company->from }}</p>
                    <p>To: {{ $company->to }}</p>
                    <p>Change At: {{ $company->created_at }}</p>
                    <hr>
                    @endforeach 

                    <!---------------------------->
                    @elseif($notification->type == 'spamBehavior')    
                    <h3>User Info</h3>
                    <p>Name: {{ $notification->spamUserName() }}</p>
                    <p>Email: {{ $notification->spamUserEmail() }}</p>
                    <hr>
                    
                    <h3>Profile List</h3>
                    @foreach($notification->spamProfileList() as $user)
                    <p>Name: {{ $user->profileName() }}</p>
                    <p>Email: {{ $user->profileEmail() }}</p>
                    <hr>
                    @endforeach

                    <!---------------------------->
                    @elseif($notification->type == 'lowScore')    
                    <h3><a target="_blank" href="{{ url('/manager-detail/'.$notification->lowScoreUserId()) }}">Open Review</a></h3>
                    <h3>Review By</h3>
                    <p>Name: {{ $notification->lowScoreCustomerName() }}</p>
                    <p>Email: {{ $notification->lowScoreCustomerEmail() }}</p>
                    <hr>
                    
                    <h3>Review To</h3>
                    <p>Name: {{ $notification->lowScoreUserName() }}</p>
                    <p>Email: {{ $notification->lowScoreUserEmail() }}</p>
                    <hr> 

                    <!---------------------------->
                    @elseif($notification->type == 'similarNamesMatch')    
                    <h3>Review By</h3>
                    <p>Name: {{ $notification->lowScoreCustomerName() }}</p>
                    <p>Email: {{ $notification->lowScoreCustomerEmail() }}</p>
                    <hr>
                    
                    <h3>Review To</h3>
                    <p>Name: {{ $notification->lowScoreUserName() }}</p>
                    <p>Email: {{ $notification->lowScoreUserEmail() }}</p>
                    <hr>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).on('click','.change_status',function(){
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