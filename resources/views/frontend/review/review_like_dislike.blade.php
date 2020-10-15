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
  <li><a href="#" class="nav-link"><img src="https://blossom.team/beta/images/share-icon.png"></a></li>
</ul>
<a href="#" class="text-muted-dark"><u>Report</u></a>