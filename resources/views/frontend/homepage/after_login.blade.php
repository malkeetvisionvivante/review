@extends('frontend.layouts.apps')
@section('content')
<section class="newsfeed-sticky bg-white">
  <div class="container-fluid">
      <div class="row justify-content-between pt-2 pt-md-3">
          <div class="col">
            <button class="btn btn-success round-shape" data-target="#request_invitation" data-toggle="modal">Invite Friends</button>
          </div>
          <div class="col text-right">
          <a href="{{ url('/search/results') }}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <ul class="nav nav-tabs nav-justified reviews--custom--tabs" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                          aria-controls="all" aria-selected="true"><i class="fas fa-globe-asia"></i> <span class="d-none d-md-inline-block">Public</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="orgnaization-tab" data-toggle="tab" href="#orgnaization" role="tab"
                          aria-controls="orgnaization" aria-selected="false"><i class="fas fa-building"></i> <span class="d-none d-md-inline-block">My organization</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="your-tab" data-toggle="tab" href="#your" role="tab"
                          aria-controls="your" aria-selected="false"><i class="fas fa-user-circle"></i> <span class="d-none d-md-inline-block">My reviews</span></a>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</section>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" next-page-url="{{ $everyOneReviws->nextPageUrl() }}" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <!-- <h4 class="mb-4">Everyone's review</h4> -->
                    @if(count($everyOneReviws) > 0)
                    @foreach($everyOneReviws as $myReviw)
                    <div class="card small-card mt-2">
                        <div class="row p-0 align-items-md-center">
                            <div class="col-xl-10 col-lg-9 col-md-9">
                                <div class="media align-items-md-center">
                                    <div class="media-left">
                                        <div class="media-img-container p-0">
                                            @if($myReviw->compnay_image())
                                              <a href="{{ url('/company-detail/'.$myReviw->company_id) }}"><img src="{{ asset('images/company/'.$myReviw->compnay_image())}}" alt="apple" class="img-fluid" /></a>
                                            @else
                                              <a href="{{ url('/company-detail/'.$myReviw->company_id) }}"><img src="{{ asset('images/default/user.png') }}" alt="apple" class="img-fluid" /></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between">
                                          <h3><a href="{{ url('/company-detail/'.$myReviw->company_id) }}"> {{ $myReviw->compnay_name() }}</a></h3>
                                          <span class="text-muted d-block d-md-none">{{ date_format(date_create($myReviw->created_at),"d M Y") }}</span>
                                        </div>
                                        
                                        <h6 class="mt-1 mt-md-2 mb-1"><a class="text-dark" href="{{ url('/manager-detail/'.$myReviw->user_id) }}">{{ $myReviw->customer_name($myReviw->user_id) }}</a></h6>
                                        <h6 class="text-muted d-none d-md-block">{{ date_format(date_create($myReviw->created_at),"d M Y h:iA") }}</h6>
                                        <div class="d-block d-md-none score-flex-responsive">
                                          @if($myReviw->working_as == 'Peer')
                                            <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                            <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                          @else
                                            <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                            <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                          @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="d-none d-md-block">
                              @if($myReviw->working_as == 'Peer')
                                @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                              @else
                                @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                              @endif
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else 
                      <div class="card small mt-2">Coming soon!</div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <?php 
                              $apendData = ['pu_page' => $everyOneReviws->currentPage()];
                              if(isset($_GET['mo_page'])){
                                $apendData['mo_page'] = $_GET['mo_page'];
                              }
                              if(isset($_GET['my_page'])){
                                $apendData['my_page'] = $_GET['my_page'];
                              }
                            ?>
                            {{ $everyOneReviws->appends($apendData)->links() }}
                        </div>
                    </div>
                       

                </div>

                <div class="tab-pane fade" id="orgnaization" role="tabpanel" aria-labelledby="orgnaization-tab">
                    <!-- <h4 class="mb-4">My Orgnaization Reviews</h4> -->
                    @if(count($myOrganizationReviws) > 0)
                    @foreach($myOrganizationReviws as $myReviw)
                    <div class="card small-card mt-2">
                        <div class="row p-0 align-items-md-center">
                            <div class="col-xl-10 col-lg-9 col-md-9">
                                <div class="media align-items-md-center">
                                    <div class="media-left">
                                        <div class="media-img-container p-0 rounded-circle border-0">
                                            @if($myReviw->customer_image())
                                              <a href="{{ url('/manager-detail/'.$myReviw->user_id) }}"><img src="{{ asset('images/users/'.$myReviw->customer_image())}}" alt="apple" class="img-fluid rounded-circle" /></a>
                                            @else
                                              <a href="{{ url('/manager-detail/'.$myReviw->user_id) }}"><img src="{{ asset('images/default/user.png') }}" alt="apple" class="img-fluid rounded-circle" /></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="media-body">
                                      <div class="d-flex justify-content-between">
                                        <h3><a href="{{ url('/manager-detail/'.$myReviw->user_id) }}">{{ $myReviw->customer_name($myReviw->user_id) }}</a></h3>
                                        <span class="text-muted d-block d-md-none">{{ date_format(date_create($myReviw->created_at),"d M Y") }}</span>
                                      </div>
                                      <h6 class="mt-1 mt-md-2 mb-1">{{ $myReviw->department_name() }}</h6>
                                      <h6 class="text-muted d-none d-md-block">{{ date_format(date_create($myReviw->created_at),"d M Y h:iA") }}</h6>
                                      <div class="d-block d-md-none score-flex-responsive">
                                        @if($myReviw->working_as == 'Peer')
                                          <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                          <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                        @else
                                          <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                          <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-3">
                                <div class="d-none d-md-block">
                                    @if($myReviw->working_as == 'Peer')
                                      @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                      <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                    @else
                                      @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                      <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                    @endif
                              </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else 
                      <div class="card small mt-2">Coming soon!</div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <?php 
                              $apendData = ['mo_page' => $myOrganizationReviws->currentPage()];
                              if(isset($_GET['pu_page'])){
                                $apendData['pu_page'] = $_GET['pu_page'];
                              }
                              if(isset($_GET['my_page'])){
                                $apendData['my_page'] = $_GET['my_page'];
                              }
                            ?>
                            {{ $myOrganizationReviws->appends($apendData)->links() }}
                        </div>
                    </div>
                       
                       
                </div>
                <div class="tab-pane fade" id="your" role="tabpanel" aria-labelledby="your-tab">
                    <!-- <h4 class="mb-4">My Reviews</h4> -->
                    @if(count($myReviws) > 0)
                    @foreach($myReviws as $myReviw)
                    <div class="card small-card mt-2">
                        <div class="row p-0 align-items-md-center">
                            <div class="col-xl-10 col-lg-9 col-md-9">
                                <div class="media align-items-md-center">
                                    <div class="media-left">
                                        <div class="media-img-container p-0 rounded-circle border-0">
                                            @if($myReviw->customer_image())
                                              <a href="{{ url('/manager-detail/'.$myReviw->user_id) }}"><img src="{{ asset('images/users/'.$myReviw->customer_image())}}" alt="apple"
                                                      class="img-fluid rounded-circle" /></a>
                                            @else
                                              <a href="{{ url('/manager-detail/'.$myReviw->user_id) }}"><img src="{{ asset('images/default/user.png') }}" alt="apple"
                                                      class="img-fluid rounded-circle" /></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="media-body">
                                      <div class="d-flex justify-content-between">
                                      <h3><a href="{{ url('/manager-detail/'.$myReviw->user_id) }}">{{ $myReviw->customer_name($myReviw->user_id) }}</a></h3>
                                          <span class="text-muted d-block d-md-none">{{ date_format(date_create($myReviw->created_at),"d M Y") }}</span>
                                      </div>
                                        
                                        <h6 class="mt-1 mt-md-2 mb-1">{{ $myReviw->department_name() }}</h6>
                                        <h6 class="text-muted d-none d-md-block">{{ date_format(date_create($myReviw->created_at),"d M Y h:iA") }}</h6>
                                        
                                          <div class="d-block d-md-none">
                                          @if($myReviw->working_as == 'Peer')
                                          <div class="score-flex-responsive">
                                            <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                            <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                          </div>
                                            <div><a href="javascript:void(0)" class="view_review_pop" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Assessment details</a></div>
                                             @if($myReviw->hold)
                                             <div><a href="javascript:void(0)" class="review_edit" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Edit</a></div>
                                             @endif
                                          @else
                                          <div class="score-flex-responsive">
                                            <div>@include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])</div>
                                            <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                          </div>
                                            <div><a href="javascript:void(0)" class="view_review_pop" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Assessment details</a></div>
                                             @if($myReviw->hold)
                                             <div><a href="javascript:void(0)" class="review_edit" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Edit</a></div>
                                             @endif
                                          @endif
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-3">
                              <div class="d-none d-md-block">
                                @if($myReviw->working_as == 'Peer')
                                  @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                  <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                   <div class="mt-1"><a href="javascript:void(0)" class="view_review_pop" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Assessment details</a></div>
                                    @if($myReviw->hold)
                                   <div><a href="javascript:void(0)" class="review_edit" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Edit</a></div>
                                   @endif
                                @else
                                  @include('frontend.user_rating.1_thumb',['rate' => $myReviw->avg_review,'text' => ''])
                                  <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                   <div class="mt-1"><a href="javascript:void(0)" class="view_review_pop" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Assessment details</a></div>
                                   @if($myReviw->hold)
                                   <div><a href="javascript:void(0)" class="review_edit" data-id="{{$myReviw->id}}" data-toggle="modal" data-target="#review_details_user">Edit</a></div>
                                   @endif
                                @endif
                              </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else 
                      <div class="card small mt-2">Coming soon!</div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <?php 
                              $apendData = ['my_page' => $myReviws->currentPage()];
                              if(isset($_GET['pu_page'])){
                                $apendData['pu_page'] = $_GET['pu_page'];
                              }
                              if(isset($_GET['mo_page'])){
                                $apendData['mo_page'] = $_GET['mo_page'];
                              }
                            ?>
                            {{ $myReviws->appends($apendData)->links() }}
                        </div>
                    </div>
                </div>
            <!-- <div class="ajax-load text-center" style="display:none">
              <p>Loading...</p>
            </div> -->
            </div>
        </div>
    </div>
