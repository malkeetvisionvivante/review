@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/company-detail/'.$company->id ) }}">Company</a></li>
    <li class="breadcrumb-item active text-primary" aria-current="page">Department</li>
  </ol>
</nav>
<div class="col-md-12 btn-section-sticky-top text-center">
  <div class="d-block d-md-none">
    <a href="{{ url('add-review-user/'.$company->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
  </div>
</div>
<div class="card card-small mt-2">
        <div class="row p-0">
        <div class="col-md-7">
                <div class="media align-items-center">
                    <div class="media-left">
                        <div class="media-img-container">
                            @if($company->logo)
                            <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ url('images/company/'.$company->logo) }}" alt="apple" class="img-fluid" /></a>
                            @else
                             <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ asset('images/company/silmarilli.svg')}}" alt="apple" class="img-fluid" /></a>
                            @endif
                        </div>
                    </div>
                    <div class="media-body">
                        <a href="{{ url('/company-detail/'.$company->id) }}"><h3> {{ $company->company_name }}</h3></a>
                            <h6 class="text-muted"> {{ $company->company_type_name }} </h6>
                            @if($company->fullAddress())
                              <h6 class="text-muted"><i class="fas fa-building"></i> {{ $company->fullAddress() }}</h6>
                            @endif
                            @if($company->no_of_employee)
                              <h6 class="text-muted">Employees: {{ $company->no_of_employee }}</h6>
                            @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-right score mt-3 mt-md-0">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="company-overall-score company-overall-score-vertical">
                            <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $company->overallManagerReview(),'text' => 'Overall manager score']) </div>
                            <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $company->overallPeerReview(),'text' => 'Overall peer score']) </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="d-none d-md-block">
                        <a href="{{ url('add-review-user/'.$company->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
                      </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    <div class="card card-small mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <h3 class="mb-3">{{ $department->name }} team</h3>
                <ul class="department-ul manager-ul">
                    @if(count($managers) > 0)
                    @foreach($managers as $manager)
                    <li>
                        <a href="{{ url('/manager-detail/'.$manager->id) }}" class="">
                            <div class="media">
                                <div class="media-left">
                                     @if($manager->profile)
                                        <img src="{{ asset('images/users/'.$manager->profile)}}" alt="apple"
                                                class="img-fluid" />
                                      @else
                                        <img src="{{ asset('images/default/user.png') }}" alt="apple"
                                                class="img-fluid" />
                                      @endif
                                </div>
                                <div class="media-body pl-3">
                                    <h6 class="font-weight-600 mb-1">{{ $manager->name}} {{ $manager->last_name}}</h6>
                                    @if((strlen($manager->job_title) > 30))
                                    <h6 class="text-muted mb-0">{{ substr($manager->job_title,0, 30) }} ...</h6>
                                    @else 
                                    <h6 class="text-muted mb-0">{{ $manager->job_title }}</h6>
                                    @endif
                                    <div class="row mt-2">
                                        <div class="col-md-6 pr-md-0 score-flex-responsive">
                                          <div>@include('frontend.user_rating.1_thumb',['rate' => $manager->managerAvg(), 'text' => ''])</div>
                                          <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/manager-score-small.png')}}"/> <span>Manager score</span></div>
                                        </div>
                                        <div class="col-md-6 score-flex-responsive">
                                            <div> @include('frontend.user_rating.1_thumb',['rate' => $manager->peerAvg(), 'text' => '']) </div>
                                            <div class="card-small-score-sec score-in-two-line"><img src="{{ asset('images/peer-score-small.png')}}"/> <span>Peer score</span></div>
                                        </div>
                                      </div>    
                                </div>
                                <!-- <div class="media-right">
                                    @include('frontend.user_rating.1_thumb',['rate' => $manager->manager_review($manager->id),'text' => ''])
                                </div> -->
                            </div>
                        </a>
                    </li>
                    @endforeach
                    @endif
                    @if(Auth::check())
                    <li>
                        <a href="#" class="btn btn-custom-design" data-toggle="modal" data-target="#request_new_manager">
                             Add a new colleague
                        </a>
                    </li> 
                    @else
                      <li>
                        <a href="#" class="btn btn-custom-design" id="request_new_manager_not_login">
                             Add a new colleague
                        </a>
                      </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-12 mt-2">
              {{-- $managers->links() --}}
              <?php $link_limit = 7; ?>
              @if ($managers->lastPage() > 1)
                <ul class="pagination justify-content-lg-start justify-content-center ">
                  <li class="page-item {{ ($managers->currentPage() == 1) ? ' disabled' : '' }}">
                      <a class="page-link" href="{{ $managers->previousPageUrl() }}">‹</a>
                   </li>
                  @for ($i = 1; $i <= $managers->lastPage(); $i++)
                      <?php
                      $half_total_links = floor($link_limit / 2);
                      $from = $managers->currentPage() - $half_total_links;
                      $to = $managers->currentPage() + $half_total_links;
                      if ($managers->currentPage() < $half_total_links) {
                         $to += $half_total_links - $managers->currentPage();
                      }
                      if ($managers->lastPage() - $managers->currentPage() < $half_total_links) {
                          $from -= $half_total_links - ($managers->lastPage() - $managers->currentPage()) - 1;
                      }
                      ?>
                      @if ($from < $i && $i < $to)
                          <li class="page-item {{ ($managers->currentPage() == $i) ? ' active' : '' }}">
                              <a class="page-link" href="{{ $managers->url($i) }}">{{ $i }}</a>
                          </li>
                      @endif
                  @endfor
                  <li class="page-item {{ ($managers->currentPage() == $managers->lastPage()) ? ' disabled' : '' }}">
                      <a class="page-link" href="{{ $managers->nextPageUrl() }}">›</a>
                  </li>
                </ul>
              @endif
            </div>
        </div>
    </div>
