@if(count($everyOneReviws) > 0)
                    @foreach($everyOneReviws as $myReviw)
                    <div class="card small mt-2">
                        <div class="row p-0 align-items-md-center">
                            <div class="col-md-9">
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
                                        <div class="d-flex justify-content-between"><h3><a href="{{ url('/company-detail/'.$myReviw->company_id) }}"> {{ $myReviw->compnay_name() }}</a></h3>
                                          <p class="mb-0 d-block d-md-none">
                                            <span class="thumb">
                                              @if($myReviw->avg_review < 3)
                                              <i class="fas fa-thumbs-up text-red border-red"></i>
                                              @elseif($myReviw->avg_review >= 3 && $myReviw->avg_review < 4)
                                              <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                                              @else
                                              <i class="fas fa-thumbs-up text-green"></i>
                                              @endif
                                            </span> <a href="#">{{ $myReviw->avg_review }} Score</a>
                                          </p>
                                        </div>
                                        <h6 class="mt-1 mt-md-2 mb-1">{{ $myReviw->customer_name($myReviw->user_id) }}</h6>
                                        <h6 class="text-muted">{{ date_format(date_create($myReviw->created_at),"d M Y h:iA") }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-left text-md-right score">
                                <div class="d-none d-md-block">
                                <p class="mb-0">
                                    <span class="thumb">
                                      @if($myReviw->avg_review < 3)
                                      <i class="fas fa-thumbs-up text-red border-red"></i>
                                      @elseif($myReviw->avg_review >= 3 && $myReviw->avg_review < 4)
                                      <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                                      @else
                                      <i class="fas fa-thumbs-up text-green"></i>
                                      @endif
                                    </span> <a href="#">{{ $myReviw->avg_review }} Score</a>
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
@endif