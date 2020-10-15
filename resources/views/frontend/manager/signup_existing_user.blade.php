@if(count($users) > 0)
@foreach($users as $user)
<div class="match-users">
<div class="card small-card p-1 p-md-3">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input manager_signup_match" id="{{$user->id}}" name="selected-user" value="{{$user->id}}">
        <label class="custom-control-label w-100" for="{{$user->id}}"> 
            <div class="row p-0 align-items-center">
                <div class="col-md-12 d-md-flex">
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
            </div>   
        </label>
      </div>
    </div>
</div>
@endforeach
<div class="card small-card mt-2 p-1 p-md-3">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input manager_signup_match" id="none_of_these" name="selected-user" value="0">
        <label class="custom-control-label" for="none_of_these"> Nope - none of these profiles are me!</label>
    </div>
    <div class="col-md-12 text-center my-1">
        <button id="submit-signup-login" class="btn btn-success round-shape">Submit</button>
        <div>
            <label id="submit-signup-login-error" class="error-message">Please select any value.</label>
        </div>
    </div>
</div>
<style type="text/css">#submit-signup-login-error{display: none;}</style>
<script type="text/javascript">
    $(document).ready(function(){
        var id = null;
        $('.manager_signup_match').click(function(){
            id = $(this).val();
            $('#submit-signup-login-error').hide();
        });
        $('#submit-signup-login').click(function(){
            if(id == null){
                $('#submit-signup-login-error').show();
                return false;
            } else {
                $('#submit-signup-login-error').hide();
            }
            window.location.href = "{{ url('/manger-signup-match') }}/"+id;
        });
    });
</script>
@endif
