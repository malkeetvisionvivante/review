<div class="card small-card">
@if(count($reviews) > 0)
    @foreach($reviews as $review)
    <div class="row p-md-4">
      <div class="col-lg-2 col-md-3 col-3">
        <div class="media-img-container p-2 rounded-circle position-relative m-md-auto">
          @if($review->working_as == 'Manager')
            <img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid rounded-circle" />
            <span class="feedback-score"><img src="{{ asset('images/manager-score-small.png')}}" class="img-fluid"/></span>
          @else
            <img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid rounded-circle" />
            <span class="feedback-score"><img src="{{ asset('images/peer-score-small.png')}}" class="img-fluid"/></span>
          @endif
      </div>
      </div>
      <div class="col-lg-10 col-md-9 col-9 align-self-center pl-3 pl-md-0">
        <div class="row">
          <div class="col-md">
            <div class="text-nowrap">
              <span class="text-light-blue mr-2 lead">{{ $review->getAvgReview() }}</span>
              @include('frontend.user_rating.5_thumb',['rate' => $review->getAvgReview() ])
            </div>
          </div>
          <div class="col-md text-md-right p-md-0">
            <span class="text-muted-dark mt-1 mt-md-0 d-inline-block"> {{ $review->createdAt() }}</span>
          </div>
        </div>
        @if($review->working_as == 'Manager')
          <h5 class="font-weight-normal mt-2">
            <i>{{ $review->userName() }}'s <span class="text-light-blue">direct</span> or <span class="text-light-blue">indirect report</span>.</i>
          </h5>
        @else
          <h5 class="font-weight-normal mt-2"><i>{{ $review->userName() }}'s <span class="text-light-blue">peer</span>.</i></h5>
        @endif
      </div>
      @if ($review->hidden_comment == 0) 
      <div class="col-lg-10 offset-lg-2 col-md-9 offset-md-3 mt-2 mt-md-0 p-md-0">
        <p>{{ $review->comment }}</p>
        <div class="d-flex justify-content-between align-items-center" id="review_div_{{ $review->id }}">
          <ul class="nav h3 font-weight-normal text-dark">
            @if(Auth::check())
              @if($review->isLike())
              <li class="nav-link">
                 <span class="remove-like" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentLikeCount() }} </span>
                  <img src="{{ url('/images/like-by-user.png') }}">
                </span>
              </li>
              @else
                <li class="nav-link">
                  <span class="like" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentLikeCount() }} </span>
                  <img src="{{ url('/images/like.png') }}">
                  </span>
                </li>
              @endif
              @if($review->isDisLike())
              <li class="nav-link">
                <span class="remove-dislike" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentDislikeCount() }} </span>
                  <img src="{{ url('/images/dislike-by-user.png') }}">
                </span>
              </li>
              @else
              <li class="nav-link">
                <span class="dislike" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentDislikeCount() }} </span>
                  <img src="{{ url('/images/dislike.png') }}">
                </span>
              </li>
              @endif
            @else 
              <li class="nav-link">
                 <span class="like" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentLikeCount() }} </span>
                  <img src="{{ url('/images/like.png') }}">
                </span>
              </li>
              <li class="nav-link">
                <span class="dislike" id="{{ $review->id}}">
                  <span class="count">{{ $review->commentDislikeCount() }} </span>
                  <img src="{{ url('/images/dislike.png') }}">
                </span>
              </li>
            @endif
            <li><a href="#" class="nav-link text-light-blue"><img src="{{ url('/images/share-icon.png') }}"/></a></li>
          </ul>
          @if (!($review->isFlagged()))
          <a href="javascript:void(0);" data-review-id="{{ $review->id }}" data-manager-id="{{ $review->user_id }}" class="text-muted-dark report-btn"><u>Report</u></a>
          @endif
        </div>
      </div>
      @endif
    </div>
    @if(!$loop->last)
    <hr>
    @endif
    @endforeach
    <!-- <div> {{ $reviews->links() }}</div> -->
  </div>
</div>
@endif
</div>
<script type="text/javascript">
  $(document).on('click', ".like",function(){
      var id = $(this).attr('id');
      var self = this;
      $.ajax({
        url: "{{ url('/review/like')}}/" + id,
        type: "get",
        success : function(data) { 
          if(data.status){
            $('#review_div_'+id).html(data.html);
            //toastr.success(data.message);
          } else {
            toastr.error(data.message);
          }
          
        },
        error : function(data) {}
      });
    });
  $(document).on('click', ".remove-like",function(){
      var id = $(this).attr('id');
      var self = this;
      $.ajax({
        url: "{{ url('/review/remove-like')}}/" + id,
        type: "get",
        success : function(data) { 
          if(data.status){
            $('#review_div_'+id).html(data.html);
            //toastr.success(data.message);
          } else {
            toastr.error(data.message);
          }
          
        },
        error : function(data) {}
      });
    });
  $(document).on('click', ".dislike",function(){
      var id = $(this).attr('id');
      var self = this;
      $.ajax({
        url: "{{ url('/review/dislike')}}/" + id,
        type: "get",
        success : function(data) { 
          if(data.status){
            $('#review_div_'+id).html(data.html);
            //toastr.success(data.message);
          } else {
            toastr.error(data.message);
          }
          
        },
        error : function(data) {}
      });
    });
  $(document).on('click', ".remove-dislike",function(){
      var id = $(this).attr('id');
      var self = this;
      $.ajax({
        url: "{{ url('/review/remove-dislike')}}/" + id,
        type: "get",
        success : function(data) { 
          if(data.status){
            $('#review_div_'+id).html(data.html);
            //toastr.success(data.message);
          } else {
            toastr.error(data.message);
          }
          
        },
        error : function(data) {}
      });
    }); 
</script>