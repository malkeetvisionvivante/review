@extends('frontend.layouts.apps')
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/') }}">Home</a></li>
        @if($data->company_id)
        <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/company-detail/'.$data->company_id) }}">Company</a></li>
        @endif
        @if($data->department_id && $data->company_id && $data->departmentIsVisible())
        <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/manager-list/'.$data->company_id.'/'.$data->department_id) }}">Department</a></li>
        @endif
        <li class="breadcrumb-item active text-primary" aria-current="page">Colleague</li>
      </ol>
    </nav>

    <div class="col-md-12 btn-section-sticky-top text-center">
      <div class="d-block d-md-none">
        @if($data->company_id && $data->department_id)
        <a href="{{ url('/add-review-user/'.$data->company_id.'/'.$data->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
        @endif
      </div>
  </div>

  <div class="card small-card profile-section-sticky-top mt-2">
    <div class="row p-0 align-items-center">
      <div class="col-lg-9 col-md-8 d-flex">
        <span class="tag">
          @if($data->isBookmark())
          <a class="tagUntag" href="#" data-id="{{$data->id}}"><img id="tagUntagImage{{$data->id}}" src="{{ asset('images/tag.png')}}" /></a>
          @else
          <a class="tagUntag" href="#" data-id="{{$data->id}}" data-toggle="tooltip" data-placement="top" title="Follow this profile to get notifications when new reviews are added."><img id="tagUntagImage{{$data->id}}" src="{{ asset('images/un-tag.png')}}" /></a>
          @endif
        </span>
        <div class="media align-items-md-center">
          <div class="media-left mr-md-3">
            <div class="media-img-container p-0 rounded-circle border-0">
              @if($data->profile)
                <a href="#"><img src="{{ asset('images/users/'.$data->profile)}}" alt="apple" class="img-fluid rounded-circle" /></a>
              @else
                <a href="#"><img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid rounded-circle" /></a>
              @endif
            </div>
          </div>
          <div class="media-body">
              <h3>{{ $data->name}} {{ $data->last_name}}</h3>
            <h6 class="text-dark mb-1"><a href="{{ url('/company-detail/'.$data->company_id) }}" class="text-dark">{{ $data->companyName( $data->company_id ) }}</a></h6>
            {!! $data->getTitle1() !!}
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 text-md-right">
        <div class="d-none d-md-block">
          @if($data->company_id && $data->department_id)
          <a href="{{ url('/add-review-user/'.$data->company_id.'/'.$data->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="card small-card mt-3 score_tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#summary">Summary</a>
      </li>
      <li class="nav-item">
        <a class="nav-link coming-soon" data-toggle="tab" href="#history">History</a>
      </li>
    </ul>

    <div class="tab-content">
      <div id="summary" class="tab-pane active"><br>
        <div class="row align-items-center">
          <div class="col-xl-8 col-lg-9 col-md-9 col-7 summary-history-tabs">
            <div class="row justify-content-center">
              <div class="col-lg-10 col-md-12">
                <div class="row align-items-center">
                  <div class="col-md-3 text-md-center">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('images/manager-score.png')}}" class="img-fluid"/>
                      <div class="d-block d-md-none ml-2">
                        <h3 class="mb-1">Manager score</h3>
                        <h6 class="text-dark">{{ $data->ManagerReviewCount() }} reviews</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <span class="large-rating">{{ $data->managerAvg() }}
                    <span class="rating-end">/5</span>
                  </span>
                  </div>
                  <div class="col-md-5">
                    <h3 class="mb-1 d-none d-md-block">Manager score</h3>
                    <h6 class="text-dark d-none d-md-block">{{ $data->ManagerReviewCount() }} reviews</h6>
                    <div class="text-nowrap mt-md-3">
                      @include('frontend.user_rating.5_thumb',['rate' => $data->managerAvg()]) 
                    </div>
                  </div>
                </div><hr>
                <div class="row align-items-center">
                  <div class="col-md-3 text-md-center">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('images/peer-score.png')}}" class="img-fluid"/>
                      <div class="d-block d-md-none ml-2">
                        <h3 class="mb-1">Peer score</h3>
                        <h6 class="text-dark">{{ $data->peerReviewCount() }} reviews</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <span class="large-rating">{{ $data->peerAvg() }}
                    <span class="rating-end">/5</span>
                  </span>
                  </div>
                  <div class="col-md-5">
                    <h3 class="mb-1 d-none d-md-block">Peer score</h3>
                    <h6 class="text-dark d-none d-md-block">{{ $data->peerReviewCount() }} reviews</h6>
                    <div class="text-nowrap mt-md-3">
                      @include('frontend.user_rating.5_thumb',['rate' => $data->peerAvg()]) 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-3 col-md-3 col-5 text-center border-left p-2 p-md-3 px-lg-5">
            <div class="circle-progress-bar" data-percent="{{ $percentage }}" data-duration="1000"></div> 
            <h3 class="mb-1">Recommend<br> to a Friend</h3>
          </div>
        </div>
      </div>
      <div id="history" class="tab-pane fade text-center">
       <h3 class="h1 p-5">Coming Soon!</h3>
      </div>
    </div>
  </div>



  <div class="card small-card mt-3">
    <div class="row p-0">
      <div class="col-md-12">
        <h3 class="mb-4 text-center text-md-left">Assessment score details</h3>
        <ul class="nav nav-tabs custom-nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link score-tab active" data-toggle="tab" href="#manager-score-detalils">
              <div class="score-tab-image" style="background:url({{ asset('images/manager-score-small-gray.png')}});"></div> Manager Score</a>
          </li>
          <li class="nav-item">
            <a class="nav-link peer-tab" data-toggle="tab" href="#peer-score-details">
              <div class="peer-tab-image" style="background:url({{ asset('images/peer-score-small-gray.png')}});"></div> Peer Score</a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="manager-score-detalils" class="tab-pane active">
                <table class="table custom-table first-td-border-0 mt-2">
                  @if(count($ReviewCategorys))  
                      @foreach($ReviewCategorys as $ReviewCategory)
                        @if($ReviewCategory->question_count1($ReviewCategory->id, 'Manager') > 0)
                          @php $rate = $ReviewCategory->categoryRate($ReviewCategory->id, $data->id, 'Manager'); @endphp
                          <tr>
                             <td><a href="javascript:void(0)" data-id="#manager_review_details{{$ReviewCategory->id}}">{{ $ReviewCategory->name }} <sup><i data-id="#manager_review_details{{$ReviewCategory->id}}" class="fas fa-info-circle text-muted"></i></sup> <a></td>
                              <td style="white-space:nowrap;text-align: right;">
                                <a href="javascript:void(0)" class="text-light-blue mr-2 lead rate-text" data-id="#manager_review_details{{$ReviewCategory->id}}">{{ $rate }}</a>
                                @include('frontend.user_rating.5_thumb',['rate' => $rate]) 
                              </td>
                          </tr>
                        @endif
                      @endforeach  
                  @else
                    <tr>No Result found!!</tr>
                  @endif
               </table>
          </div>
          <div id="peer-score-details" class="tab-pane fade">
            <table class="table custom-table first-td-border-0 mt-2">
                @if(count($ReviewCategorys))  
                  @foreach($ReviewCategorys as $ReviewCategory)
                   @if($ReviewCategory->question_count1($ReviewCategory->id, 'Peer') > 0)
                      @php $rate = $ReviewCategory->categoryRate($ReviewCategory->id, $data->id, 'Peer'); @endphp
                      <tr>
                        <td><a href="javascript:void(0)" data-id="#peer_review_details{{$ReviewCategory->id}}">{{ $ReviewCategory->name }} <sup><i data-id="#peer_review_details{{$ReviewCategory->id}}" class="fas fa-info-circle text-muted"></i></sup><a></td>
                        <td style="white-space:nowrap;text-align: right;">
                          <a href="javascript:void(0)" class="text-light-blue mr-2 lead rate-text" data-id="#peer_review_details{{$ReviewCategory->id}}">{{ $rate }}</a>
                          @include('frontend.user_rating.5_thumb',['rate' => $rate])
                        </td>
                      </tr>
                    @endif
                  @endforeach  
                @else
                  <tr>No Result found!!</tr>
                @endif
             </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="managercomments" next-page-url="{{ $reviews->nextPageUrl() }}" @if(!Auth::check()) class="manager-comments" @endif>
  @include('frontend.manager.managers_comments')
  @if(!Auth::check())
    @include('frontend.manager.signup_popup')
  @endif
