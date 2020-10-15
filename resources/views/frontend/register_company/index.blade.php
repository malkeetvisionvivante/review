@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
    <div class="card my-3 my-md-5">
        <div class="row p-0">
            <div class="col-md-12">
                <h1 class="mb-4">Company Registration</h1>
            </div>
        </div>
        <form class="mainform" name="add_company" action="{{ url('/add/company/send')}}" method="post">
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
                        <label>Company Name</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name" name="company_name" required />
                        @error('company_name')
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
                        @if(Auth::check())
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" name="email" required value="{{ Auth::user()->email }}" readonly/>
                        @else
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" name="email" required />
                        @endif
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
            company_name:{
                required:true,
            },
            message:{
                required:true,
            },
            
          }  ,
          messages: {
            company_name: {company_name:"Company Name is required field. " },
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