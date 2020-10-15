@extends('frontend.layouts.apps')
@section('content')
@if (session('status'))
    <?php toastr()->success(session('status')); ?>
@endif
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 mt-5">
            <a href="{{ url('/') }}" class="mb-3 d-block"><i class="fas fa-chevron-left"></i> Back</a>
            <div class="card shadow-sm">
                <form class="mainform" action="{{ route('password.update') }}" method="post">
                     @csrf
                     <input type="hidden" name="token" value="{{ $token }}">
                    <img src="{{ url('images/blossom_logo_primary.svg') }}" class="img-fluid logo mb-4" alt="silmarilli">
                    <h5 class="mb-3">Reset Password</h5>
                    <div class="form-group">
                        <input id="email" type="email" placeholder="Password" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group">
                       <input id="password" type="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                       <input id="password-confirm" type="password" placeholder="confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                   
                    <div><button type="submit" class="btn btn-success round-shape">Reset Password</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // jQuery('.mainform').validate({
    //     ignore: [],
    //     errorClass:"error-message",
    //     validClass:"green",
    //     rules:{
    //         email:{
    //             required:true,
    //             email:true,
    //         },
    //         password:{
    //             required:true,
    //         },
           
    //       }      
    //   });

</script>
@endsection        