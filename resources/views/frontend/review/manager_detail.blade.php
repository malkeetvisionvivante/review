<div class="col-md-8">
    <div class="d-flex flex-column flex-md-row justify-content-md-between">
        <div class="media align-items-center">
            <div class="media-left">
                <div class="media-img-container p-0 rounded-circle border-0">
                   @if($manager->profile)
                  <img src="{{ asset('images/users/'.$manager->profile)}}" alt="apple"
                          class="img-fluid rounded-circle" />
                @else
                  <img src="{{ asset('images/default/user.png') }}" alt="apple"
                          class="img-fluid rounded-circle" />
                @endif
                      </div>
            </div>
            <div class="media-body">
                <h3>{{ $manager->name}} {{ $manager->last_name}}</h3>
                <h6 class="text-muted mb-1">{{ $manager->companyName( $manager->company_id ) }}</h6>
                {!! $manager->getTitle1() !!}
                <div class="d-block d-md-none">
                  <div class="company-overall-score company-overall-score-vertical">
                    <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $manager->managerAvg(),'text' => 'Manager score']) </div>
                    <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $manager->peerAvg(),'text' => 'Peer score']) </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
  <div class="d-none d-md-inline-block float-right">
    <div class="company-overall-score">
      <div>@include('frontend.user_rating.1_thumb_manager',['rate' => $manager->managerAvg(),'text' => 'Manager score']) </div>
      <div> @include('frontend.user_rating.1_thumb_peer',['rate' => $manager->peerAvg(),'text' => 'Peer score']) </div>
    </div>
  </div>
</div>