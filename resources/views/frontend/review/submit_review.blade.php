@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/company-detail/'.$company->id) }}">Company</a></li>
            @if($manager)
            	@if($manager->department_id)
            		<li class="breadcrumb-item"><a class="text-muted" href="{{ url('/manager-list/'.$manager->company_id.'/'.$manager->department_id) }}">Department</a></li>
            	@endif
            	<li class="breadcrumb-item"><a class="text-muted" href="{{ url('/manager-detail/'.$manager->id) }}">Colleague</a></li>
            @endif
            <li class="breadcrumb-item active text-primary" aria-current="page">Review</li>
          </ol>
        </nav>
        <div class="card small mt-2">
        <div class="row p-0" id="user_detail">
        </div>
        <div class="row p-0" id="company_detail">
          @if($company && !$manager)
            <div class="col-md-8">
                <div class="media">
                    <div class="media-left">
                        <div class="media-img-container"> 
                            @if($company->logo)
                            <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ url('images/company/'.$company->logo) }}" alt="apple" class="img-fluid" /></a>
                            @else
                             <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ asset('images/company/silmarilli.svg')}}" alt="apple" class="img-fluid" /></a>
                            @endif
                        </div>
                    </div>
                    <div class="media-body pr-2">
                        <a href="{{ url('company-detail/'.$company->id)}}"><h3>{{ $company->company_name}}</h3></a>
                        <h6 class="text-muted">{{ $company->comp_type($company->company_type)}}</h6>
                            @if($company->fullAddress())
                            <h6 class="text-muted d-none d-md-block"><i class="fas fa-building"></i> {{ $company->fullAddress() }}</h6>
                            @endif
                            @if($company->no_of_employee)
                            <h6 class="text-muted">Employees: {{ $company->no_of_employee}}</h6>
                            @endif  
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
              <div class="company-overall-score company-overall-score-vertical float-md-right">
                <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $company->overallManagerReview(),'text' => 'Overall manager score']) </div>
                <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $company->overallPeerReview(),'text' => 'Overall peer score']) </div>
              </div>
            </div>
            @endif
            @if($manager)
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
            @endif
        </div>
    </div>

     <form name="questions" action="{{ url('/submit_review')}}" method="post">
      @csrf
      <input type="hidden" name="initiate_time" value="{{ $initiateTime }}">
      <input type="hidden" name="origination_source" value="{{ $origination_source }}"> 
      @if($manager)
      <input type="hidden" name="manager_name" class="manager_name_hidden" value="{{ $manager->name.' '.$manager->last_name }}"> 
      <input type="hidden" name="manager_id" class="manager_hidden" value="{{ $manager->id }}"> 
      <input type="hidden" name="department_id" class="department_hidden" value="{{ $manager->department_id }}">
      @endif
    <div class="card small-card mt-2">
        <div id="msform">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="rating-progress progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            @if(!$manager)
            <fieldset>
                <div class="row p-0">
                    <div class="col-md-12">
                        <h3 class="font-weight-700">Submit your review</h3>
                        <span class="text-muted">All reviews are anonymous</span>
                       
                        <h6 class="mt-3 mb-1">Are you currently working in this company?</h6>
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="company_id" value="{{$company->id}}"> 
                            <input type="hidden" name="currently_working_in_company" class="currently_working_in_company_hidden" value='1'> 
                            <input type="checkbox" class="custom-control-input currently_working_in_company" value='1' id="switch2" checked>
                            <label class="custom-control-label" id="current_working_in_company_label" for="switch2" style="font-size:16px;">Yes</label>
                        </div>
                    </div>
                  <div class="col-md-12 mt-3">  
                    @if($alreadyReview)
                      <div class="float-right h6 text-blue"> You have already reviewed this user today!</div>
                    @elseif(!Auth::user()->isAbleToAdd())
                      <div class="float-right h6 text-blue"> Conduct reviews on profiles is block due to spam behavior!</div>
                    @else
                      <a href="javascript:void(0)" class="next float-right h6 text-blue">Next <i class="fas fa-arrow-right"></i></a>
                    @endif
                </div>
                </div>
            </fieldset>
            <!-- List of Departmants -->
            <fieldset>
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="department_id" class="department_hidden"> 
                  <h6 class="mb-4 r-font-weight-500 font-weight-700">Select colleague’s department</h6>
                  <ul class="department-ull">
                    @if(count($departments))  
                      @foreach($departments as $department)
                        @if($company && $company->comp_type($company->company_type) != "Consulting" && $department->name === "Consulting, Research & Solutions") @continue @endif
                        <li>
                          <a class="choose_dep" data-id="{{ $department->id}}">
                            {{ $department->name}}
                            <sup><i class="department-detail fas fa-info-circle text-muted" data-id="#model_id_{{ $department->id}}"></i></sup>
                          </a>
                        </li>
                      @endforeach
                    @endif 
                    <li class="align-self-center d-block d-md-inline-block">
                      <a href="#" class="w-100 btn btn-custom-design" data-toggle="modal" data-target="#request_new_department">
                        Add department
                      </a>
                    </li>  
                  </ul>
                </div>
                <div class="col-md-12 mt-3 error-class department-error"> Please select any Department!</div>
                <div class="col-md-12 mt-3">  
                    <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="javascript:void(0)" class="next float-right h6 text-blue department_next">Next <i class="fas fa-arrow-right"></i></a>
                </div>
              </div>
            </fieldset>

            <!-- List of Managers -->
            <fieldset>
              <input type="hidden" name="manager_name" class="manager_name_hidden"> 
              <input type="hidden" name="manager_id" class="manager_hidden"> 
                <div class="row show_manager"></div>
            </fieldset>
            @endif

            <!-- List of static Question Start -->
            <fieldset>
                <div class="row p-0">
                    <div class="col-md-12">
                        <h3 class="font-weight-700">Submit your review</h3>
                        <span class="text-muted">All reviews are anonymized</span>
                        @if($manager)
                        <h6 class="mt-3 mb-1">Are you currently working with {{ $manager->name}} {{ $manager->last_name}}?</h6>
                        @else
                        <h6 class="mt-3 mb-1">Are you currently working with <span class="manager-name"></span>?</h6>
                        @endif
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="company_id" value="{{$company->id}}"> 
                            <input type="hidden" name="currently_working_with" class="currently_working_with_hidden" value='1'> 
                            <input type="checkbox" class="custom-control-input currently_working_with" value='1' id="switch1" checked>
                            <label class="custom-control-label" id="current_working_with_label" for="switch1" style="font-size:16px;">Yes</label>
                        </div>
                    </div>
                  <div class="col-md-12 mt-3">  
                    @if($alreadyReview)
                      <div class="float-right h6 text-blue"> You have already reviewed this user today!</div>
                    @elseif(!Auth::user()->isAbleToAdd())
                      <div class="float-right h6 text-blue"> Conduct reviews on profiles is block due to spam behavior!</div>
                    @else
                      @if(!$manager)
                      <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                      @endif
                      <a href="javascript:void(0)" class="next float-right h6 text-blue">Next <i class="fas fa-arrow-right"></i></a>
                    @endif
                </div>
                </div>
            </fieldset>

            <!-- List of static Question Start -->
            <fieldset class="static-question-list">
                <div class="row p-0">
                    <div class="col-md-12">
                        <h3 class="font-weight-700">Submit your review</h3>
                        <span class="text-muted">All reviews are anonymized</span>
                        @if($manager)
                          <h6 class="mt-3 mb-1">
                            In what capacity <span class="do-did">do </span> you work with {{ $manager->name}} {{ $manager->last_name}}?
                          </h6>
                        @else
                          <h6 class="mt-3 mb-1">
                            In what capacity <span class="do-did">do </span> you work with <span class="manager-name"></span>?
                          </h6>
                        @endif
                        <div class="custom-control d-flex pl-0 mt-2"> 
                            <input type="radio" class=" manager_capacity mt-1" value='Manager' name="working_as" checked id="capacity_manager">
                            <label class="manager-capacity-label ml-2 my-0" for="capacity_manager">
                              @if($manager)
                                {{ $manager->name}} {{ $manager->last_name}} <span class="was-is">is </span> my direct manager or other leader in my organization.
                              @else
                                <span class="manager-name"></span> <span class="was-is">is </span> my direct manager or other leader in my organization.
                              @endif
                            </label>
                        </div>
                        <div class="custom-control d-flex pl-0 mt-2"> 
                            <input type="radio" class=" manager_capacity mt-1" value='Peer' name="working_as" id="capacity_peer">
                            <label class="manager-capacity-label ml-2 my-0" for="capacity_peer">
                              @if($manager)
                                {{ $manager->name}} {{ $manager->last_name}} <span class="was-is">is </span> my peer.
                              @else
                                <span class="manager-name"></span> <span class="was-is">is </span> my peer.
                              @endif
                            </label>
                        </div>
                    </div>
                  <div class="col-md-12 mt-3">             
                      <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                      <a href="javascript:void(0)" class="next float-right h6 text-blue" id="category_question_next">Next <i class="fas fa-arrow-right"></i></a>
                </div>
                </div>
            </fieldset>
            <!-- List of Dymanic Question For manager -->
            @foreach($ReviewCategory as $category)
              @if($category->question_count1($category->id,'Manager') > 0)
                <fieldset class="questions-set">
                    <div class="row p-0">
                        <div class="col-md-12">
                            @if($manager)
                            <h4 class="mb-3 font-weight-700">Review {{ $manager->name}} {{ $manager->last_name}} across the following qualities</h4>
                            @else
                            <h4 class="mb-3 font-weight-700">Review <span class="manager-name"></span> across the following qualities</h4>
                            @endif
                        </div>
                        <div class="col-md-12 {{ $category->id }}_class">
                            <div class="table-responsive mt-4 mt-md-0">
                            <table class="table custom-table mb-0">
                                <tr>
                                    <th>Qualities<span class="font-weight-normal">: {{ $category->name }}</span></th>
                                    <th class="text-right">Rate the quality</th>
                                </tr>
                            </table>
                            </div>
                            <table class="table custom-table table-striped">
                               @foreach($questions as $question)
                                @if($question->category_id == $category->id)
                                  <tr>
                                      <td>{{ $question->question }}</td>
                                      <td  class="text-right" style="white-space:nowrap;">
                                        <input type="hidden" class="question_{{$question->id}}" name="question[{{ $category->id }}][{{$question->id}}]">
                                        <i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_1"></i> 
                                        <i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_2"></i> 
                                        <i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_3"></i> 
                                        <i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
                                        <i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
                                      </td>
                                  </tr>
                                @endif
                              @endforeach
                            </table>
                             <div class="col-md-12 mt-3 error-class question-error {{$category->name}}-error"> Please answer all of the questions.</div>                        
                             <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                            <a href="javascript:void(0)" data="{{ $category->id }}" class="next float-right h6 text-blue">Next <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </fieldset>
                @endif
              @endforeach

              <fieldset>
                <div class="row p-0">
                    <div class="col-md-12">
                        <h3 class="font-weight-700">Submit your review</h3>
                        <span class="text-muted">All reviews are anonymous</span>
                        @if($manager)
                          <h6 class="mt-3 mb-1">
                            Would you recommend working with {{ $manager->name}} {{ $manager->last_name}} to a friend?
                          </h6>
                        @else
                          <h6 class="mt-3 mb-1">
                            Would you recommend working with <span class="manager-name"></span> to a friend?
                          </h6>
                        @endif
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="recommend_working_with" class="recommend_working_with_hidden" value='1'> 
                            <input type="checkbox" class="custom-control-input recommend_working_with" value='1' id="switch3" checked>
                            <label class="custom-control-label" id="recommend_working_with_label" for="switch3" style="font-size:16px;">Yes</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if($manager)
                          <h6 class="mt-3 mb-1">
                            What advice would you give to {{ $manager->name}} {{ $manager->last_name}} to further improve?
                          </h6>
                        @else
                          <h6 class="mt-3 mb-1">
                            What advice would you give to <span class="manager-name"></span> to further improve?
                          </h6>
                        @endif
                        <div class="mt-3">
                            <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                  <div class="col-md-12">  
                    <div class="mb-3 mt-1 text-muted" style="display: block;"> Character limit #<span class="comment-length">0</span>/750.</div>
                    <div class="error-class mb-3  error-class comment-error mt-1"> Please enter a comment.</div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-6 text-right">
                          <button type="submit" class="submit btn btn-success round-shape" data="{{ $category->id }}">Submit<br><small>(anonymous)</small></button> 
                        </div>
                    </div>
                </div>
                </div>
              </fieldset>
      </div>
    </div>
  </form>