</div>

<!-- add manager -->
@if(Auth::check())
@if(Auth::user()->isAbleToAdd())
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New colleague addition</h4>
        <form method="post" id="add_manager_form">
          <input type="hidden" name="company_id" value="{{ $company->id }}"> 
        <!-- <input type="hidden" name="department_id" class="create_manger_department_hidden"> -->
          <div class="row">
             <!-- <div class="col-md-12">
              <div class="form-group">
                <label>Manager’s email</label>
                <input type="text" placeholder="Manager’s email" class="form-control" name="email">
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="form-group">
                <label>First name</label>
                <input type="text" placeholder="First name" class="form-control" name="first_name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last name</label>
                <input type="text" placeholder="Last name" class="form-control" name="last_name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Company</label>
                <input type="text" placeholder="Company" class="form-control" id="custom_company_field_for_popup" value="{{ $company->company_name }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Department</label>
                <input type="hidden" name="department_id" class="form-control create_manger_department_hidden" value="{{ $department->id}}">
                <select class="form-control create_manger_department_hidden" disabled>
                  <option value="">Select</option>
                    <option selected value="{{ $department->id}}">{{ $department->name}}</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Job title</label>
                <!-- <input type="text" placeholder="Job Title" class="form-control" name="job_title"> -->
                <input list="title_list" placeholder="Job title" class="form-control" name="job_title" id="search_title" autocomplete="off">
                <datalist id="title_list"></datalist>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>LinkedIn profile URL</label>
                <input type="text" placeholder="Copy+paste their linkedin profile URL here" class="form-control" value="" name="linkedin_url">
              </div>
            </div>
            <!-- <div class="col-md-6">
              <div class="form-group">
                <label>Manager’s phone number</label>
                <input type="text" placeholder="Manager’s phone number" class="form-control" name="phone">
              </div>
            </div> -->
          </div>
          <button type="submit" class="btn btn-success round-shape">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@else
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New addition rejected.</h4>
        <p>Hey! It looks like you’ve already added 2 new profiles with very similar details, so our system is preventing this action. Please reach out to <b>support@blossom.team</b> if you think this is wrong. </p>
      </div>
    </div>
  </div>
</div>
@endif
@endif
<script type="text/javascript">

    jQuery('#add_manager_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        first_name:{
            required:true,
        },
        last_name:{
            required:true,
        },
        //email:{
            //required:true,
            //email:true,
        //},
        //phone:{
            //required:true,
            ///number: true,
            //maxlength:12,
            //minlength:10,
        //},
        job_title:{
            required:true,
        },
        linkedin_url:{
             url: true,
        },
        department_id:{
            required:true,
        },
      },
       messages: {
        first_name: {required:"First name is required field. " },
        last_name: {required:"Last name is required field. " },
        phone: {required:"Phone number is required field. " },
        job_title: {required:"Job title is required field. " },
        department_id: {required:"Department is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      },
    });
    $('#add_manager_form').submit(function(){
      if(!$('#add_manager_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/add-manager-for-manager-list') }}",
          type: "post",
          data: { data: $( this ).serialize() , "_token": "{{ csrf_token() }}"},
          success : function(data) { 
            var data  = JSON.parse(data);
            if(data.status == true){
              $('.close').trigger('click');
               $('#add_manager_form input[type=text],#add_manager_form input[type=text], #search_title').val('');
              $('#custom_company_field_for_popup').val('{{ $company->company_name }}');
             $('ul.manager-ul').find(' > li:nth-last-child(1)').before(data.html); 
            } else {
              toastr.error('Email already Exist!')
              //$('.show_manager').empty();
              //$('.show_manager').html(data.html);
              $('#questions_div').addClass('disabledbutton');
            }
          },
          error : function(data) {}
        });
    });

    $('#request_new_manager_not_login').click(function(){
        window.location.href = "{{ url('/login-user') }}";
        toastr.error('Please login first.')
    });

</script>
@endsection