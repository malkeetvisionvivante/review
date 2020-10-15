@if(count($users) > 0)
@foreach($users as $user)
<div class="match-users">
<div class="card small-card">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input social_login_match" id="{{$user->id}}" name="selected-user" value="{{$user->id}}">
        <label class="custom-control-label w-100" for="{{$user->id}}"> 
            <div class="row p-0 align-items-center">
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
            </div>   
        </label>
      </div>
    </div>
</div>
@endforeach
<div class="card small-card mt-3">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input social_login_match" id="none_of_these" name="selected-user" value="0">
        <label class="custom-control-label" for="none_of_these"> Nope - none of these profiles are me!</label>
    </div>
    <div class="col-md-12 text-center mt-4">
        <button id="submit-social-login" class="btn btn-success round-shape">Submit</button>
        <div>
            <label id="submit-social-login-error" class="error-message">Please select any value.</label>
        </div>
    </div>
</div>
<style type="text/css">#submit-social-login-error{display: none;}</style>
@if($login_from =='google')
<script type="text/javascript">
    $(document).ready(function(){
        var id = null;
        $('.social_login_match').click(function(){
            id = $(this).val();
            $('#submit-social-login-error').hide();
        });
        $('#submit-social-login').click(function(){
            if(id == null){
                $('#submit-social-login-error').show();
                return false;
            } else {
                $('#submit-social-login-error').hide();
            }
            window.location.href = "{{ url('/social-signup-match-google') }}/"+id;
        });
    });
</script>
@endif
@if($login_from =='facebook')
<script type="text/javascript">
    $(document).ready(function(){
        var id = null;
        $('.social_login_match').click(function(){
            id = $(this).val();
            $('#submit-social-login-error').hide();
        });
        $('#submit-social-login').click(function(){
            if(id == null){
                $('#submit-social-login-error').show();
                return false;
            } else {
                $('#submit-social-login-error').hide();
            }
            window.location.href = "{{ url('/social-signup-match-facebook') }}/"+id;
        });
        // $('.social_login_match').click(function(){
        //     window.location.href = "{{ url('/social-signup-match-facebook') }}/"+$(this).val();
        // });
    });
</script>
@endif
@if($login_from =='linkedin')
<script type="text/javascript">
    $(document).ready(function(){
        var id = null;
        $('.social_login_match').click(function(){
            id = $(this).val();
            $('#submit-social-login-error').hide();
        });
        $('#submit-social-login').click(function(){
            if(id == null){
                $('#submit-social-login-error').show();
                return false;
            } else {
                $('#submit-social-login-error').hide();
            }
            window.location.href = "{{ url('/social-signup-match-linkedin') }}/"+id;
        });
        // $('.social_login_match').click(function(){
        //     window.location.href = "{{ url('/social-signup-match-linkedin') }}/"+$(this).val();
        // });
    });
</script>
@endif
@endif
