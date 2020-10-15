<li>
    <a data-id="{{ $data->id }}" data-manager-name="{{ $data->name}} {{ $data->last_name}}" class="active">
        <div class="media">
            <div class="media-left">
                 @if($data->profile)
                    <img src="{{ asset('images/users/'.$data->profile)}}" alt="apple"
                            class="img-fluid" />
                  @else
                    <img src="{{ asset('images/default/user.png') }}" alt="apple"
                            class="img-fluid" />
                  @endif
            </div>
            <div class="media-body pl-3">
                <h6 class="font-weight-600 mb-1">{{ $data->name}} {{ $data->last_name}}</h6>
               <!--  @if((strlen($data->job_title) > 30))
                <h6 class="text-muted mb-0">{{ substr($data->job_title,0, 30) }} ...</h6>
                @else 
                <h6 class="text-muted mb-0">{{ $data->job_title }}</h6>
                @endif -->
                <div class="row mt-2">
                    <div class="col-md-6 pr-md-0 score-flex-responsive">
                      @include('frontend.user_rating.1_thumb',['rate' => $data->managerAvg(), 'text' => ''])
                      <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/manager-score-small.png')}}"/> <span>Manager score</span></div>
                    </div>
                    <div class="col-md-6 score-flex-responsive">
                        <div> @include('frontend.user_rating.1_thumb',['rate' => $data->peerAvg(), 'text' => '']) </div>
                        <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/peer-score-small.png')}}"/> <span>Peer score</span></div>
                    </div>
                  </div>    
            </div>
        </div>
    </a>
</li>