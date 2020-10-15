@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1>Profile Details</h1>
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/profile/users/list') }}" class="text-blue">Profiles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-9">
                <div class="media">
                    <div class="media-left">
                        <div class="media-img-container p-0">
                          @if(!empty($data1->profile))  
                            <a href="{{ url('admin/users/detail/'.$data1->id)}}"><img src="{{ asset('images/users/'.$data1->profile)}}" alt="profile" class="img-fluid" /></a>
                          @else
                          <a href="{{ url('admin/users/detail/'.$data1->id)}}"><img src="{{ asset('images/default/user.png')}}" alt="profile" class="img-fluid" /></a>
                          @endif  
                        </div>
                    </div>
                    <div class="media-body">
                        <a href="{{ url('admin/users/detail/'.$data1->id)}}">
                            <h3>{{ $data1->name}} {{ $data1->last_name}}</h3>
                        </a>
                        <h6 class="text-muted">{{ $data1->email}}</h6>
                        <h6>{{ $data1->phone}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <a  href="{{ url('admin/delete/user/'.$data1->id)}}" onclick="return confirm('Are You Sure delete user Permanently!')"  class="text-blue"><i class="fas fa-trash"></i></a>
                <a href="{{ url('admin/profile/edit/users/'.$data1->id)}}" class="ml-2 text-blue"><i class="fas fa-user-edit"></i></a>
            </div>
        </div>
        <hr>
        <div class="row p-0">
            <div class="col-md-10 mb-3">
                <h3>Review History</h3>
            </div>
            <div class="col-md-2 p-0">
                <div class="form-group justify-content-end">
                    <select class="custom-select" id="review_filter" data-id="{{$data1->id}}" name="as">
                        <option value="customer_id" <?php if($type == "customer_id") echo "selected"; ?> >As Reviewer</option>
                        <option value="user_id" <?php if($type == "user_id") echo "selected"; ?>>As Reviewee</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-justified reviews--custom--tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                        aria-controls="all" aria-selected="true"><i class="fas fa-user-circle"></i> <span class="d-none d-md-inline-block">Manager</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="orgnaization-tab" data-toggle="tab" href="#orgnaization" role="tab"
                        aria-controls="orgnaization" aria-selected="false"><i class="fas fa-building"></i> <span class="d-none d-md-inline-block">Peer</span></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    @include('admin.profile_user.review_history_manager') 
                </div>
                <div class="tab-pane fade" id="orgnaization" role="tabpanel" aria-labelledby="orgnaization-tab">
                    @include('admin.profile_user.review_history_peer') 
                </div>
              
           
            </div>
        </div>
    </div>
       
    </div>
</div>
<style type="text/css">
   
</style>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.show-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).show();
            jQuery('.hide'+id).show();
            jQuery('.show'+id).hide();
        });
        jQuery('.hide-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).hide();
            jQuery('.hide'+id).hide();
            jQuery('.show'+id).show();
        });
    });

    jQuery("#review_filter").change(function(e){
        var _this = $(this);
        var selected = $("#review_filter option:selected").val();
        window.location = "{{ url('admin/profile/users/detail') }}/" + _this.attr("data-id") + "/" + selected;
    })

    jQuery(".key-trash").click(function(e){
        var _this = $(this)
        var role = _this.attr('role');
        var id = _this.attr('data-id');
        var result = confirm("Do you want to delete the "+role+" ?");
        if (result) {
            jQuery.ajax({
            type: 'post',
            url: "{{ url('admin/profile/users/remove-profile-single-review') }}",
            data: { id, role ,"_token": "{!! csrf_token() !!}" },
            success: function (res) {
                if(res.success){
                    _this.remove();
                    if(role == "comment"){
                        $("#_comment_"+id+"_").remove();
                    }else{
                        $("#_panel_"+id).remove();
                        $("#_hr_"+id).remove();
                    }
                        toastr.success(res.success);
                }else{
                    toastr.error(res.error);
                }
            }
          });
        }
    })
    jQuery(".hide-comment").click(function(e){
        var _this = $(this)
        if(_this.hasClass("_reviewHidden"))
            return
        var id = _this.attr('data-id');
            jQuery.ajax({
            type: 'post',
            url: "{{ url('admin/profile/users/hide-review-comment') }}",
            data: { id ,"_token": "{!! csrf_token() !!}" },
            success: function (res) {
                if(res.success){
                        if(res.status == 1){
                            _this.attr('title','Show Comment')
                            _this.children(".hide-comment-icon").removeClass('fa-eye').addClass('fa-eye-slash')
                        }else{
                            _this.attr('title','Hide Comment')
                            _this.children(".hide-comment-icon").removeClass('fa-eye-slash').addClass('fa-eye');
                        }
                        toastr.success(res.success);
                }else{
                    toastr.error(res.error);
                }
            }
          });
    })
    
    jQuery(".hide-review").click(function(e){
        var _this = $(this)
        var id = _this.attr('data-id');
            jQuery.ajax({
            type: 'post',
            url: "{{ url('admin/profile/users/hide-review') }}",
            data: { id ,"_token": "{!! csrf_token() !!}" },
            success: function (res) {
                if(res.success){
                        if(res.status == 1){
                            _this.attr('title','Show Review')
                            jQuery("#_cmnt"+id).addClass('_reviewHidden')
                            _this.children(".hide-review-icon").removeClass('fa-eye').addClass('fa-eye-slash')
                        }else{
                            _this.attr('title','Hide Review')
                            jQuery("#_cmnt"+id).removeClass('_reviewHidden')
                            _this.children(".hide-review-icon").removeClass('fa-eye-slash').addClass('fa-eye')
                        }
                        toastr.success(res.success);
                }else{
                    toastr.error(res.error);
                }
            }
          });
    })
</script>


@endsection