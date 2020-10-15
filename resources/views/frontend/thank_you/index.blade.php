@extends('frontend.layouts.apps')
@section('content')

<style>
  footer{
    margin-top:0;
  }
</style>
<section class="bg-light pb-4">
<div class="container-fluid">
    <div class="row my-5 align-items-center">
      <div class="col-md-6 text-center">
        <div class="border p-4 h-100 rounded">
            <img src="{{ url('images/blossom_illustration_1.svg') }}" alt="thank you" class="img-fluid"/>
            <h1 class="mt-4 mb-2">Thank You</h1>
            <p>Your assessment has been successfully submitted for 
            <a href="{{ url('/manager-detail/'.$reviewee->id) }}">{{$reviewee->name}} {{$reviewee->last_name}}</a>. </p>
        </div>
      </div>
      <div class="col-md-6 mt-3 mt-md-0">
        <div class="r-share-back p-4 h-100 rounded">
          <h2 class="font-weight-400">Share with your colleagues and network</h2>
          <p>We spend +33% of our lives at work, let’s make it more transparent, meaningful and enjoyable</p>
          <button class="btn btn-success round-shape" data-target="#request_invitation" data-toggle="modal">Invite Now</button>
        </div>
      </div>
    </div>

    @if($companyUser || $users)
        @if(count($users)>0 || count($companyUser)>0)
        <div class="row card">
          <div class="col-md-12 text-center">
            <h2 class="mb-4">Others you may know</h2>
          </div>
          <div class="col-md-12">
            <div id="related__managers" class="owl-carousel owl-theme custom__owl__adjustment nav__show">
            @if($users && count($users)>0)
             @foreach($users as $user)
              <div class="item">
                <div class="card card-small text-center">
                <span class="absolute-tag position-absolute">
                
                  @if($user->isBookmark())
                  <a class="tagUntag" href="javascript:void(0)" data-id="{{$user->id}}">
                    <img id="tagUntagImage{{$user->id}}" src="{{ asset('images/tag.png')}}" />
                  </a>
                  @else
                  <a class="tagUntag" href="javascript:void(0)" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Follow this profile to get notifications when new reviews are added.">
                    <img id="tagUntagImage{{$user->id}}" src="{{ asset('images/un-tag.png')}}" />
                  </a>
                  @endif
                </span>
                  <div class="media-img-container m-auto p-0 rounded-circle">
                  @if($user->profile)
                    <a href="{{ url('/manager-detail/'.$user->id) }}"><img src="{{ asset('images/users/'.$user->profile)}}" alt="~Bonita ~" class="img-fluid rounded-circle"></a>
                  @else
                    <a href="{{ url('/manager-detail/'.$user->id) }}"><img src="{{ asset('images/company/'.$user->userCompanyImage($user->company_id)) }}" alt="~Bonita ~" class="img-fluid rounded-circle"></a>
                  @endif
                  </div>
                  <div class="name-limit">
                    <h4>
                      <a href="{{ url('/manager-detail/'.$user->id) }}" class="text-black">{{$user->name}} {{$user->last_name}}</a>
                    </h4>
                  </div>

                  <div class="company-department-set">
                  <h6>
                    @if($user->company_id)
                    <a href="{{ url('/company-detail/'.$user->company_id) }}" class="text-muted-dark"><i class="fas fa-building"></i> {{ $user->companyName($user->company_id) }}</a>
                    @endif
                  </h6>
                  <h6>
                    @if($user->department_id)
                    <a href="{{ url('/manager-list/'.$user->company_id.'/'.$user->department_id) }}" class="text-muted-dark">{{ $user->departmentName() }}</a>
                    @endif
                  </h6>
                </div>
                  <div class="row text-left my-3">
                    <div class="col-6 border-right">
                      @include('frontend.user_rating.1_thumb',['rate' => $user->managerAvg(), 'text' => ''])
                      <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/manager-score-small.png')}}"/> <span>Manager score</span></div>
                    </div>
                    <div class="col-6">
                      <div class="peer-margin">
                        <div> @include('frontend.user_rating.1_thumb',['rate' => $user->peerAvg(), 'text' => '']) </div>
                        <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/peer-score-small.png')}}"/> <span>Peer score</span></div>
                      </div>
                    </div>
                  </div>
                  @if($user->company_id)
                    <a href="{{ url('add-review-user/'.$user->company_id.'/'.$user->id)}}" class="btn btn-primary">Add your review</a>
                  @endif
                </div>
              </div>
             @endforeach
          @endif
          @if($companyUser && count($companyUser)>0)
             @foreach($companyUser as $user)
              <div class="item">
                <div class="card card-small text-center">
                <span class="absolute-tag position-absolute">
                
                  @if($user->isBookmark())
                  <a class="tagUntag" href="#" data-id="{{$user->id}}">
                    <img id="tagUntagImage{{$user->id}}" src="{{ asset('images/tag.png')}}" />
                  </a>
                  @else
                  <a class="tagUntag" href="#" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Follow this profile to get notifications when new reviews are added.">
                    <img id="tagUntagImage{{$user->id}}" src="{{ asset('images/un-tag.png')}}" />
                  </a>
                  @endif
                </span>
                  <div class="media-img-container m-auto p-0 rounded-circle">
                  @if($user->profile)
                    <a href="{{ url('/manager-detail/'.$user->id) }}"><img src="{{ asset('images/users/'.$user->profile)}}" alt="~Bonita ~" class="img-fluid rounded-circle"></a>
                  @else
                  <a href="{{ url('/manager-detail/'.$user->id) }}"><img src="{{ asset('images/company/'.$user->userCompanyImage($user->company_id)) }}" alt="~Bonita ~" class="img-fluid rounded-circle"></a>
                  @endif
                  </div>
                  <div class="name-limit">
                  <h4>
                    <a href="{{ url('/manager-detail/'.$user->id) }}" class="text-black">{{$user->name}} {{$user->last_name}}</a>
                  </h4>
                </div>
                <div class="company-department-set">
                  <h6>
                    @if($user->company_id)
                    <a href="{{ url('/company-detail/'.$user->company_id) }}" class="text-muted-dark"><i class="fas fa-building"></i> {{ $user->companyName($user->company_id) }}</a>
                    @endif
                  </h6>
                  <h6>
                    @if($user->department_id)
                    <a href="{{ url('/manager-list/'.$user->company_id.'/'.$user->department_id) }}" class="text-muted-dark">{{ $user->departmentName() }}</a>
                    @endif
                  </h6>
                </div>
                  <div class="row text-left my-3">
                    <div class="col-6 border-right">
                      @include('frontend.user_rating.1_thumb',['rate' => $user->managerAvg(), 'text' => ''])
                      <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/manager-score-small.png')}}"/> <span>Manager score</span></div>
                    </div>
                    <div class="col-6">
                     <div class="peer-margin">
                       <div>@include('frontend.user_rating.1_thumb',['rate' => $user->peerAvg(), 'text' => '']) </div>
                      <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/peer-score-small.png')}}"/> <span>Peer score</span></div>
                    </div>
                    </div>
                  </div>
                  @if($user->company_id)
                    <a href="{{ url('add-review-user/'.$user->company_id.'/'.$user->id)}}" class="btn btn-primary">Add Your Review</a>
                  @endif
                </div>
              </div>
             @endforeach
             @endif
          </div>
          </div>
        </div>
      @endif
    @endif
