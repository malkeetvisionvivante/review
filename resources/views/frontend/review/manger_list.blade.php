<div class="col-md-12">
    <h6 class="mb-4 r-font-weight-500 font-weight-700">Select the colleague you will review 
    </h6>
    <ul class="department-ul manager-ul show_manager">
      @if(count($data))  
      @foreach($data as $datas) 
          @if( !in_array($datas->id, $todayReviwedUser) )
         <li>
            <a class="" data-id="{{ $datas->id }}" data-manager-name="{{ $datas->name}} {{ $datas->last_name}}">
                <div class="media">
                    <div class="media-left">
                      @if($datas->profile)
                      <img src="{{ asset('images/users/'.$datas->profile)}}" alt="profile" class="img-fluid"/>
                      @else
                       <img src="{{ asset('images/default/user.png') }}" alt="profile" class="img-fluid"/>
                      @endif
                    </div>
                    <div class="media-body pl-3">
                        <h6 class="font-weight-600 mb-1">{{ $datas->name}} {{ $datas->last_name}}</h6>
                        @if((strlen($datas->job_title) > 30))
                        <h6 class="text-muted mb-0">{{ substr($datas->job_title,0, 30) }} ...</h6>
                        @else 
                        <h6 class="text-muted mb-0">{{ $datas->job_title }}</h6>
                        @endif
                        <div class="row mt-2">
                          <div class="col-md-6 pr-md-0 score-flex-responsive">
                            <div>@include('frontend.user_rating.1_thumb',['rate' => $datas->managerAvg(), 'text' => ''])</div>
                            <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/manager-score-small.png')}}"/> <span>Manager score</span></div>
                          </div>
                          <div class="col-md-6 score-flex-responsive">
                              <div> @include('frontend.user_rating.1_thumb',['rate' => $datas->peerAvg(), 'text' => '']) </div>
                              <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/peer-score-small.png')}}"/> <span>Peer score</span></div>
                          </div>
                        </div>     
                    </div>
                   <!--  <div class="media-right">
                      @include('frontend.user_rating.1_thumb',['rate' => $datas->manager_review($datas->id),'text' => ''])
                    </div> -->
                </div>
            </a>
        </li> 
        @endif
      @endforeach  
      @endif  
      <li>
          <a href="#" class="btn btn-custom-design" data-toggle="modal" data-target="#request_new_manager">
               Add your colleague
          </a>
      </li> 
    </ul>
</div>
<div class="col-md-12 mt-3 error-class manager-error"> Please select any colleague!</div>
<div class="col-md-12 mt-3">  
  <a href="javascript:void(0)" class="previous float-left h6 text-blue manager_back"><i class="fas fa-arrow-left"></i> Back</a>
  <a href="javascript:void(0)" class="next float-right h6 text-blue manager_next">Next <i class="fas fa-arrow-right"></i></a>
</div>

