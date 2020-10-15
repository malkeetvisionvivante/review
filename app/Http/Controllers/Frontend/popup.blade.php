@if(Auth::check())
  @if(Auth::user()->mission_popup == 'no')
  <div class="backdrop">
    <div class="onboarding_flow_modal">
      <div class="step active" id="step_1">
        <a href="#" class="btn-next"  data-item="1">Next</a>
        <h3 class="text-gradient text-center">The Blossom.team mission</h3>
        <h4 class="text-center font-weight-normal mb-5">Our mission is to revolutionize the >33% of our lives that we spend at work by creating a more transparent, accountable, and growth-oriented workplace.</h4>
        <div class="text-center"><img src="{{ asset('images/blossom_logo_background_use2.svg') }}" alt="" class="img-fluid"/></div>
      </div>

      <div class="step" id="step_2">
        <a href="#" class="btn-next" data-item="2">I'm in!</a>
        <h3 class="text-gradient text-center">You now have the power to improve your workplace</h3>
        <div class="media-padding-minus">
        <div class="media align-items-center">
          <div class="media-left mr-3"><img src="{{ asset('images/blossom_icon_colored3.svg') }}" alt="" class="img-fluid"/></div>
          <div class="media-body">
            <p><strong>Share the gift of feedback</strong> – recognize your colleagues’ strengths and help them uncover areas for growth.</p>
          </div>
        </div>
        <div class="media align-items-center">
          <div class="media-left mr-3"><img src="{{ asset('images/blossom_icon_colored1.svg') }}" alt="" class="img-fluid"/></div>
          <div class="media-body">
            <p><strong>Pay it forward</strong> – help prospective colleagues get to know you and your team before they join. </p>
          </div>
        </div>
        <div class="media align-items-center">
          <div class="media-left mr-3"><img src="{{ asset('images/blossom_icon_colored2.svg') }}" alt="" class="img-fluid"/></div>
          <div class="media-body">
            <p><strong>Do your part</strong> – make sure leaders and peers alike are held to the same standards.</p>
          </div>
        </div>
      </div>
      </div>

      <div class="step" id="step_3">
        <a href="#" class="btn-next"  data-item="3">Got it!</a>
        <h3 class="text-gradient text-center">The basics</h3>
        <h4 class="text-center font-weight-normal my-3 my-md-5 ">Feedback shared on Blossom.team <span class="d-inline-block d-md-block">should be constructive, professional,</span> honest, and objective.</h4>
        <span class="bottom-slug text-center">Click here to review our full <a href="{{ url('/about-us') }}" target="blank">Community Guidelines.</a></span>
      </div>

      <div class="step" id="step_4">
        <a href="#" class="btn-next"  data-item="4">Next</a>
        <h3 class="text-gradient text-center">Our Anonymity Pledge</h3>
        <div class="media-padding-minus">
          <h4 class="text-center font-weight-normal my-3 my-md-5 ">Protecting your anonymity is our highest priority.<br><br> Our platform is most valuable when our community feels comfortable sharing <span class="d-inline-block d-md-block">honest assessments.</span> 
          </h4>
        </div>
        <span class="d-none d-md-block bottom-slug text-left">Pro-tip: We recommend using your full name on your <span class="d-block">profile so that we can let you know if anyone ever looks</span> you up, creates a profile for you, or gives you a shout-out!
        </span>
        <span class="d-block d-md-none bottom-slug text-left">Pro-tip: We recommend using your full name on your profile so that we can let you know if anyone ever looks you up, creates a profile for you, or gives you a shout-out!
        </span>
      </div>

      <div class="step" id="step_5">
        <a href="#" class="btn-next disable"  data-item="5" id="s_b_n123">Next</a>
        <div class="media-padding-minus">
        <h3 class="text-gradient text-center">You’re almost ready to Blossom!</h3>
          <h4 class="text-center font-weight-normal mt-3 mt-md-5">Personalize your experience to make the<span class="d-inline-block d-md-block"> most out of our platform.</span> 
          </h4>
        </div>
        <div class="search-box">
          <h4 class="font-weight-normal mt-5 mb-3">Where do you work? </h4>
          <!-- <form > -->
            <input type="hidden" name="_token" value="">                      
              <div class="input-group">
         <!--        <input type="text" name="name" list="company_list" class="form-control search-form-control border-right-0" placeholder="Search companies" id="custom_serach_top1" autocomplete="off"> -->
                <input type="text" placeholder="Search companies" list="company_list" class="form-control search-form-control border-right-0" name="company_name" id="search_company_list" autocomplete="off" value="" >

                                      
              <div class="input-group-prepend">
                <button class="input-group-text form-icon form-icon-small border-left-0"><ion-icon name="search-outline" role="img" class="md hydrated" aria-label="search outline"></ion-icon></button>
              </div>
              </div>
              <datalist id="company_list"></datalist>
              <div><label class="company-error error-message">Please enter your company here.</label></div>
          <!-- </form> -->
        </div>
      </div>

      <div class="step" id="step_6">
        <a href="#" class="btn-next"  data-item="6">Got it!</a>
        <h3 class="text-gradient text-center mb-3">Browse profiles & submit reviews</h3>
        <div class="media-padding-minus">
          <div class="row justify-content-end">
            <div class="col-md-11 text-right">
              <img src="{{ asset('images/search-placeholder.svg') }}" alt="" class="img-fluid w-100"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7 col-8 mt-2">
              <div class="media mb-0 pr-md-4">
                <div class="media-body">
                  <p class="text-right text-blue"><em>Use the search bar to browse companies and colleagues</em></p>
                </div>
                <div class="media-right ml-3"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid"/></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center my-2 my-md-4">
              <a href="javascript:void(0)" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-md-8 col-8">
              <div class="media">
                <div class="media-left mr-3"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid image-flip"/></div>
                <div class="media-body">
                  <p class="text-blue pt-2"><em>Click this button from any page to submit an anonymous review on a peer or manager</em></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="step" id="step_7">
        <a href="#" class="btn-next"  data-item="7">Let’s go!</a>
        <h3 class="text-gradient text-center my-3 my-md-4">Stay in the loop with the newsfeed</h3>
        <div class="media-padding-minus">
          <div class="row">
            <div class="col-md-8 col-10">
              <div class="media align-items-end mb-0">
                <div class="media-left mr-2"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid image-flip bottom" style="width:20px !important;"/></div>
                <div class="media-body">
                  <p class="text-blue pb-2"><em>Click the Blossom.team logo from any page to access your newsfeed</em></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-md-12 mb-4 p-md-0">
              <img src="{{ asset('images/search-placeholder-with-logo.svg') }}" alt="" class="img-fluid"/>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-md-8 col-8">
              <div class="media align-items-end mb-0">
                <div class="media-left mr-2"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid image-flip bottom"/></div>
                <div class="media-body">
                  <p class="text-blue pb-3"><em>Updates on reviews submitted for people in your company</em></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-md-12 p-md-0 my-2">
              <img src="{{ asset('images/newsfeed-tabs.svg') }}" alt="" class="img-fluid"/>
            </div>
          </div>
          <div class="row justify-content-between">
            <div class="col-md-5 col-5 ml-3 ml-md-0 pr-0">
              <div class="media">
                <div class="media-left mr-2"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid image-flip"/></div>
                <div class="media-body">
                  <p class="text-blue pt-3"><em>All reviews submitted across the site</em></p>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-5 pl-md-0 mr-4">
              <div class="media">
                <div class="media-body">
                  <p class="text-right text-blue pt-3"><em>Reviews that you’ve submitted</em></p>
                </div>
                <div class="media-left ml-2"><img src="{{ asset('images/red-arrow.svg') }}" alt="" class="img-fluid image-flip top-right"/></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $('.btn-next').click(function(){
      var itemId = $(this).attr('data-item');
      if(itemId <= 6){
        if(itemId == 5 && $('#search_company_list').val() == ''){
          $('.company-error').show();
          return false;
        }  
        if(itemId == 5 && $('#search_company_list').val() != ''){
          $('.company-error').hide();
          $('#s_b_n123').removeClass('disable');
          $.ajax({
            url: "{{ url('/mission-update-company')}}",
             type: "post",
             data: { data: $('#search_company_list').val() , "_token": "{{ csrf_token() }}"},
             success : function(data) { 
              
            }
          });
        }
        var nextItem = parseInt(itemId) + 1;
        $("#step_"+itemId).removeClass('active');
        $("#step_"+nextItem).addClass('active');
      } else {
        $.ajax({
          url: "{{ url('/mission-end')}}",
          type: "get",
          success : function(data) { 
            if(data.status == true){
              window.location.href = "{{ url('/reviews?myorganization=1') }}";
            }
          }
        });
      }
    });
    $('#search_company_list').keyup(function(){
      if(jQuery(this).val() != ""){
        $('.company-error').hide();
        $('#s_b_n123').removeClass('disable');
      } else {
        $('.company-error').show();
        $('#s_b_n123').addClass('disable');
      }
      $.ajax({
          url: "{{ url('/load-company-list') }}",
          type: "post",
          data: { data: jQuery(this).val() , "_token": "{{ csrf_token() }}"},
          success : function(data) { 
              $('#company_list option').remove();
              $('#company_list').prepend(data); 
          },
          error : function(data) {}
        });
    });
    $('#company_list option').click(function(){
      $(this).next().focus();
    });
  </script>
  <style type="text/css">
    .company-error { display: none; }
  </style>
  @endif
@endif