</div>
</section>

<!--card section end--> 
<div class="modal fade" id="request_invitation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div> -->

      <div class="modal-body p-3 p-md-4">
        <h4 class="mb-4">Invite your colleagues & friends!</h4>
        <form class="invite-form" name="Invitation_form" action="{{ url('/invite/invite_friends_email')}}" method="post">
          @csrf
          <div class="form-group">
            <label>First name</label>
            <input type="text" placeholder="Your friend's first name" class="form-control" name="_fname">
          </div>
          <div class="form-group">
            <label>Last name</label>            
            <input type="text" placeholder="Your friend's last name" class="form-control" name="_lname">
          </div>
          <div class="form-group">
            <label>Email address</label>
            <input type="email" placeholder="Your friend's email address" class="form-control" name="_email">
          </div>
          <div class="form-group mb-4">
            <label>LinkedIn profile <i>(Bonus!)</i></label>            
            <input type="url" placeholder="Your friend's LinkedIn profile url" class="form-control" name="_linkedin">
          </div>
          <!-- <div class="form-group">
            <label>Your Email</label>
            @if(Auth::check())
              <input type="email" placeholder="Email" value="{{Auth::user()->email}}" class="form-control" name="_login_user_email" readonly>
            @else
              <input type="email" placeholder="Email" class="form-control" name="_login_user_email">                
            @endif
            </div> --><hr>
          <div class="form-check mb-4">
            <label class="form-check-label mt-0">
              <input type="checkbox" class="form-check-input" name="mystery">Send as a mystery invitation (anonymous)
            </label>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-dark-blue btn-disabled">Send invite</button>
          </div>
        </form>
      </div>
      <div class="modal-body p-3 p-md-4 invite-sent text-center" style="display: none;">
        <span class="sent-image animate__animated animate__zoomIn"><img src="{{ url('/images/flash.png') }}"/></span>
        <span class="sent-image right animate__animated animate__zoomIn animate__delay-1s"><img src="{{ url('/images/flash.png') }}"/></span>
        <h2 class="mt-5 font-weight-bold">Invite sent!</h2>
        <div class="btn-gap"><span><img src="{{ url('/images/flash1.png') }}"/> <a href="#" class="btn btn-success btn-blue mx-2 invite_again">Invite another</a> <img src="{{ url('/images/flash1.png') }}"/></span></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	 jQuery('.invite-form').validate({
     errorClass:"error-message",
     validClass:"green",
     rules:{
            _fname:{
                required:true,
            },
            _lname:{
                required:true,
            },
            _email:{
                required:true,
                email:true,
            },
            // _login_user_email:{
            //     required:true,
            //     email:true,
            // },
            // _linkedin:{
            //     required:true,
            // },
          },
           messages: {
            _fname: {required:"First name is required field. " },
            _lname: {required:"Last name is required field. " },
            // _linkedin: {required:"LinkedIn profile is required field. " },
            _email: {
              required: "Email is required field.",
              email: "Email address must be in the format of name@domain.com"
            },
            // _login_user_email: {
            //   required: "Email is required field.",
            //   email: "Email address must be in the format of name@domain.com"
            // }
        }      
  });

