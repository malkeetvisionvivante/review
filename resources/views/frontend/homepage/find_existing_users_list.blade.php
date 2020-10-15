@if(count($users) > 0)
@foreach($users as $user)
<div class="match-users">
<div class="card small-card">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="{{$user->id}}" name="selected-user" value="{{$user->id}}">
        <label class="custom-control-label w-100" for="{{$user->id}}"> 
            <div class="row p-0 align-items-center">
                <!-- <div class="col-md-1 text-md-left">
                    <input type="radio" value="{{$user->id}}" class="" name="selected-user">
                </div> -->
                    <div class="col-md-7 d-md-flex">
                        <div class="media align-items-md-center">
                            <div class="media-left">
                                <div class="media-img-container p-0 rounded-circle border-0">
                                    @if($user->profile)
                                    <a href="{{ url('/user-detail/'.$user->id)}}"><img src="{{ url('images/users/'.$user->profile) }}" alt="{{ $user->name }} {{ $user->last_name }}" class="img-fluid rounded-circle" /></a>
                                    @else 
                                    <a href="{{ url('/user-detail/'.$user->id)}}"><img src="{{ asset('images/default/user.png') }}" alt="{{ $user->name }} {{ $user->last_name }}" class="img-fluid rounded-circle" /></a>
                                    @endif
                                </div>
                            </div>
                            <div class="media-body">
                              <div class="d-flex justify-content-between">
                                <h5 class="mb-1"><a target="blank" href="{{ url('/manager-detail/'.$user->id)}}"> {{ $user->name }} {{ $user->last_name }}</a></h5>
                                </div>
                                <h6 class="text-muted mb-0"><a target="blank" href="{{ url('/company-detail/'.$user->company_id)}}" class="text-dark">{{ $user->companyName($user->company_id) }}</a></h6>
                                <h6 class="text-muted">{{ $user->companyType($user->company_id) }}</h6>
                                <h6 class="text-muted mt-md-3 mb-1"><a target="blank" href="{{ url('/manager-list/'.$user->company_id.'/'.$user->department_id)}}" class="text-dark">{{ $user->departmentName() }}</a></h6>
                                </div>  
                            </div>
                        </div>
                    <div class="col-md-5 mt-2 mt-md-0 text-md-right score">
                      <!-- <div class="company-overall-score company-overall-score-vertical">
                          <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $user->managerAvg(),'text' => 'Manager score']) </div>
                          <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $user->peerAvg(),'text' => 'Peer score']) </div>
                      </div> -->
                    </div>
                </div>   
        </label>
      </div>
    </div>
</div>
@endforeach
<div class="card small-card mt-3">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="none_of_these" name="selected-user" value="0">
        <label class="custom-control-label" for="none_of_these"> Nope - none of these profiles are me!</label>
      </div>
<!-- <div class="row p-0 align-items-center">
<div class="col-md-3 d-md-flex">
    <input type="radio" value="0" class="" name="selected-user">
</div>
<div class="col-md-9 text-md-right score">
    Nope - none of these profiles are me!
</div>
</div> -->
<div class="col-md-12 text-center mt-4">
    <input type="hidden" name="password" value="{{$postData['password']}}">
    <input type="hidden" name="email" value="{{$postData['email']}}">
    <input type="hidden" name="firstname" value="{{$postData['name']}}">
    <input type="hidden" name="last_name" value="{{$postData['last_name']}}">
    <button id="submit-button" class="btn btn-success round-shape">Submit</button>
</div>
</div>
@endif
<script>
    jQuery("#submit-button").click(function(){
        var selected = $("input[name='selected-user']:checked").val();
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();
        var firstname = $("input[name='firstname']").val();
        var last_name = $("input[name='last_name']").val();
        if(selected != undefined){
            jQuery.ajax({
            type: 'post',
            url: "{{ url('save-existing-users') }}",
            data: {selected, email, password,last_name, firstname, "_token": "{!! csrf_token() !!}"},
            success: function (data) {
                window.location = data.url;
            }
          });
        }
    })
</script>