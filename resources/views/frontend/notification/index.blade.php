@extends('frontend.layouts.apps')
@section('content')
<section class="newsfeed-sticky bg-white shadow-none">
  <div class="container-fluid">
      <div class="row justify-content-between py-2 py-md-3">
          <div class="col">
            <button class="btn btn-success round-shape" data-target="#request_invitation" data-toggle="modal">Invite Friends</button>
          </div>
          <div class="col text-right">
          <a href="{{ url('/search/results') }}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
        </div>
      </div>
  </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h2">Notifications</h1>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-tabs custom-nav-tabs custom-nav-tabs-text-left notification-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#my_notifications">
                         My notifications</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link peer-tab" data-toggle="tab" href="#profiles_am_following">
                        Profiles I'm following</a>
                    </li>
                  </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active card-with-border" id="my_notifications" role="tabpanel">
                        <div class="card small-card">
                            <div class="media unread">
                                <div class="media-left">
                                    <div class="media-img-container p-0 rounded-circle border-0">
                                       <img src="{{ asset('images/no-image.jpg')}}" alt="&shy;Ravindra Ramnani" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <p>Roch Mamenas <strong>shared a post</strong>. The best a human can get is recognition of their hard work and strong support! What do you think?</p>
                                    <a href="#" class="btn btn-outline-primary">See all views</a>
                                </div>
                                <div class="media-right align-self-center">
                                    <small class="text-muted">4d</small>
                                </div>
                            </div>
                        
                            <div class="media">
                                <div class="media-left">
                                    <div class="media-img-container p-0 rounded-circle border-0">
                                       <img src="{{ asset('images/no-image.jpg')}}" alt="&shy;Ravindra Ramnani" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <p>Congratulate Matilde Attemi for <strong>starting a new position</strong> as Documentation Specialist at FAO</p>
                                    <a href="#" class="btn btn-outline-primary">Say congrats</a>
                                </div>
                                <div class="media-right align-self-center">
                                    <small class="text-muted">4d</small>
                                </div>
                            </div>
                        
                                <div class="media">
                                    <div class="media-left">
                                        <div class="media-img-container p-0 rounded-circle border-0">
                                        <img src="{{ asset('images/no-image.jpg')}}" alt="Ravindra Ramnani" class="img-fluid rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <p>Wish Jeanette Kim, CPA <strong>a happy birthday</strong> (today)</p>
                                        <a href="#" class="btn btn-outline-primary">Say happy birthday</a>
                                    </div>
                                    <div class="media-right align-self-center">
                                        <small class="text-muted">2h</small>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="tab-pane fade card-with-border" id="profiles_am_following" role="tabpanel">
                        <div class="card small-card">
                            <div class="media align-items-center">
                                <div class="media-left">
                                    <div class="media-img-container p-0 rounded-circle border-0">
                                       <img src="{{ asset('images/default/user.png')}}" alt="&shy;Ravindra Ramnani" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="mb-1"><a href="#">Ravindra Ramnani</a></h4>
                                    <h6 class="mb-3"><a href="#" class="text-muted-dark"><i class="fas fa-building"></i> Aria Systems</a></h6>
                                    <h6 class="mb-0"><a href="#" class="text-dark">Sales</a></h6>
                                </div>
                                <div class="media-right">
                                    <a href="#" class="btn btn-outline-primary">Unfollow</a>
                                </div>
                            </div>
                            <div class="media align-items-center">
                                <div class="media-left">
                                    <div class="media-img-container p-0 rounded-circle border-0">
                                       <img src="{{ asset('images/default/user.png')}}" alt="&shy;Ravindra Ramnani" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="mb-1"><a href="#">-Hannah B.</a></h4>
                                    <h6 class="mb-3"><a href="#" class="text-muted-dark"><i class="fas fa-building"></i> Five9</a></h6>
                                    <h6 class="mb-0"><a href="#" class="text-dark">Sales</a></h6>
                                </div>
                                <div class="media-right">
                                    <a href="#" class="btn btn-outline-primary">Unfollow</a>
                                </div>
                            </div>
                            <div class="media align-items-center">
                                <div class="media-left">
                                    <div class="media-img-container p-0 rounded-circle border-0">
                                       <img src="{{ asset('images/default/user.png')}}" alt="&shy;Ravindra Ramnani" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="mb-1"><a href="#">?Noah Schreiber</a></h4>
                                    <h6 class="mb-3"><a href="#" class="text-muted-dark"><i class="fas fa-building"></i> SmartRecruiters</a></h6>
                                    <h6 class="mb-0"><a href="#" class="text-dark">Human Resources</a></h6>
                                </div>
                                <div class="media-right">
                                    <a href="#" class="btn btn-outline-primary">Unfollow</a>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection  