</div>
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
            //_login_user_email: {
            //   required: "Email is required field.",
            //   email: "Email address must be in the format of name@domain.com"
            // }
        }      
  });

  jQuery(document).ready(function(){
     
      @if(isset($_GET['myorganization']) && $_GET['myorganization'] == 1)
      jQuery('#orgnaization-tab').trigger('click');
      @else
       if(localStorage.getItem('reviewCurrentFilter')){
        var filter = localStorage.getItem('reviewCurrentFilter');
        if(filter == 'public'){
          jQuery('#all-tab').trigger('click');
        } else if(filter == 'myorganization'){
          jQuery('#orgnaization-tab').trigger('click');
        } else {
          jQuery('#your-tab').trigger('click');
        }
      } else {
        localStorage.setItem('reviewCurrentFilter', 'public');
      }
      @endif
      jQuery('#all-tab').click(function(){
        localStorage.setItem('reviewCurrentFilter', 'public');
      });
      jQuery('#orgnaization-tab').click(function(){
        localStorage.setItem('reviewCurrentFilter', 'myorganization');
      });
      jQuery('#your-tab').click(function(){
        localStorage.setItem('reviewCurrentFilter', 'myreview');
      });
    });
</script>

<!-- <script type="text/javascript">
        $(window).scroll(function() {
          if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            $('.ajax-load').show();
            clearTimeout(fetch);
            fetch = setTimeout(function () {
                var page_url = $(".tab-pane.fade.show.active").attr('next-page-url');
                console.log("scrolled");
              // This condition is very essential //
                if (page_url != null) {
                    $.get(page_url, function (data) {
                        $(".tab-pane.fade.show.active").append(data.view);
                        $(".tab-pane.fade.show.active").attr('next-page-url', data.url);
                    });
                    $('.ajax-load').hide();
                }
            }, 2000);
          }
        });
</script> -->
<div class="modal fade" id="review_details_user">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body pt-1" id="review_model_body">
      </div>
    </div>
  </div>
</div>
@include('frontend.homepage.popup')
<script type="text/javascript">
    $(document).on('click','.view_review_pop',function(){
       var id =  $(this).attr('data-id');
       var url = "{{ url('/get-user-review-model')}}/" + id;
       $('#review_model_body').load(url,function(){
        $('#review_details_user').modal({show:true});
      });
    });

    $(document).on('click','.review_edit',function(){
       var id =  $(this).attr('data-id');
       var url = "{{ url('/edit-user-review-model')}}/" + id; 
       $('#review_model_body').load(url,function(){
        $('#review_details_user').modal({show:true});
      });
    });

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