</script>
<script type="text/javascript">
    jQuery(document).on('click', ".tagUntag", function(e){
      e.preventDefault();
      var _this = jQuery(this);
      var id = $(this).attr('data-id');
      $.ajax({
        url: "{{ url('/bookmarks/perform')}}/" + id,
        type: "get",
        success : function(res) { 
          var imgid = "#tagUntagImage"+id;
          var src = jQuery(imgid).attr("src");
          if(src.includes("images/tag.png")){
            jQuery(imgid).attr("src","{{ asset('images/un-tag.png')}}");
            var attr = _this.attr('data-placement');
            if (typeof attr !== typeof undefined && attr !== false) {
              _this.tooltip('enable');
          }else{
            _this.attr({
              "data-toggle":"tooltip",
              "data-placement":"top",
              "title":"Follow this profile to get notifications when new reviews are added."
            });
            _this.tooltip();
          }
        }else{
            jQuery(imgid).attr("src","{{ asset('images/tag.png')}}");
            _this.tooltip('disable');
          }
        },
        error : function(res) {}
      });
    })

    jQuery(".invite-form").submit(function(e){
    e.preventDefault();
    var _this = jQuery(this);
    if(_this.valid()){
    jQuery.ajax({
            type: 'post',
            url: "{{ url('/invite/invite_friends_email') }}",
            data: _this.serialize(),
            success: function (data) {
                if(data.success){
                  $('#request_invitation .modal-body').hide();
                  $('.invite-sent').show();
               }else if(data.error){
                  console.log('error')
                	
               }
            }
          });
    }
        });
  $('.invite_again').click(function(){
  	 $('#request_invitation .modal-body').show();
  	 $('#request_invitation form')[0].reset();
     $('#request_invitation button').addClass('btn-disabled');
      $('.invite-sent').hide();
  })
  $('#request_invitation').find('input[name=_email]').on("keyup change", function(){
  	if($('#request_invitation').find('input[name=_email]').val() != ''){
  		$('#request_invitation button').removeClass('btn-disabled');
  	}else{
      $('#request_invitation button').addClass('btn-disabled');
  		// if(!$('#request_invitation button').hasClass('btn-disabled')){
	  	// 	$('#request_invitation button').removeClass('btn-disabled');
	  	// }
  	}
  })
</script>
@endsection   