</div> 

<!--Add Department Popup Html -->
@include('frontend.review.add_department_popup')
<!--Add Manager Popup Html -->
@include('frontend.review.add_manager_popup')
<!--Add Department Detail Popup Html -->
<div class="department-detail-popups">
@include('frontend.review.department_detail_popup')           
</div>
<script>
  $(document).ready(function(){

    var department = null;
    var manager = null;
    var managerName = null;
    var currently_working_with = 0;
    var currently_working_in_company = 0;
    var recommend_working_with = 0;

    //Add Manager Title Suggestions
    // $('#search_title').keypress(function(){
    //   $.ajax({
    //       url: "{{ url('/load-titles') }}",
    //       type: "post",
    //       data: { data: jQuery(this).val() , "_token": "{{ csrf_token() }}"},
    //       success : function(data) { 
    //           $('#title_list option').remove();
    //           $('#title_list').prepend(data); 
    //       },
    //       error : function(data) {}
    //     });
    // });
    // $('#title_list option').click(function(){
    //   $(this).next().focus();
    // });

    //Select Department And load its Managers
    $(document).on('click', ".choose_dep",function(){
      $('.choose_dep').removeClass('active');
      $(this).addClass('active');
      var id = $(this).attr('data-id');
      $("#department-id").val(id);
      $(".create_manger_department_hidden").val(id);
      $.ajax({
        url: "{{ url('/get_manager/review')}}/" + id+"/{{$company->id}}",
        type: "get",
        success : function(data) { 
           $('.show_manager').empty();
           $('.show_manager').html(data);
           $('#questions_div').addClass('disabledbutton');
        },
        error : function(data) {}
      });
    });

    //Questions List After Select Peer or Manager
    $(document).on('click', ".manager_capacity",function(){
      var working_as = $("input[name='working_as']:checked").val();
      var manager_name = $(".manager_name_hidden").val();
      $('#category_question_next').addClass('disabled_next_link');
      $.ajax({
        url: "{{ url('/get_question/review')}}",
        data: { working_as: working_as, "_token": "{{ csrf_token() }}","manager_name":manager_name},
        type: "post",
        success : function(data) { 
          $('.questions-set').remove();
          $('.static-question-list').after(data);
          $('#category_question_next').removeClass('disabled_next_link');
        },
      });
    });

    //Set Question Rate
    $(document).on('click','.question',function(){
      var rate = $(this).attr('data');
      var question_id = $(this).attr('data-que');
      $('.question-error').hide();
      $('.question_'+question_id).val(rate);
      for (var i = 1; i <= 5; i++) {
        $('.question_'+question_id+'_'+i).addClass('text-muted');
        $('.question_'+question_id+'_'+i).removeClass('text-red border-red');
        $('.question_'+question_id+'_'+i).removeClass('text-yellow border-yellow');
        $('.question_'+question_id+'_'+i).removeClass('text-green border-green');
      }
      if(rate <3){
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-red border-red');
        }
      } else if(rate >=3 && rate < 4){
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-yellow border-yellow');
        }
      } else {
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-green border-green');
        }
      }
    });

    //Currentally working with question
    $('.currently_working_with').click(function(){
      if($(this).prop("checked") == true){
        currently_working_with = 1;
        $('#current_working_with_label').text('Yes');
        $('.do-did').text('do');
        $('.was-is').text('is');
      } else {
        $('#current_working_with_label').text('No');
        $('.do-did').text('did');
        $('.was-is').text('was');
        currently_working_with = 0;
      }
      $('.currently_working_with_hidden').val(currently_working_with);
    }); 

    //Recommend working with question
    $('.recommend_working_with').click(function(){
      if($(this).prop("checked") == true){
        recommend_working_with = 1;
        $('#recommend_working_with_label').text('Yes');
      } else {
        $('#recommend_working_with_label').text('No');
        recommend_working_with = 0;
      }
      $('.recommend_working_with_hidden').val(recommend_working_with);
    }); 

    //Currentlly Working in company or not 
    $('.currently_working_in_company').click(function(){
      if($(this).prop("checked") == true){
        currently_working_in_company = 1;
        $('#current_working_in_company_label').text('Yes');

      } else {
        $('#current_working_in_company_label').text('No');
        currently_working_in_company = 0;
      }
      $('.currently_working_in_company_hidden').val(currently_working_in_company);
    });

    //Set Department
    $(document).on('click', ".department-ull li a",function(){
    	department = $(this).attr('data-id');
      $('.department_hidden').val(department);
      $('.department-error').hide();
    });

    //Set User
    $(document).on('click', ".manager_back",function(){
      $('.manager_hidden').val('');
      $('.show_manager li a').removeClass('active');
      $('#user_detail').hide();
      $('#company_detail').show();
    });
    $(document).on('click', ".show_manager li a",function(){
      $('.show_manager li a').removeClass('active');
      $(this).addClass('active');
      manager = $(this).attr('data-id');
      managerName = $(this).attr('data-manager-name');
       $('.manager_hidden').val(manager);
       $('.manager-name').text(managerName);
       $('.manager_name_hidden').val(managerName);
       $('.manager-error').hide();
       $.ajax({
        url: "{{ url('/get_user_detail/review')}}",
        data: { manager_id: manager, "_token": "{{ csrf_token() }}"},
        type: "post",
        success : function(data) { 
          var data  = JSON.parse(data);
          $('#user_detail').html(data.html).show();
          $('#company_detail').hide();
        },
      });
    });

    //Set comment Count
    $('#comment').keypress(function(e){
      $('.comment-error').hide();
      var commentLength = $(this).val().length;
      if(commentLength >= 750){
        e.preventDefault();
      }
    });

    // Comment Validation
    $('#comment').keyup(function(e){
      $('.comment-error').hide();
      var commentLength = $(this).val().length;
      $('.comment-length').text(commentLength);
    });

    //Submit Review validation
    $('button.submit').click(function(){
        if($('#comment').val() == ''){
          $('.comment-error').text('Please enter a comment.').show();
          return false;
        }
        var str = $('#comment').val();
        if (!str.replace(/\s/g, '').length) {
          $('.comment-error').text('Only whitespace is not accepted.').show();
          return false;
        }
        if($('#comment').val().length > 750){
          $('.comment-error').text('Comment must be less then 750 Characters.').show();
          return false;
        }
    });

    //Progress bar
    var current_fs, next_fs, previous_fs; 
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;
    setProgressBar(current);
    $(document).on('click', ".next",function(){

      if($(this).hasClass('department_next') && ($('.department_hidden').val() == '')){
        $('.department-error').show();
        return false;
      }

      if($(this).hasClass('manager_next') && (($('.manager_hidden').val() == "") || ($('.manager_hidden').val() == null))) {
        $('.manager-error').show();
        return false;
      }
      if($(this).attr('data')){
        var class1 = $(this).attr('data');
        var error = 0;
        $('.'+class1+'_class input').each(function(){
          if($(this).val() == ''){
            error = 1;
          }
        });
        if(error == 1){
          $('.question-error').show();
          return false;
        }
      }



      current_fs = $(this).parents('fieldset:eq(0)');
      next_fs = $(this).parents('fieldset:eq(0)').next();
      next_fs.show();
      current_fs.animate({opacity: 0}, {
      step: function(now) {
        opacity = 1 - now;
        current_fs.css({ 'display': 'none', 'position': 'relative' });
        next_fs.css({'opacity': opacity});
      }, duration: 500 });
      setProgressBar(++current);
    });

    //Progress Bar Previous
    $(document).on('click', ".previous",function(){
      current_fs = $(this).parents('fieldset:eq(0)');
      previous_fs = $(this).parents('fieldset:eq(0)').prev();
      previous_fs.show();
      current_fs.animate({opacity: 0}, {
        step: function(now) {
        opacity = 1 - now;
        current_fs.css({ 'display': 'none', 'position': 'relative' });
        previous_fs.css({'opacity': opacity});
      },  duration: 500 });
      setProgressBar(--current);
    });

    function setProgressBar(curStep){
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar").css("width",percent+"%")
    };
  });
  

  //Add Manager popup Validation
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

  //Department Popup Validation
  jQuery('#add_department_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        name:{
            required:true,
        },
        description:{
            required:true,
        }
      },
       messages: {
        name: {required:"Name is required field. " },
        description: {required:"Description is required field. " },
      },
    });

    //Create Manager
    $('#add_manager_form').submit(function(){
      if(!$('#add_manager_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/add-manager-for-review') }}",
          type: "post",
          data: { data: $( this ).serialize() , "_token": "{{ csrf_token() }}"},
          success : function(data) { 
            var data  = JSON.parse(data);
            if(data.status == true){
              $('.close').trigger('click');
              $('#add_manager_form input[type=text],#add_manager_form input[type=text]').val('');
              $('#custom_company_field_for_popup').val('{{ $company->company_name }}');


              $('.show_manager li a').removeClass('active');
              manager = data.manager_id;
              managerName = data.manager_name;
               $('.manager_hidden').val(manager);
               $('.manager-name').text(managerName);
               $('.manager_name_hidden').val(managerName);
               $('.manager-error').hide();

              $('ul.show_manager').find(' > li:nth-last-child(1)').before(data.html); 
              $('#questions_div').addClass('disabledbutton');
              $('#user_detail').html(data.manager_detail).show();
              $('#company_detail').hide();
            } else {
              toastr.error('Email already Exist!')
              $('#questions_div').addClass('disabledbutton');
            }
          },
          error : function(data) {}
        });
    });

    //Create Departmant 
    $('#add_department_form').submit(function(){
      if(!$('#add_department_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/add-department-for-review') }}",
          type: "post",
          data: { data: $( this ).serialize() , "_token": "{{ csrf_token() }}", company_id: {{$company->id}} },
          success : function(data) { 
            var data  = JSON.parse(data);
            if(data.status == true){

            	$('.choose_dep').removeClass('active');
				var id = data.id;
				$("#department-id").val(id);				
				$.ajax({
				url: "{{ url('/get_manager/review')}}/" + id+"/{{$company->id}}",
				type: "get",
				success : function(data) { 
				   $('.show_manager').empty();
				   $('.show_manager').html(data);
				   $('#questions_div').addClass('disabledbutton');
				},
				error : function(data) {}
				});

      			$('.department_hidden').val(id);

              	$('.close').trigger('click');
              	$('#add_department_form input[type=text],#add_department_form textarea').val('');
             	$('ul.department-ull').prepend(data.html); 
              $('.department-detail-popups').append(data.popup_models); 
             	$('.create_manger_department_hidden').append(data.option); 
             	$(".create_manger_department_hidden").val(id);
             	$('#questions_div').addClass('disabledbutton');


            } else {
              toastr.error('Something went wrong!')
              //$('.show_manager').empty();
              //$('.show_manager').html(data.html);
              $('#questions_div').addClass('disabledbutton');
            }
          },
          error : function(data) {}
        });
    });

     //For showing department detailed popup
    jQuery(document).ready(function(){
     jQuery(document).on('mouseover','.department-detail', function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).show();
     });
     jQuery(document).on('mouseout','.department-detail', function(){
     //jQuery('.department-detail').mouseout(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).hide();
     });
    });
</script>
<style type="text/css">
  .error-class{color: red; display: none;}
  .department-ull li a {display: inline-block; padding: 8px 20px; background-color: #ebf3fa; border: 1px solid #d7e4ef; border-radius: 3px; color: #000; font-size: 15px; font-weight: 500; position: relative; }
  .department-ull li {display: inline-block; margin: 5px 4px; }
  .department-ull {margin: 0; padding: 0; list-style: none; }
  .department-ull li a.active {border-color:#3aade1;background-color:#3aade1;color:#fff;}
  .department-ull li a.active i{color:#fff !important;}
  form > .thumb{cursor: pointer; }
</style>
@endsection