</div>
<div class="ajax-load text-center mt-3" style="display:none;">
    <img src="{{ asset('images/loader1.gif') }}" height="30" width="30" alt="Load more..." class="img-fluid" />
</div>
</div>

@include('frontend.manager.managers_question_popup')
<script type="text/javascript">
   jQuery(document).ready(function(){
     jQuery('table tr td a i').mouseover(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).show();
     });
     jQuery('table tr td a i').mouseout(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).hide();
     });
   });

   jQuery(document).ready(function(){
     jQuery('table tr td a, .rate-text').mouseover(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).show();
     });
     jQuery('table tr td a, .rate-text').mouseout(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).hide();
     });
   });
   // jQuery(document).ready(function(){
   //   jQuery('table tr td a, .rate-text').click(function(){
   //     var id = jQuery(this).attr('data-id');
   //     jQuery(id).show();
   //   });
   //   jQuery('.close').click(function(){
   //     var id = jQuery(this).attr('data-id');
   //     jQuery(id).hide();
   //   });
   // });
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
</script>
@if(Auth::check())
<script type="text/javascript">
  $(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
      var hub = $("#managercomments");
      var page_url = hub.attr('next-page-url');
      if (page_url != null && page_url != '' && page_url != undefined) {$('.ajax-load').show();}
      clearTimeout(fetch);
      fetch = setTimeout(function () {
          if (page_url != null && page_url != '' && page_url != undefined) {
              hub.removeAttr('next-page-url');
              $.get(page_url, function (res) {
                hub.append(res.view);
                hub.attr('next-page-url', res.url);
              });
              $('.ajax-load').hide();
          }
      }, 600);
    }
  });
</script> 
@endif
@endsection