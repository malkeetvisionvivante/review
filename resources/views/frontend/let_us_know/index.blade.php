@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
    <div class="card my-3 my-md-5">
        <div class="row p-0">
            <div class="col-md-12">
                <h2 class="mb-4">Primary site: Support, Help, Feedback ticket form submission</h2>
            </div>
        </div>
        <form class="mainform" name="help" action="{{ url('/let-us-know/info/send')}}" method="post">
          @csrf
            <div class="form-group">
                <div class="row p-0">
                    <div class="col-md-2">
                        <label>Subject</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" name="subject" required />
                        @error('subject')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{  $message}}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row p-0">
                    <div class="col-md-2">
                        <label>Email</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" name="email" required />
                        @error('email')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{  $message}}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row p-0">
                    <div class="col-md-2">
                        <label>Message</label>
                    </div>
                    <div class="col-md-10">
                        <textarea  class="form-control textarea-height @error('message') is-invalid @enderror" placeholder="Message" name="message"></textarea>
                        @error('message')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{  $message}}</strong>
                                </span>
                        @enderror
                        <div>
                            <button type="submit" class="btn btn-success round-shape mt-3">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
      jQuery('.mainform').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            email:{
                required:true,
                email:true,
            },
            subject:{
                required:true,
            },
            message:{
                required:true,
            },
            
          },
           messages: {
            subject: {required:"subject is required field. " },
            message: {required:"Message is required field. " },
            email: {
              required: "Email is required field.",
              email: "Your email address must be in the format of name@domain.com"
            }
        }
      });
 </script>
@endsection        